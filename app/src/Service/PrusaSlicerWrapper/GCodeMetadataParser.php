<?php

namespace App\Service\PrusaSlicerWrapper;

use RuntimeException;

final class GCodeMetadataParser
{
    public function extractFloat(string $haystack, string $pattern): float
    {
        return (float)$this->extractString($haystack, $pattern);
    }

    public function extractString(string $haystack, string $pattern): string
    {
        if (!preg_match($pattern, $haystack, $matches) || !isset($matches[1])) {
            throw new RuntimeException(sprintf('Unable to parse data using pattern "%s".', $pattern));
        }

        return trim($matches[1]);
    }
}
