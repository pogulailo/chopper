<?php

namespace App\Dto;

final class SliceRequestDto
{
    public function __construct(
        private readonly string $modelPath,
        private readonly ?string $printerProfile = null,
        private readonly ?string $printProfile = null,
        private readonly ?string $materialProfile = null,
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
