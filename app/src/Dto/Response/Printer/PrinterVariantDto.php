<?php

namespace App\Dto\Response\Printer;

final readonly class PrinterVariantDto
{
    public function __construct(
        private string $name,
        private array $printerProfiles,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return PrinterProfileDto[]
     */
    public function getPrinterProfiles(): array
    {
        return $this->printerProfiles;
    }
}
