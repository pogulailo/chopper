<?php

namespace App\UseCase\PrintProfile;

use App\DtoFactory\Response\PrintProfile\PrintProfileResponseDtoListFactory;
use App\Service\PrusaSlicerService;
use JsonException;
use Psr\Cache\InvalidArgumentException;

readonly class ListUseCase
{
    public function __construct(
        private PrusaSlicerService $prusaSlicerService,
        private PrintProfileResponseDtoListFactory $printProfileResponseDtoListFactory
    ) {
    }

    /**
     * @throws JsonException
     * @throws InvalidArgumentException
     */
    public function handle(string $printerProfileName): array
    {
        $data = $this->prusaSlicerService->getPrintFilamentProfiles($printerProfileName);

        $printProfiles = [];
        foreach ($data['print_profiles'] as $printProfile) {
            $printProfiles[] = $printProfile;
        }

        return $this->printProfileResponseDtoListFactory->create($printProfiles);
    }
}
