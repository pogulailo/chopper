<?php

namespace App\UseCase\PrinterProfile;

use App\DtoFactory\Response\PrinterProfile\PrinterProfileResponseDtoListFactory;
use App\Service\PrusaSlicerService;
use JsonException;
use Psr\Cache\InvalidArgumentException;

readonly class ListUseCase
{
    public function __construct(
        private PrusaSlicerService $prusaSlicerService,
        private PrinterProfileResponseDtoListFactory $printerProfileResponseDtoListFactory
    ) {
    }

    /**
     * @throws JsonException
     * @throws InvalidArgumentException
     */
    public function handle(): array
    {
        $data = $this->prusaSlicerService->getPrinterModels();

        $printerProfiles = [];
        foreach ($data['printer_models'] as $printerModel) {
            foreach ($printerModel['variants'] as $variant) {
                foreach ($variant['printer_profiles'] as $printerProfile) {
                    $printerProfiles[] = $printerProfile;
                }
            }
        }

        return $this->printerProfileResponseDtoListFactory->create($printerProfiles);
    }
}
