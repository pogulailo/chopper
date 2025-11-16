<?php

namespace App\Dto\Response\PrintProfile;

readonly class PrintProfileResponseDto
{
    public function __construct(
        private string $name,
        private array $filamentProfiles,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getFilamentProfiles(): array
    {
        return $this->filamentProfiles;
    }

}
