<?php

namespace App\DtoFactory\Response\Printer;

use App\Dto\Response\Printer\PrinterVariantDto;

readonly class PrinterVariantDtoFactory
{
    public function __construct(
        private PrinterProfileDtoListFactory $printerProfileDtoListFactory,
    ) {
    }

    public function create(array $data): PrinterVariantDto
    {
        return new PrinterVariantDto(
            $data['name'],
            $this->printerProfileDtoListFactory->create($data['printer_profiles']),
        );
    }
}
