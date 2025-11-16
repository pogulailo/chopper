<?php

namespace App\DtoFactory\Response\PrinterProfile;

use App\Dto\Response\PrinterProfile\PrinterProfileResponseDto;

readonly class PrinterProfileResponseDtoListFactory
{
    public function __construct(
        private PrinterProfileResponseDtoFactory $printerProfileResponseDtoFactory
    ) {
    }

    public function create(array $printerProfiles): array
    {
        return array_map(
            function (array $printerProfile): PrinterProfileResponseDto {
                return $this->printerProfileResponseDtoFactory->create($printerProfile);
            },
            $printerProfiles
        );
    }
}
