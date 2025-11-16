<?php

namespace App\UseCase\Quote;

use App\Dto\Internal\PrusaSlicer\SliceRequestDto;
use App\Dto\Request\Quote\QuoteRequestDto;
use App\Dto\Response\Quote\QuoteResponseDto;
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


