<?php

namespace App\DtoFactory\Response\Printer;

use App\Dto\Response\Printer\PrinterProfileDto;

readonly class PrinterProfileDtoListFactory
{
    public function __construct(
        private PrinterProfileDtoFactory $printerProfileDtoFactory
    ) {
    }

    public function create(array $printerProfiles): array
    {
        return array_map(
            function (array $printerProfile): PrinterProfileDto {
                return $this->printerProfileDtoFactory->create($printerProfile);
            },
            $printerProfiles
        );
    }
}
