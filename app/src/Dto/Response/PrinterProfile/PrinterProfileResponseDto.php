<?php

namespace App\Dto\Response\PrinterProfile;

readonly class PrinterProfileResponseDto
{
    public function __construct(
        private string $name,
        private int $extrudersCount,
        private BedDto $bed,
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

    public function getBed(): BedDto
    {
        return $this->bed;
    }
}
