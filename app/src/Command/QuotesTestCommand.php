<?php

namespace App\Command;

use App\Dto\Internal\PrusaSlicer\SliceRequestDto;
use App\Service\PrusaSlicerService;
use RuntimeException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:quotes:test',
    description: 'Run a test command to debug the quote pipeline'
)]
class QuotesTestCommand extends Command
{
    public function __construct(
        private readonly PrusaSlicerService $prusaSlicerService,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('model', InputArgument::OPTIONAL, 'Path to the model to slice', './test.stl')
            ->addOption(
                'printer-profile',
                null,
                InputOption::VALUE_OPTIONAL,
                'Printer profile override',
                'Original Prusa MK4S 0.4 nozzle'
            )
            ->addOption(
                'print-profile',
                null,
                InputOption::VALUE_OPTIONAL,
                'Print profile override',
                '0.20mm STRUCTURAL @MK4S 0.4'
            )
            ->addOption(
                'material-profile',
                null,
                InputOption::VALUE_OPTIONAL,
                'Material/filament profile override',
                'Generic PLA @MK4S'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $modelPath = $input->getArgument('model');
        $printerProfile = $input->getOption('printer-profile');
        $printProfile = $input->getOption('print-profile');
        $materialProfile = $input->getOption('material-profile');

        $io->info(sprintf('Slicing "%s"', $modelPath));

        try {
            $result = $this->prusaSlicerService->calculateEstimates(
                new SliceRequestDto($modelPath, $printerProfile, $printProfile, $materialProfile)
            );
        } catch (RuntimeException $exception) {
            $io->error($exception->getMessage());

            return Command::FAILURE;
        }

        $io->success('PrusaSlicer completed successfully.');

        $io->table(
            ['Metric', 'Value'],
            [
                ['Filament weight (g)', number_format($result->getFilamentWeightInGrams(), 2)],
                ['Print time (seconds)', (string)$result->getPrintTimeInSeconds()],
                ['G-code path', $result->getOutputPath()],
            ]
        );

        return Command::SUCCESS;
    }
}
