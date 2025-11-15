<?php

namespace App\CacheWarmer;

use App\Service\PrusaSlicerService;
use JsonException;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;

final readonly class PrinterModelsCacheWarmer implements CacheWarmerInterface
{
    public function __construct(
        private PrusaSlicerService $prusaSlicerService,
    ) {
    }

    /**
     * @throws JsonException
     * @throws InvalidArgumentException
     */
    public function warmUp(string $cacheDir, ?string $buildDir = null): array
    {
        $this->prusaSlicerService->getPrinterModels();

        return [];
    }

    public function isOptional(): bool
    {
        return false;
    }
}


