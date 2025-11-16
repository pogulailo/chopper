<?php

namespace App\DtoFactory\Response\PrintProfile;

use App\Dto\Response\PrintProfile\PrintProfileResponseDto;

readonly class PrintProfileResponseDtoFactory
{
    public function create(array $printProfile): PrintProfileResponseDto
    {
        return new PrintProfileResponseDto(
            $printProfile['name'],
            $printProfile['filament_profiles'],
        );
    }
}
