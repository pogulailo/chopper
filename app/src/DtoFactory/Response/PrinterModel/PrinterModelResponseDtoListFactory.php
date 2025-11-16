<?php

namespace App\DtoFactory\Response\PrinterModel;

use App\Dto\Response\PrinterModel\PrinterModelResponseDto;

readonly class PrinterModelResponseDtoListFactory
{
    public function __construct(
        private PrinterModelResponseDtoFactory $printerProfileResponseDtoFactory
    ) {
    }

    public function create(array $printerModels): array
    {
        return array_map(
            function (array $printerModel): PrinterModelResponseDto {
                return $this->printerProfileResponseDtoFactory->create($printerModel);
            },
            $printerModels
        );
    }
}
