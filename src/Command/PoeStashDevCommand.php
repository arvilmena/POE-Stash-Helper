<?php

namespace App\Command;

use App\Service\POEItemAppraiserService\POEAppraiseAmuletService;
use App\Service\POEItemAppraiserService\POEAppraiseBeltService;
use App\Service\POEItemAppraiserService\POEAppraiseBootsService;
use App\Service\POEItemAppraiserService\POEAppraiseGlovesService;
use App\Service\POEItemAppraiserService\POEAppraiseHelmetService;
use App\Service\POEItemAppraiserService\Util\POEItemModValueExtractorService;
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

    public function __construct(string $name = null, POEWebsiteBrowserService $POEWebsiteBrowserService, POEStashListFetcherService $POEStashListFetcherService, LoggerInterface $appLogger)
    {
        parent::__construct($name);
        $this->POEWebsiteBrowserService = $POEWebsiteBrowserService;
        $this->POEStashListFetcherService = $POEStashListFetcherService;
        $this->appLogger = $appLogger;
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

        $stashes = $this->POEStashListFetcherService->getAllStash($this->POEWebsiteBrowserService);

        // only those that starts with "D" and ends with number as its name:
        // example, D1, D2, D10, D11
        $stashes = array_values(array_filter($stashes, function($stash) {
           return (1 === preg_match('/^D(\d+)$/', $stash['n']));
        }));

//        $stashes = [ $stashes[0] ];

        $goodGears = [];
        $highestPoint = [
            'ring' => 0,
            'amulet' => 0,
            'gloves' => 0,
            'boots' => 0,
            'belts' => 0,
            'helmets' => 0,
        ];

        foreach($stashes as $stash) {
            $io->info('processing stash ' . $stash['i']);
            $items = $this->POEStashListFetcherService->getStashAtIndex($this->POEWebsiteBrowserService, $stash['i']);

            if(empty($items)) {
                continue;
            }

            foreach($items as $item) {
                // only identified items
                $io->info('processing: ' . $item['baseType'] . ' : ' . $item['name']);
                if (!empty($item['stackSize'])) {
                    $io->warning('> skipping stackable currency/fragments');
                    continue;
                }
                if (!empty($item['prophecyText'])) {
                    $io->warning('> skipping prophecy');
                    continue;
                }
                if (!empty($item['descrText']) && "Can only be equipped to Heist members." === $item['descrText']) {
                    $io->warning('> skipping heist gear');
                    continue;
                }
                if (
                    !empty($item['descrText'])
                    && (
                        (substr($item['descrText'], 0, strlen('Place into an item socket of the right colour to gain this skill.')) === 'Place into an item socket of the right colour to gain this skill.')
                        || (substr($item['descrText'], 0, strlen('This is a Support Gem.')) === 'This is a Support Gem.')
                    )
                ) {
                    $io->warning('> skipping gems');
                    continue;
                }
                if (
                    !empty($item['descrText'])
                    && (substr($item['descrText'], 0, strlen('Right click to drink')) === 'Right click to drink')
                ) {
                    $io->warning('> skipping flasks');
                    continue;
                }
                if (empty($item['name'])){
                    $io->warning('> unknown');
                    var_dump($item);
                    continue;
                }
                if (true !== $item['identified']){
                    $io->warning('> not identified');
                    continue;
                }
                if (empty($item['explicitMods'])){
                    $io->warning('> no mods');
                    continue;
                }

                // check if ring or amulet
                if (
                    ($item['w'] === 1 && $item['h'] === 1)
                ) {
                    if( StringUtil::endsWith($item['baseType'], ' Amulet') || StringUtil::endsWith($item['baseType'], ' Talisman') ) {
                        $appraisal = POEAppraiseAmuletService::appraise($item);
                        $points = $appraisal['points'];
                        $io->text('> points: ' . $points);
                        if ($points > $highestPoint['amulet']) {
                            $highestPoint['amulet'] = $points;
                        }
                        if ($points >= 7) {
                            $goodGears[$stash['n']][] = [
                                'points' => $points,
                                'name' => $item['name'] . ' ' . $item['baseType'],
                                'stashName' => $stash['n'],
                            ];
                        }
                    } elseif ( StringUtil::endsWith($item['baseType'], ' Ring') ) {
                        // ring
                        $appraisal = POEAppraiseAmuletService::appraise($item);
                        $points = $appraisal['points'];
                        $io->text('> points: ' . $points);
                        if ($points > $highestPoint['ring']) {
                            $highestPoint['ring'] = $points;
                        }
                        if ($points >= 7) {
                            $goodGears[$stash['n']][] = [
                                'points' => $points,
                                'name' => $item['name'] . ' ' . $item['baseType'],
                                'stashName' => $stash['n'],
                            ];
                        }
                    }
                } // ($item['w'] === 1 && $item['h'] === 1)


                elseif ( $item['w'] === 2 && $item['h'] === 2 ) {
                    if( StringUtil::endsWith($item['baseType'], ' Mitts') || StringUtil::endsWith($item['baseType'], ' Gloves') || StringUtil::endsWith($item['baseType'], ' Gauntlets') ) {
                        $appraisal = POEAppraiseGlovesService::appraise($item);
                        $points = $appraisal['points'];
                        $io->text('> points: ' . $points);
                        if ($points > $highestPoint['gloves']) {
                            $highestPoint['gloves'] = $points;
                        }
                        if ($points >= 7) {
                            $goodGears[$stash['n']][] = [
                                'points' => $points,
                                'name' => $item['name'] . ' ' . $item['baseType'],
                                'stashName' => $stash['n'],
                            ];
                        }
                    }
                    elseif( StringUtil::endsWith($item['baseType'], ' Greaves') || StringUtil::endsWith($item['baseType'], ' Boots') || StringUtil::endsWith($item['baseType'], ' Slippers') ) {
                        $appraisal = POEAppraiseBootsService::appraise($item);
                        $points = $appraisal['points'];
                        $io->text('> points: ' . $points);
                        if ($points > $highestPoint['boots']) {
                            $highestPoint['boots'] = $points;
                        }
                        if ($points >= 5) {
                            $goodGears[$stash['n']][] = [
                                'points' => $points,
                                'name' => $item['name'] . ' ' . $item['baseType'],
                                'stashName' => $stash['n'],
                            ];
                        }
                    }
                    elseif(
                        StringUtil::endsWith($item['baseType'], ' Hat')
                        || StringUtil::endsWith($item['baseType'], ' Helmet')
                        || StringUtil::endsWith($item['baseType'], ' Burgonet')
                        || StringUtil::endsWith($item['baseType'], ' Cap')
                        || StringUtil::endsWith($item['baseType'], 'Tricorne')
                        || StringUtil::endsWith($item['baseType'], ' Hood')
                        || StringUtil::endsWith($item['baseType'], ' Pelt')
                        || StringUtil::endsWith($item['baseType'], ' Circlet')
                        || StringUtil::endsWith($item['baseType'], ' Cage')
                        || StringUtil::endsWith($item['baseType'], ' Helm')
                        || StringUtil::endsWith($item['baseType'], 'Sallet')
                        || StringUtil::endsWith($item['baseType'], ' Mask')
                        || StringUtil::endsWith($item['baseType'], ' Bascinet')
                        || StringUtil::endsWith($item['baseType'], ' Coif')
                        || StringUtil::endsWith($item['baseType'], ' Crown')
                    ) {
                        $appraisal = POEAppraiseHelmetService::appraise($item);
                        $points = $appraisal['points'];
                        $io->text('> points: ' . $points);
                        if ($points > $highestPoint['helmets']) {
                            $highestPoint['helmets'] = $points;
                        }
                        if ($points >= 8) {
                            $goodGears[$stash['n']][] = [
                                'points' => $points,
                                'name' => $item['name'] . ' ' . $item['baseType'],
                                'stashName' => $stash['n'],
                            ];
                        }
                    }
                } // ( $item['w'] === 2 && $item['h'] === 2 )

                elseif ( $item['w'] === 2 && $item['h'] === 1 ) {
                    if( StringUtil::endsWith($item['baseType'], ' Belt') || StringUtil::endsWith($item['baseType'], ' Sash') || StringUtil::endsWith($item['baseType'], ' Vise') ) {
                        $appraisal = POEAppraiseBeltService::appraise($item);
                        $points = $appraisal['points'];
                        $io->text('> points: ' . $points);
                        if ($points > $highestPoint['belts']) {
                            $highestPoint['belts'] = $points;
                        }
                        if ($points >= 5) {
                            $goodGears[$stash['n']][] = [
                                'points' => $points,
                                'name' => $item['name'] . ' ' . $item['baseType'],
                                'stashName' => $stash['n'],
                            ];
                        }
                    }
                } // ( $item['w'] === 2 && $item['h'] === 2 )

            }
        }

        var_dump($goodGears);
        var_dump($highestPoint);

        return Command::SUCCESS;
    }
}
