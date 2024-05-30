<?php

namespace App\Command;

use App\Repository\LogEntryRepository;
use App\Service\LogImport;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:sync-log',
    description: 'Sync log file with Log analytics API',
)]
class SyncLogCommand extends Command
{
    public function __construct(
        private LogEntryRepository $logEntryRepository,
        private LogImport $logImport
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('path', InputArgument::REQUIRED, 'path to log file');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $logPath = $input->getArgument('path');
        if(!file_exists($logPath)) {
            $io->error('Log file not found');
            return Command::FAILURE;
        }

        $lastEntry = $this->logEntryRepository->findLastImportedEntry();
        $this->logImport->import($logPath, $lastEntry);

        $io->success("{$logPath} synced successfully");
        return Command::SUCCESS;
    }


}
