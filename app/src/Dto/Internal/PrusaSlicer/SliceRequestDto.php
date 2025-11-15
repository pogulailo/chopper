<?php

namespace App\Dto\Internal\PrusaSlicer;

final readonly class SliceRequestDto
{
    public function __construct(
        private string $modelPath,
        private ?string $printerProfile = null,
        private ?string $printProfile = null,
        private ?string $materialProfile = null,
    ) {
    }

    public function getModelPath(): string
    {
        return $this->modelPath;
    }

    public function getPrinterProfile(): ?string
    {
        return $this->printerProfile;
    }

    public function getPrintProfile(): ?string
    {
        return $this->printProfile;
    }

    public function getMaterialProfile(): ?string
    {
        return $this->materialProfile;
    }
}
