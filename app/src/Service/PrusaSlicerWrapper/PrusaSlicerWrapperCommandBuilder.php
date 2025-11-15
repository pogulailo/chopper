<?php

namespace App\Service\PrusaSlicerWrapper;

class PrusaSlicerWrapperCommandBuilder
{
    private array $arguments = [];

    public function reset(): self
    {
        $this->arguments = [];

        return $this;
    }

    public function enableGCodeExport(): self
    {
        $this->arguments[] = '--gcode';

        return $this;
    }

    public function withDataDir(string $dataDir): self
    {
        $this->arguments[] = sprintf('--datadir=%s', $dataDir);

        return $this;
    }

    public function withPrinterProfile(string $profile): self
    {
        $this->arguments[] = sprintf('--printer-profile=%s', $profile);

        return $this;
    }

    public function withPrintProfile(string $profile): self
    {
        $this->arguments[] = sprintf('--print-profile=%s', $profile);

        return $this;
    }

    public function withMaterialProfile(string $profile): self
    {
        $this->arguments[] = sprintf('--material-profile=%s', $profile);

        return $this;
    }

    public function withPrinterTechnology(string $technology): self
    {
        $this->arguments[] = sprintf('--printer-technology=%s', $technology);

        return $this;
    }

    public function withOutput(string $path): self
    {
        $this->arguments[] = '-o';
        $this->arguments[] = $path;

        return $this;
    }

    public function addModel(string $modelPath): self
    {
        $this->arguments[] = $modelPath;

        return $this;
    }

    public function addArgument(string $argument): self
    {
        $this->arguments[] = $argument;

        return $this;
    }

    public function queryPrinterModels(): self
    {
        $this->arguments[] = '--query-printer-models';

        return $this;
    }

    public function queryPrintFilamentProfiles(): self
    {
        $this->arguments[] = '--query-print-filament-profiles';

        return $this;
    }

    public function addOption(string $option, string $value): self
    {
        $this->arguments[] = $option;
        $this->arguments[] = $value;

        return $this;
    }

    public function build(): array
    {
        return $this->arguments;
    }
}
