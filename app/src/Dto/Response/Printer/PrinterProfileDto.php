<?php

namespace App\Dto\Response\Printer;

final readonly class PrinterProfileDto
{
    public function __construct(
        private string $name,
        private int $extrudersCount,
        private PrinterBedDto $bed,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getExtrudersCount(): int
    {
        return $this->extrudersCount;
    }

    public function getBed(): PrinterBedDto
    {
        return $this->bed;
    }
}
