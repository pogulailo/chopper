<?php

namespace App\DtoFactory\Response\PrinterProfile;

use App\Dto\Response\PrinterProfile\BedDto;
use App\Dto\Response\PrinterProfile\PrinterProfileResponseDto;

readonly class PrinterProfileResponseDtoFactory
{
    public function create(array $printerProfile): PrinterProfileResponseDto
    {
        $bed = new BedDto(
            $printerProfile['bed']['type'],
            $printerProfile['bed']['width'],
            $printerProfile['bed']['height'],
            $printerProfile['bed']['origin'],
            $printerProfile['bed']['max_print_height'],
        );

        return new PrinterProfileResponseDto(
            $printerProfile['name'],
            $printerProfile['extruders_cnt'],
            $bed,
        );
    }
}
