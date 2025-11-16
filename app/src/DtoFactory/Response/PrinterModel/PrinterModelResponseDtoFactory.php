<?php

namespace App\DtoFactory\Response\PrinterModel;

use App\Dto\Response\PrinterModel\PrinterModelResponseDto;

readonly class PrinterModelResponseDtoFactory
{
    public function create(array $printerModel): PrinterModelResponseDto
    {
        return new PrinterModelResponseDto(
            $printerModel['id'],
            $printerModel['name'],
            $printerModel['technology'],
        );
    }
}
