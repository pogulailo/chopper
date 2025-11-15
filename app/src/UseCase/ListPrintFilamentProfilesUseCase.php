<?php

namespace App\UseCase;

use App\Dto\Response\Printer\PrintFilamentProfilesResponseDto;
use App\DtoFactory\Response\Printer\PrintFilamentProfilesResponseDtoFactory;
use App\Service\PrusaSlicerService;
use JsonException;
use Psr\Cache\InvalidArgumentException;

final readonly class ListPrintFilamentProfilesUseCase
{
    public function __construct(
        private PrusaSlicerService $prusaSlicerService,
        private PrintFilamentProfilesResponseDtoFactory $printFilamentProfilesResponseDtoFactory,
    ) {
    }

    /**
     * @throws JsonException
     * @throws InvalidArgumentException
     */
    public function handle(string $printerProfile): PrintFilamentProfilesResponseDto
    {
        $payload = $this->prusaSlicerService->getPrintFilamentProfiles($printerProfile);

        return $this->printFilamentProfilesResponseDtoFactory->create($payload);
    }
}


