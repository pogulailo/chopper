<?php

namespace App\Dto\Response\Printer;

final readonly class PrintFilamentProfilesResponseDto
{
    /**
     * @param PrintFilamentProfileDto[] $printProfiles
     */
    public function __construct(
        private string $printerProfile,
        private array $printProfiles,
    ) {
    }

    public function getPrinterProfile(): string
    {
        return $this->printerProfile;
    }

    /**
     * @return PrintFilamentProfileDto[]
     */
    public function getPrintProfiles(): array
    {
        return $this->printProfiles;
    }
}
