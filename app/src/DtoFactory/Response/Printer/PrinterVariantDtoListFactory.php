<?php

namespace App\DtoFactory\Response\Printer;

use App\Dto\Response\Printer\PrinterVariantDto;

readonly class PrinterVariantDtoListFactory
{
    public function __construct(
        private PrinterVariantDtoFactory $printerVariantDtoFactory
    ) {
    }

    public function create(array $printerVariants): array
    {
        return array_map(
            function (array $printerVariant): PrinterVariantDto {
                return $this->printerVariantDtoFactory->create($printerVariant);
            },
            $printerVariants
        );
    }
}
