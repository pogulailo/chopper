<?php

namespace App\Service;

use App\Dto\Internal\PrusaSlicer\SliceEstimationResultDto;
use App\Dto\Internal\PrusaSlicer\SliceRequestDto;
use App\Service\PrusaSlicerWrapper\GCodeMetadataParser;
use App\Service\PrusaSlicerWrapper\PrusaSlicerWrapper;
use App\Service\PrusaSlicerWrapper\PrusaSlicerWrapperCommandBuilder;
use JsonException;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;
use RuntimeException;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Uid\Uuid;
use Throwable;

readonly class PrusaSlicerService
{
    public function __construct(
        #[Autowire('%kernel.project_dir%')]
        private string $projectDir,
        private PrusaSlicerWrapperCommandBuilder $slicerWrapperCommandBuilder,
        private PrusaSlicerWrapper $slicerWrapper,
        private GCodeMetadataParser $gCodeMetadataParser,
        #[Autowire(service: 'cache.app')]
        private CacheItemPoolInterface $cachePool,
        private string $dataDir = '/home/app/datadir',
    ) {
    }

    /**
     * @throws RuntimeException
     */
    public function calculateEstimates(SliceRequestDto $requestDto): SliceEstimationResultDto
    {
        $modelPath = $this->resolvePath($requestDto->getModelPath());
        if (!is_readable($modelPath)) {
            throw new RuntimeException(sprintf('Model path "%s" is not readable.', $modelPath));
        }

        $outputPath = $this->generateOutputPath('gcode');

        $printerProfile = $requestDto->getPrinterProfile();
        $printProfile = $requestDto->getPrintProfile();
        $materialProfile = $requestDto->getMaterialProfile();

        if ($printerProfile === null || $printProfile === null || $materialProfile === null) {
            throw new RuntimeException('Printer, print and material profiles must be provided.');
        }

        $command = $this->slicerWrapperCommandBuilder
            ->reset()
            ->enableGCodeExport()
            ->withDataDir($this->dataDir)
            ->withPrinterProfile($printerProfile)
            ->withPrintProfile($printProfile)
            ->withMaterialProfile($materialProfile)
            ->withOutput($outputPath)
            ->addModel($modelPath);

        $this->slicerWrapper->run($command);

        if (!is_readable($outputPath)) {
            throw new RuntimeException(sprintf('Expected G-code output not found at "%s".', $outputPath));
        }

        $gCodeContents = file_get_contents($outputPath);
        if ($gCodeContents === false) {
            throw new RuntimeException(sprintf('Unable to read G-code output at "%s".', $outputPath));
        }

        $filamentWeight = $this->gCodeMetadataParser->extractFloat(
            $gCodeContents,
            '/; filament used \[g] = ([\d.]+)/i'
        );
        $printTimeRaw = $this->gCodeMetadataParser->extractString(
            $gCodeContents,
            '/; estimated printing time \(normal mode\) = ([^\n]+)/i'
        );
        $printTimeSeconds = $this->convertPrusaTimeToSeconds($printTimeRaw);

        return new SliceEstimationResultDto($filamentWeight, $printTimeSeconds);
    }

    /**
     * @throws JsonException
     * @throws InvalidArgumentException
     */
    public function getPrinterModels(): array
    {
        $cacheItem = $this->cachePool->getItem('prusa_slicer.printer_models');

        if ($cacheItem->isHit()) {
            $cachedValue = $cacheItem->get();

            return is_array($cachedValue) ? $cachedValue : [];
        }

        $outputPath = $this->generateOutputPath('json');

        $command = $this->slicerWrapperCommandBuilder
            ->reset()
            ->withDataDir($this->dataDir)
            ->withPrinterTechnology('FFF')
            ->queryPrinterModels()
            ->withOutput($outputPath);

        try {
            $this->slicerWrapper->run($command);
        } catch (RuntimeException) {
        }

        if (!is_readable($outputPath)) {
            throw new RuntimeException(sprintf('Expected printer model output not found at "%s".', $outputPath));
        }

        $jsonContents = file_get_contents($outputPath);
        if ($jsonContents === false) {
            throw new RuntimeException(sprintf('Unable to read printer model output at "%s".', $outputPath));
        }

        if (!json_validate($jsonContents)) {
            throw new RuntimeException('Unable to decode printer model response from PrusaSlicer.');
        }

        $decoded = json_decode($jsonContents, true, flags: JSON_THROW_ON_ERROR);

        $cacheItem->set($decoded);
        $this->cachePool->save($cacheItem);

        return $decoded;
    }

    private function resolvePath(string $path): string
    {
        return str_starts_with($path, DIRECTORY_SEPARATOR)
            ? $path
            : $this->projectDir . DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR);
    }

    private function convertPrusaTimeToSeconds(string $time): int
    {
        $seconds = 0;

        if (preg_match('/(\d+)\s*h/', $time, $hoursMatch)) {
            $seconds += (int)$hoursMatch[1] * 3600;
        }

        if (preg_match('/(\d+)\s*m/', $time, $minutesMatch)) {
            $seconds += (int)$minutesMatch[1] * 60;
        }

        if (preg_match('/(\d+)\s*s/', $time, $secondsMatch)) {
            $seconds += (int)$secondsMatch[1];
        }

        if ($seconds === 0) {
            throw new RuntimeException(sprintf('Unable to parse time string "%s".', $time));
        }

        return $seconds;
    }

    private function generateOutputPath(string $extension): string
    {
        try {
            $uuid = Uuid::v4()->toRfc4122();
        } catch (Throwable $exception) {
            throw new RuntimeException(
                'Unable to generate unique filename for PrusaSlicer output.',
                previous: $exception
            );
        }

        $extension = ltrim($extension, '.');

        return sys_get_temp_dir() . DIRECTORY_SEPARATOR . $uuid . '.' . $extension;
    }
}
