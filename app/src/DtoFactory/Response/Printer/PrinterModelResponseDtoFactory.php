<?php

namespace App\DtoFactory\Response\Printer;

use App\Dto\Response\Printer\PrinterModelResponseDto;

readonly class PrinterModelResponseDtoFactory
{
    public function __construct(
        private PrinterVariantDtoListFactory $printerVariantDtoListFactory,
    ) {
    }

    public function create(array $data): PrinterModelResponseDto
    {
        return new PrinterModelResponseDto(
            ($data['id']),
            ($data['name']),
            ($data['technology']),
            $this->printerVariantDtoListFactory->create($data['variants']),
            ($data['vendor_name']),
            ($data['vendor_id']),
        );
    }
}
