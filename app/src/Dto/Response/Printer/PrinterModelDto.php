<?php

namespace App\Dto\Response\Printer;

final readonly class PrinterModelDto
{
    public function __construct(
        private string $id,
        private string $name,
        private string $technology,
        private array $variants,
        private string $vendorName,
        private string $vendorId,
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

    /**
     * @return PrinterVariantDto[]
     */
    public function getVariants(): array
    {
        return $this->variants;
    }

    public function getVendorName(): string
    {
        return $this->vendorName;
    }

    public function getVendorId(): string
    {
        return $this->vendorId;
    }
}
