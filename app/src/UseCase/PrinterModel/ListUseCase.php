<?php

namespace App\UseCase\PrinterModel;

use App\DtoFactory\Response\PrinterModel\PrinterModelResponseDtoListFactory;
use App\Service\PrusaSlicerService;
use JsonException;
use Psr\Cache\InvalidArgumentException;

readonly class ListUseCase
{
    public function __construct(
        private PrusaSlicerService $prusaSlicerService,
        private PrinterModelResponseDtoListFactory $printerModelResponseDtoListFactory
    ) {
    }

    /**
     * @throws JsonException
     * @throws InvalidArgumentException
     */
    public function handle(): array
    {
        $data = $this->prusaSlicerService->getPrinterModels();

        $printerModels = [];
        foreach ($data['printer_models'] as $printerModel) {
            $printerModels[] = $printerModel;
        }

        return $this->printerModelResponseDtoListFactory->create($printerModels);
    }
}
