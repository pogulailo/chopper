<?php

namespace App\Dto\Internal\PrusaSlicer;

final readonly class SliceEstimationResultDto
{
    public function __construct(
        private float $filamentWeightInGrams,
        private int $printTimeInSeconds,
    ) {
    }

    public function getFilamentWeightInGrams(): float
    {
        return $this->filamentWeightInGrams;
    }

    public function getPrintTimeInSeconds(): int
    {
        return $this->printTimeInSeconds;
    }
}
