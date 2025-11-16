<?php

namespace App\Dto\Response\PrinterModel;

readonly class PrinterModelResponseDto
{
    public function __construct(
        private string $id,
        private string $name,
        private string $technology,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTechnology(): string
    {
        return $this->technology;
    }
}
