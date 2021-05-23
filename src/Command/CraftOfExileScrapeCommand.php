<?php

namespace App\Command;

use App\Service\AppConfigurationService;
use App\Service\POECraftOfExileDataImportService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CraftOfExileScrapeCommand extends Command
{
    protected static $defaultName = 'app:coe-import-data';
    protected static $defaultDescription = 'Add a short description for your command';
    /**
     * @var POECraftOfExileDataImportService
     */
    private $craftOfExileDataImportService;
    /**
     * @var AppConfigurationService
     */
    private $appConfigurationService;

    public function __construct(string $name = null, POECraftOfExileDataImportService $craftOfExileDataImportService, AppConfigurationService $appConfigurationService)
    {
        parent::__construct($name);
        $this->craftOfExileDataImportService = $craftOfExileDataImportService;
        $this->appConfigurationService = $appConfigurationService;
    }

    protected function configure(): void
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        foreach (new \DirectoryIterator($this->appConfigurationService->getCraftOfExileScrapedDataDir()) as $fileInfo) {
            if($fileInfo->isDot()) continue;
            if(!$fileInfo->isFile()) continue;
            if('json' !== $fileInfo->getExtension()) continue;

            $io->info('processing: ' . $fileInfo->getPathname());

            $data = file_get_contents($fileInfo->getPathname());

            $this->craftOfExileDataImportService->importData(json_decode($data, true));
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
