<?php
/**
* POEStashHelper.php file summary.
*
* POEStashHelper.php file description.
*
* @link       https://project.com
*
* @package    Project
*
* @subpackage App\Service
*
* @author     Arvil Meña <arvil@arvilmena.com>
*
* @since      1.0.0
*/

declare(strict_types=1);
namespace App\Service;

use App\Service\POEItemAppraiserService\POEAppraiseAmuletService;
use App\Service\POEItemAppraiserService\POEAppraiseBeltService;
use App\Service\POEItemAppraiserService\POEAppraiseBootsService;
use App\Service\POEItemAppraiserService\POEAppraiseGlovesService;
use App\Service\POEItemAppraiserService\POEAppraiseHelmetService;
use App\Util\StringUtil;

/**
 * Class POEStashHelper.
 *
 * Class POEStashHelper description.
 *
 * @since 1.0.0
 */
class POEStashHelper
{

    /**
     * @var POEWebsiteBrowserService
     */
    private $POEWebsiteBrowserService;
    /**
     * @var POEStashListFetcherService
     */
    private $POEStashListFetcherService;

    public function __construct(POEWebsiteBrowserService $POEWebsiteBrowserService, POEStashListFetcherService $POEStashListFetcherService) {

        $this->POEWebsiteBrowserService = $POEWebsiteBrowserService;
        $this->POEStashListFetcherService = $POEStashListFetcherService;
    }

    public function findHighValueItems() {
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

        $items = [];
        $tabs = [];
        foreach($stashes as $stash) {
            $tab = [
                'i' => $stash['i'],
                'n' => $stash['n']
            ];
            $stashItems = $this->POEStashListFetcherService->getStashAtIndex($this->POEWebsiteBrowserService, $stash['i']);
            if(empty($stashItems)) {
                continue;
            }
            $items = array_merge($items, $stashItems);
            $tab['items'] = $stashItems;
            $tabs[] = $tab;
        }


        foreach($tabs as $stash) {
            $items = $stash['items'];

            if(empty($items)) {
                continue;
            }

            foreach($items as $item) {
                // only identified items
                if (!empty($item['stackSize'])) {
                    continue;
                }
                if (!empty($item['prophecyText'])) {
                    continue;
                }
                if (!empty($item['descrText']) && "Can only be equipped to Heist members." === $item['descrText']) {
                    continue;
                }
                if (
                    !empty($item['descrText'])
                    && (
                        (substr($item['descrText'], 0, strlen('Place into an item socket of the right colour to gain this skill.')) === 'Place into an item socket of the right colour to gain this skill.')
                        || (substr($item['descrText'], 0, strlen('This is a Support Gem.')) === 'This is a Support Gem.')
                    )
                ) {
                    continue;
                }
                if (
                    !empty($item['descrText'])
                    && (substr($item['descrText'], 0, strlen('Right click to drink')) === 'Right click to drink')
                ) {
                    continue;
                }
                if (empty($item['name'])){
                    continue;
                }
                if (true !== $item['identified']){
                    continue;
                }
                if (empty($item['explicitMods'])){
                    continue;
                }

                // check if ring or amulet
                if (
                ($item['w'] === 1 && $item['h'] === 1)
                ) {
                    if( StringUtil::endsWith($item['baseType'], ' Amulet') || StringUtil::endsWith($item['baseType'], ' Talisman') ) {
                        $appraisal = POEAppraiseAmuletService::appraise($item);
                        $points = $appraisal['points'];
                        if ($points > $highestPoint['amulet']) {
                            $highestPoint['amulet'] = $points;
                        }
                        if ($points >= 7) {
                            $goodGears[$stash['n']][] = [
                                'points' => $points,
                                'name' => $item['name'] . ' ' . $item['baseType'],
                                'stashName' => $stash['n'],
                                'item' => $item
                            ];
                        }
                    } elseif ( StringUtil::endsWith($item['baseType'], ' Ring') ) {
                        // ring
                        $appraisal = POEAppraiseAmuletService::appraise($item);
                        $points = $appraisal['points'];
                        if ($points > $highestPoint['ring']) {
                            $highestPoint['ring'] = $points;
                        }
                        if ($points >= 7) {
                            $goodGears[$stash['n']][] = [
                                'points' => $points,
                                'name' => $item['name'] . ' ' . $item['baseType'],
                                'stashName' => $stash['n'],
                                'item' => $item
                            ];
                        }
                    }
                } // ($item['w'] === 1 && $item['h'] === 1)


                elseif ( $item['w'] === 2 && $item['h'] === 2 ) {
                    if( StringUtil::endsWith($item['baseType'], ' Mitts') || StringUtil::endsWith($item['baseType'], ' Gloves') || StringUtil::endsWith($item['baseType'], ' Gauntlets') ) {
                        $appraisal = POEAppraiseGlovesService::appraise($item);
                        $points = $appraisal['points'];
                        if ($points > $highestPoint['gloves']) {
                            $highestPoint['gloves'] = $points;
                        }
                        if ($points >= 7) {
                            $goodGears[$stash['n']][] = [
                                'points' => $points,
                                'name' => $item['name'] . ' ' . $item['baseType'],
                                'stashName' => $stash['n'],
                                'item' => $item
                            ];
                        }
                    }
                    elseif( StringUtil::endsWith($item['baseType'], ' Greaves') || StringUtil::endsWith($item['baseType'], ' Boots') || StringUtil::endsWith($item['baseType'], ' Slippers') ) {
                        $appraisal = POEAppraiseBootsService::appraise($item);
                        $points = $appraisal['points'];
                        if ($points > $highestPoint['boots']) {
                            $highestPoint['boots'] = $points;
                        }
                        if ($points >= 5) {
                            $goodGears[$stash['n']][] = [
                                'points' => $points,
                                'name' => $item['name'] . ' ' . $item['baseType'],
                                'stashName' => $stash['n'],
                                'item' => $item
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
                        if ($points > $highestPoint['helmets']) {
                            $highestPoint['helmets'] = $points;
                        }
                        if ($points >= 8) {
                            $goodGears[$stash['n']][] = [
                                'points' => $points,
                                'name' => $item['name'] . ' ' . $item['baseType'],
                                'stashName' => $stash['n'],
                                'item' => $item
                            ];
                        }
                    }
                } // ( $item['w'] === 2 && $item['h'] === 2 )

                elseif ( $item['w'] === 2 && $item['h'] === 1 ) {
                    if( StringUtil::endsWith($item['baseType'], ' Belt') || StringUtil::endsWith($item['baseType'], ' Sash') || StringUtil::endsWith($item['baseType'], ' Vise') ) {
                        $appraisal = POEAppraiseBeltService::appraise($item);
                        $points = $appraisal['points'];
                        if ($points > $highestPoint['belts']) {
                            $highestPoint['belts'] = $points;
                        }
                        if ($points >= 5) {
                            $goodGears[$stash['n']][] = [
                                'points' => $points,
                                'name' => $item['name'] . ' ' . $item['baseType'],
                                'stashName' => $stash['n'],
                                'item' => $item
                            ];
                        }
                    }
                } // ( $item['w'] === 2 && $item['h'] === 2 )

            }
        }

        return [
            'goodGears' => $goodGears,
            'highestPoints' => $highestPoint,
        ];

    } // findHighValueItems()

}
