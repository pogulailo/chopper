<?php

namespace App\Dto\Internal\PrusaSlicerWrapper;

final readonly class PrusaSlicerWrapperResult
{
    public function __construct(
        private string $stdout,
        private string $stderr,
        private int $exitCode,
    ) {
    }

    public function getStdout(): string
    {
        return $this->stdout;
    }

    public function getStderr(): string
    {
        return $this->stderr;
    }

    public function getExitCode(): int
    {
        return $this->exitCode;
    }
}


