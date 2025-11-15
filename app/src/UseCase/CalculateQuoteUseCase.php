<?php

namespace App\UseCase;

use App\Dto\Internal\PrusaSlicer\SliceRequestDto;
use App\Dto\Request\QuoteRequestDto;
use App\Dto\Response\QuoteResponseDto;
use App\Service\PrusaSlicerService;

final readonly class CalculateQuoteUseCase
{
    public function __construct(
        private PrusaSlicerService $prusaSlicerService,
    ) {
    }

    public function handle(QuoteRequestDto $requestDto): QuoteResponseDto
    {
        $sliceResult = $this->prusaSlicerService->calculateEstimates(
            new SliceRequestDto(
                $requestDto->getModelPath(),
                $requestDto->getPrinterProfile(),
                $requestDto->getPrintProfile(),
                $requestDto->getMaterialProfile(),
            )
        );

        return new QuoteResponseDto(
            $sliceResult->getFilamentWeightInGrams(),
            $sliceResult->getPrintTimeInSeconds(),
        );
    }
}


