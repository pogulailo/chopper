<?php

namespace App\Dto\Response\Quote;

final readonly class QuoteResponseDto
{
    public function __construct(
        private float $filamentWeightGrams,
        private int $printTimeSeconds,
    ) {
    }

    public function getFilamentWeightGrams(): float
    {
        return $this->filamentWeightGrams;
    }

    public function getPrintTimeSeconds(): int
    {
        return $this->printTimeSeconds;
    }
}


