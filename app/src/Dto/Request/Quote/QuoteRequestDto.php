<?php

namespace App\Dto\Request\Quote;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class QuoteRequestDto
{
    public function __construct(
        #[Assert\NotBlank]
        private ?string $printerProfile = null,

        #[Assert\NotBlank]
        private ?string $printProfile = null,

        #[Assert\NotBlank]
        private ?string $materialProfile = null,

        #[Assert\NotBlank]
        private ?string $modelPath = null,
    ) {
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

    public function getModelPath(): ?string
    {
        return $this->modelPath;
    }

    public function withModelPath(string $modelPath): self
    {
        return new self(
            $this->printerProfile,
            $this->printProfile,
            $this->materialProfile,
            $modelPath,
        );
    }
}
