<?php

namespace App\DtoFactory\Response\Printer;

use App\Dto\Response\Printer\PrinterProfileDto;

readonly class PrinterProfileDtoFactory
{
    public function __construct(
        private PrinterBedDtoFactory $printerBedDtoFactory,
    ) {
    }

    public function create(array $data): PrinterProfileDto
    {
        return new PrinterProfileDto(
            $data['name'],
            (int)$data['extruders_cnt'],
            $this->printerBedDtoFactory->create($data['bed']),
        );
    }
}
