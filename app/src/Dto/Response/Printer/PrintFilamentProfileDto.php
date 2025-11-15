<?php

namespace App\Dto\Response\Printer;

final readonly class PrintFilamentProfileDto
{
    /**
     * @param string[] $filamentProfiles
     */
    public function __construct(
        private string $name,
        private array $filamentProfiles,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string[]
     */
    public function getFilamentProfiles(): array
    {
        return $this->filamentProfiles;
    }
}
