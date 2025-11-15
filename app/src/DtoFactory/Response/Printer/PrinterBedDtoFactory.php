<?php

namespace App\DtoFactory\Response\Printer;

use App\Dto\Response\Printer\PrinterBedDto;

readonly class PrinterBedDtoFactory
{
    public function create(array $bedData): PrinterBedDto
    {
        return new PrinterBedDto(
            $bedData['type'],
            (int)$bedData['width'],
            (int)$bedData['height'],
            $bedData['origin'],
            (int)$bedData['max_print_height'],
        );
    }
}
