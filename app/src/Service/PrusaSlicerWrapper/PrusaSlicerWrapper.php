<?php

namespace App\Service\PrusaSlicerWrapper;

use App\Dto\Internal\PrusaSlicerWrapper\PrusaSlicerWrapperResult;
use RuntimeException;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Process\Exception\ProcessTimedOutException;
use Symfony\Component\Process\Process;

readonly class PrusaSlicerWrapper
{
    public function __construct(
        #[Autowire('%kernel.project_dir%')]
        private string $projectDir,
        private string $executable = 'prusa-slicer',
        private int $timeout = 900,
    ) {
    }

    public function run(PrusaSlicerWrapperCommandBuilder $commandBuilder): PrusaSlicerWrapperResult
    {
        $arguments = array_merge([$this->executable], $commandBuilder->build());
        $process = new Process($arguments, $this->projectDir, null, null, $this->timeout);
        $stdoutBuffer = '';
        $stderrBuffer = '';

        try {
            $process->run(static function (string $type, string $buffer) use (&$stdoutBuffer, &$stderrBuffer): void {
                if ($type === Process::OUT) {
                    $stdoutBuffer .= $buffer;
                }

                if ($type === Process::ERR) {
                    $stderrBuffer .= $buffer;
                }
            });
        } catch (ProcessTimedOutException $exception) {
            throw new RuntimeException(
                sprintf('PrusaSlicer timed out after %d seconds.', $this->timeout),
                previous: $exception
            );
        }

        if (!$process->isSuccessful()) {
            throw new RuntimeException(
                sprintf(
                    'PrusaSlicer failed with exit code %d. STDERR: %s',
                    $process->getExitCode(),
                    $stderrBuffer !== '' ? $stderrBuffer : '<empty>'
                )
            );
        }

        return new PrusaSlicerWrapperResult($stdoutBuffer, $stderrBuffer, $process->getExitCode());
    }
}
