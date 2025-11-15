<?php

namespace App\Service;

use App\Dto\SliceEstimationResultDto;
use App\Dto\SliceRequestDto;
use RuntimeException;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Process\Exception\ProcessTimedOutException;
use Symfony\Component\Process\Process;
use Symfony\Component\Uid\Uuid;
use Throwable;

class PrusaSlicerService
{
    private const DEFAULT_TIMEOUT = 900;

    public function __construct(
        #[Autowire('%kernel.project_dir%')]
        private readonly string $projectDir,
        private readonly string $prusaExecutable = 'prusa-slicer',
        private readonly string $dataDir = '/home/app/datadir',
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

        $outputPath = $this->generateOutputPath();

        $printerProfile = $requestDto->getPrinterProfile();
        $printProfile = $requestDto->getPrintProfile();
        $materialProfile = $requestDto->getMaterialProfile();

        if ($printerProfile === null || $printProfile === null || $materialProfile === null) {
            throw new RuntimeException('Printer, print and material profiles must be provided.');
        }

        $commandLine = [
            $this->prusaExecutable,
            '--gcode',
            sprintf('--datadir=%s', $this->dataDir),
            sprintf('--printer-profile=%s', $printerProfile),
            sprintf('--print-profile=%s', $printProfile),
            sprintf('--material-profile=%s', $materialProfile),
            '-o',
            $outputPath,
            $modelPath,
        ];

        $process = new Process($commandLine, $this->projectDir, null, null, self::DEFAULT_TIMEOUT);
        $stdoutBuffer = '';
        $stderrBuffer = '';

        try {
            $process->run(static function (string $type, string $buffer) use (&$stdoutBuffer, &$stderrBuffer): void {
                if ($type === Process::OUT) {
                    $stdoutBuffer .= $buffer;
                }

                if ($type === Process::ERR) {
                    $stderrBuffer .= $buffer;
                }
            });
        } catch (ProcessTimedOutException $exception) {
            throw new RuntimeException(
                sprintf('PrusaSlicer timed out after %d seconds', self::DEFAULT_TIMEOUT),
                previous: $exception,
            );
        }

        if (!$process->isSuccessful()) {
            throw new RuntimeException(
                sprintf(
                    'PrusaSlicer failed with exit code %d. Stderr: %s',
                    $process->getExitCode(),
                    $stderrBuffer !== '' ? $stderrBuffer : '<empty>'
                )
            );
        }

        if (!is_readable($outputPath)) {
            throw new RuntimeException(sprintf('Expected G-code output not found at "%s".', $outputPath));
        }

        $gcodeContents = file_get_contents($outputPath);
        if ($gcodeContents === false) {
            throw new RuntimeException(sprintf('Unable to read G-code output at "%s".', $outputPath));
        }

        $filamentWeight = $this->extractFloat($gcodeContents, '/; filament used \[g] = ([\d.]+)/i');
        $printTimeRaw = $this->extractString($gcodeContents, '/; estimated printing time \(normal mode\) = ([^\n]+)/i');
        $printTimeSeconds = $this->convertPrusaTimeToSeconds($printTimeRaw);

        return new SliceEstimationResultDto($filamentWeight, $printTimeSeconds, $outputPath);
    }

    private function resolvePath(string $path): string
    {
        return str_starts_with($path, DIRECTORY_SEPARATOR)
            ? $path
            : $this->projectDir . DIRECTORY_SEPARATOR . ltrim($path, DIRECTORY_SEPARATOR);
    }

    private function extractFloat(string $haystack, string $pattern): float
    {
        $value = $this->extractString($haystack, $pattern);

        return (float)$value;
    }

    private function extractString(string $haystack, string $pattern): string
    {
        if (!preg_match($pattern, $haystack, $matches) || !isset($matches[1])) {
            throw new RuntimeException(sprintf('Unable to parse data using pattern "%s".', $pattern));
        }

        return trim($matches[1]);
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

    private function generateOutputPath(): string
    {
        try {
            $uuid = Uuid::v4()->toRfc4122();
        } catch (Throwable $exception) {
            throw new RuntimeException(
                'Unable to generate unique filename for PrusaSlicer output.',
                previous: $exception
            );
        }

        return sys_get_temp_dir() . DIRECTORY_SEPARATOR . $uuid . '.gcode';
    }
}
