<?php

namespace App\UseCase;

use App\Dto\Response\Printer\PrinterModelDto;
use App\DtoFactory\Response\Printer\PrinterModelDtoListFactory;
use App\Service\PrusaSlicerService;
use JsonException;
use Psr\Cache\InvalidArgumentException;

final readonly class ListPrintersUseCase
{
    public function __construct(
        private PrusaSlicerService $prusaSlicerService,
        private PrinterModelDtoListFactory $printerModelDtoListFactory,
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

        return $this->printerModelDtoListFactory->create($printerModels);
    }
}
