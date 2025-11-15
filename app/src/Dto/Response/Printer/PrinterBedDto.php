<?php

namespace App\Dto\Response\Printer;

final readonly class PrinterBedDto
{
    public function __construct(
        private string $type,
        private int $width,
        private int $height,
        private string $origin,
        private int $maxPrintHeight,
    ) {
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getOrigin(): string
    {
        return $this->origin;
    }

    public function getMaxPrintHeight(): int
    {
        return $this->maxPrintHeight;
    }
}
