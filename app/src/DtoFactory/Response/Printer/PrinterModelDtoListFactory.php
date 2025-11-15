<?php

namespace App\DtoFactory\Response\Printer;

use App\Dto\Response\Printer\PrinterModelDto;

readonly class PrinterModelDtoListFactory
{
    public function __construct(
        private PrinterModelDtoFactory $printerModelDtoFactory
    ) {
    }

    public function create(array $printerModels): array
    {
        return array_map(
            function (array $printerModel): PrinterModelDto {
                return $this->printerModelDtoFactory->create($printerModel);
            },
            $printerModels
        );
    }
}
