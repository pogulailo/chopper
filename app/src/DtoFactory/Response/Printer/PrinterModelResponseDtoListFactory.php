<?php

namespace App\DtoFactory\Response\Printer;

use App\Dto\Response\Printer\PrinterModelResponseDto;

readonly class PrinterModelResponseDtoListFactory
{
    public function __construct(
        private PrinterModelResponseDtoFactory $printerModelResponseDtoFactory
    ) {
    }

    public function create(array $printerModels): array
    {
        return array_map(
            function (array $printerModel): PrinterModelResponseDto {
                return $this->printerModelResponseDtoFactory->create($printerModel);
            },
            $printerModels
        );
    }
}
