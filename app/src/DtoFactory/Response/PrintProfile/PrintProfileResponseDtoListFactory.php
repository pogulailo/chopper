<?php

namespace App\DtoFactory\Response\PrintProfile;

use App\Dto\Response\PrintProfile\PrintProfileResponseDto;

readonly class PrintProfileResponseDtoListFactory
{
    public function __construct(
        private PrintProfileResponseDtoFactory $printProfileResponseDtoFactory
    ) {
    }

    public function create(array $printProfiles): array
    {
        return array_map(
            function (array $printProfile): PrintProfileResponseDto {
                return $this->printProfileResponseDtoFactory->create($printProfile);
            },
            $printProfiles
        );
    }
}
