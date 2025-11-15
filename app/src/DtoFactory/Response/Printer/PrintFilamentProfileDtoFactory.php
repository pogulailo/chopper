<?php

namespace App\DtoFactory\Response\Printer;

use App\Dto\Response\Printer\PrintFilamentProfileDto;

readonly class PrintFilamentProfileDtoFactory
{
    public function create(array $printProfile): PrintFilamentProfileDto
    {
        return new PrintFilamentProfileDto(
            $printProfile['name'],
            $printProfile['filament_profiles'],
        );
    }
}
