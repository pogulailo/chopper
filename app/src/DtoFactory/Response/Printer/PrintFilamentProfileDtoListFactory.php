<?php

namespace App\DtoFactory\Response\Printer;

use App\Dto\Response\Printer\PrintFilamentProfileDto;

readonly class PrintFilamentProfileDtoListFactory
{
    public function __construct(
        private PrintFilamentProfileDtoFactory $printFilamentProfileDtoFactory
    ) {
    }

    public function create(array $printerProfiles): array
    {
        return array_map(
            function (array $printerProfile): PrintFilamentProfileDto {
                return $this->printFilamentProfileDtoFactory->create($printerProfile);
            },
            $printerProfiles
        );
    }
}
