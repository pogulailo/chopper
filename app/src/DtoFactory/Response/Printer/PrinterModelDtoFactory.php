<?php

namespace App\DtoFactory\Response\Printer;

use App\Dto\Response\Printer\PrinterModelDto;

readonly class PrinterModelDtoFactory
{
    public function __construct(
        private PrinterVariantDtoListFactory $printerVariantDtoListFactory,
    ) {
    }

    public function create(array $data): PrinterModelDto
    {
        return new PrinterModelDto(
            ($data['id']),
            ($data['name']),
            ($data['technology']),
            $this->printerVariantDtoListFactory->create($data['variants']),
            ($data['vendor_name']),
            ($data['vendor_id']),
        );
    }
}
