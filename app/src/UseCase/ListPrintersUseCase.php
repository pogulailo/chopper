<?php

namespace App\UseCase;

use App\DtoFactory\Response\Printer\PrinterModelResponseDtoListFactory;
use App\Service\PrusaSlicerService;
use JsonException;
use Psr\Cache\InvalidArgumentException;

final readonly class ListPrintersUseCase
{
    public function __construct(
        private PrusaSlicerService $prusaSlicerService,
        private PrinterModelResponseDtoListFactory $printerModelResponseDtoListFactory,
    ) {
    }

    /**
     * @throws JsonException
     * @throws InvalidArgumentException
     */
    public function handle(): array
    {
        $response = $this->prusaSlicerService->getPrinterModels();
        $printerModels = $response['printer_models'] ?? [];

        return $this->printerModelResponseDtoListFactory->create($printerModels);
    }
}
