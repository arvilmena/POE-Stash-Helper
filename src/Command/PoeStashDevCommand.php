<?php

namespace App\Command;

use App\Service\POEItemAppraiserService\POEAppraiseAmuletService;
use App\Service\POEItemAppraiserService\POEAppraiseBeltService;
use App\Service\POEItemAppraiserService\POEAppraiseBootsService;
use App\Service\POEItemAppraiserService\POEAppraiseGlovesService;
use App\Service\POEItemAppraiserService\POEAppraiseHelmetService;
use App\Service\POEItemAppraiserService\Util\POEItemModValueExtractorService;
use App\Service\POEStashHelper;
use App\Service\POEStashListFetcherService;
use App\Service\POEWebsiteBrowserService;
use App\Util\StringUtil;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class PoeStashDevCommand extends Command
{
    protected static $defaultName = 'app:poe-stash-dev';
    protected static $defaultDescription = 'Add a short description for your command';
    /**
     * @var POEWebsiteBrowserService
     */
    private $POEWebsiteBrowserService;
    /**
     * @var POEStashListFetcherService
     */
    private $POEStashListFetcherService;
    /**
     * @var LoggerInterface
     */
    private $appLogger;
    /**
     * @var POEStashHelper
     */
    private $poeStashHelper;

    public function __construct(string $name = null,
                                POEWebsiteBrowserService $POEWebsiteBrowserService,
                                POEStashListFetcherService $POEStashListFetcherService,
                                POEStashHelper $poeStashHelper,
                                LoggerInterface $appLogger)
    {
        parent::__construct($name);
        $this->POEWebsiteBrowserService = $POEWebsiteBrowserService;
        $this->POEStashListFetcherService = $POEStashListFetcherService;
        $this->appLogger = $appLogger;
        $this->poeStashHelper = $poeStashHelper;
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

        $result = $this->poeStashHelper->findHighValueItems(true);

        echo json_encode($result, JSON_PRETTY_PRINT);

        return Command::SUCCESS;
    }
}
