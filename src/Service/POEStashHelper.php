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
use App\Service\POEItemAppraiserService\POEAppraiseBodyArmourService;
use App\Service\POEItemAppraiserService\POEAppraiseBootsService;
use App\Service\POEItemAppraiserService\POEAppraiseGlovesService;
use App\Service\POEItemAppraiserService\POEAppraiseHelmetService;
use App\Service\POEItemAppraiserService\POEAppraiseJewelService;
use App\Service\POEItemAppraiserService\POEAppraiseShieldService;
use App\Util\StringUtil;
use App\Value\POEAppraisalPassingScore;

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
    /**
     * @var POEAppraiseGlovesService
     */
    private $appraiseGlovesService;
    /**
     * @var POEAppraiseHelmetService
     */
    private $appraiseHelmetService;
    /**
     * @var POEAppraiseBodyArmourService
     */
    private $appraiseBodyArmourService;
    /**
     * @var POEAppraiseBootsService
     */
    private $appraiseBootsService;
    /**
     * @var POEAppraiseShieldService
     */
    private $appraiseShieldService;
    /**
     * @var POEAppraiseBeltService
     */
    private $appraiseBeltService;
    /**
     * @var POEAppraiseAmuletService
     */
    private $appraiseAmuletService;

    public function __construct(POEWebsiteBrowserService $POEWebsiteBrowserService,
                                POEStashListFetcherService $POEStashListFetcherService,
                                POEAppraiseGlovesService $appraiseGlovesService,
                                POEAppraiseHelmetService $appraiseHelmetService,
                                POEAppraiseBodyArmourService $appraiseBodyArmourService,
                                POEAppraiseBootsService $appraiseBootsService,
                                POEAppraiseShieldService $appraiseShieldService,
                                POEAppraiseBeltService $appraiseBeltService,
                                POEAppraiseAmuletService $appraiseAmuletService) {
        $this->POEWebsiteBrowserService = $POEWebsiteBrowserService;
        $this->POEStashListFetcherService = $POEStashListFetcherService;
        $this->appraiseGlovesService = $appraiseGlovesService;
        $this->appraiseHelmetService = $appraiseHelmetService;
        $this->appraiseBodyArmourService = $appraiseBodyArmourService;
        $this->appraiseBootsService = $appraiseBootsService;
        $this->appraiseShieldService = $appraiseShieldService;
        $this->appraiseBeltService = $appraiseBeltService;
        $this->appraiseAmuletService = $appraiseAmuletService;
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
            'jewels' => 0,
            'body_armours' => 0,
            'shields_2x2' => 0,
            'shields_2x3' => 0,
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
                        $appraisal = $this->appraiseAmuletService->appraise($item);
                        $points = $appraisal['points'];
                        if ($points > $highestPoint['amulet']) {
                            $highestPoint['amulet'] = $points;
                        }
                        if ($points >= POEAppraisalPassingScore::AMULET_PASSING_SCORE) {
                            $goodGears[$stash['n']][] = [
                                'points' => $points,
                                'name' => $item['name'] . ' ' . $item['baseType'],
                                'stashName' => $stash['n'],
                                'item' => $item
                            ];
                        }
                    } elseif ( StringUtil::endsWith($item['baseType'], ' Ring') ) {
                        // ring
                        $appraisal = $this->appraiseAmuletService->appraise($item);
                        $points = $appraisal['points'];
                        if ($points > $highestPoint['ring']) {
                            $highestPoint['ring'] = $points;
                        }
                        if ($points >= POEAppraisalPassingScore::RING_PASSING_SCORE) {
                            $goodGears[$stash['n']][] = [
                                'points' => $points,
                                'name' => $item['name'] . ' ' . $item['baseType'],
                                'stashName' => $stash['n'],
                                'item' => $item
                            ];
                        }
                    } elseif ( StringUtil::endsWith($item['baseType'], ' Jewel') ) {
                        // ring
                        $appraisal = POEAppraiseJewelService::appraise($item);
                        $points = $appraisal['points'];
                        if ($points > $highestPoint['jewels']) {
                            $highestPoint['jewels'] = $points;
                        }
                        if ($points >= POEAppraisalPassingScore::JEWEL_PASSING_SCORE) {
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
                        $appraisal = $this->appraiseGlovesService->appraise($item);
                        $points = $appraisal['points'];
                        if ($points > $highestPoint['gloves']) {
                            $highestPoint['gloves'] = $points;
                        }
                        if ($points >= POEAppraisalPassingScore::GLOVES_PASSING_SCORE) {
                            $goodGears[$stash['n']][] = [
                                'points' => $points,
                                'name' => $item['name'] . ' ' . $item['baseType'],
                                'stashName' => $stash['n'],
                                'item' => $item
                            ];
                        }
                    }
                    elseif(
                        StringUtil::endsWith($item['baseType'], ' Greaves')
                        || StringUtil::endsWith($item['baseType'], ' Boots')
                        || StringUtil::endsWith($item['baseType'], ' Slippers')
                        || StringUtil::endsWith($item['baseType'], ' Shoes')
                        || StringUtil::endsWith($item['baseType'], ' Treads')
                    ) {
                        $appraisal = $this->appraiseBootsService->appraise($item);
                        $points = $appraisal['points'];
                        if ($points > $highestPoint['boots']) {
                            $highestPoint['boots'] = $points;
                        }
                        if ($points >= POEAppraisalPassingScore::BOOTS_PASSING_SCORE) {
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
                        $appraisal = $this->appraiseHelmetService->appraise($item);
                        $points = $appraisal['points'];
                        if ($points > $highestPoint['helmets']) {
                            $highestPoint['helmets'] = $points;
                        }
                        if ($points >= POEAppraisalPassingScore::HELMET_PASSING_SCORE) {
                            $goodGears[$stash['n']][] = [
                                'points' => $points,
                                'name' => $item['name'] . ' ' . $item['baseType'],
                                'stashName' => $stash['n'],
                                'item' => $item
                            ];
                        }
                    }
                    elseif(
                        StringUtil::endsWith($item['baseType'], ' Buckler')
                        || StringUtil::endsWith($item['baseType'], ' Spirit Shield')
                        || StringUtil::endsWith($item['baseType'], ' Spiked Shield')
                    ) {
                        $appraisal = $this->appraiseShieldService->appraise($item);
                        $points = $appraisal['points'];
                        if ($points > $highestPoint['shields_2x2']) {
                            $highestPoint['shields_2x2'] = $points;
                        }
                        if ($points >= POEAppraisalPassingScore::SHIELD_PASSING_SCORE) {
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
                        $appraisal = $this->appraiseBeltService->appraise($item);
                        $points = $appraisal['points'];
                        if ($points > $highestPoint['belts']) {
                            $highestPoint['belts'] = $points;
                        }
                        if ($points >= POEAppraisalPassingScore::BELT_PASSING_SCORE) {
                            $goodGears[$stash['n']][] = [
                                'points' => $points,
                                'name' => $item['name'] . ' ' . $item['baseType'],
                                'stashName' => $stash['n'],
                                'item' => $item
                            ];
                        }
                    }
                } // ( $item['w'] === 2 && $item['h'] === 2 )

                elseif ( $item['w'] === 2 && $item['h'] === 3 ) {
                    if(
                        StringUtil::endsWith($item['baseType'], ' Plate')
                        || StringUtil::endsWith($item['baseType'], 'Chestplate')
                        || StringUtil::endsWith($item['baseType'], ' Vest')
                        || StringUtil::endsWith($item['baseType'], ' Vest')
                        || StringUtil::endsWith($item['baseType'], ' Jerkin')
                        || StringUtil::endsWith($item['baseType'], ' Leather')
                        || StringUtil::endsWith($item['baseType'], ' Tunic')
                        || StringUtil::endsWith($item['baseType'], ' Garb')
                        || StringUtil::endsWith($item['baseType'], ' Robe')
                        || StringUtil::endsWith($item['baseType'], ' Vestment')
                        || StringUtil::endsWith($item['baseType'], ' Regalia')
                        || StringUtil::endsWith($item['baseType'], ' Wrap')
                        || StringUtil::endsWith($item['baseType'], ' Silks')
                        || StringUtil::endsWith($item['baseType'], ' Brigandine')
                        || StringUtil::endsWith($item['baseType'], ' Doublet')
                        || StringUtil::endsWith($item['baseType'], ' Armour')
                        || StringUtil::endsWith($item['baseType'], ' Lamellar')
                        || StringUtil::endsWith($item['baseType'], ' Wyrmscale')
                        || StringUtil::endsWith($item['baseType'], ' Dragonscale')
                        || StringUtil::endsWith($item['baseType'], ' Coat')
                        || StringUtil::endsWith($item['baseType'], ' Ringmail')
                        || StringUtil::endsWith($item['baseType'], ' Chainmail')
                        || StringUtil::endsWith($item['baseType'], ' Hauberk')
                        || StringUtil::endsWith($item['baseType'], ' Jacket')
                        || StringUtil::endsWith($item['baseType'], ' Garb')
                        || StringUtil::endsWith($item['baseType'], ' Raiment')
                        || StringUtil::endsWith($item['baseType'], ' Mail')
                    ) {
                        $appraisal = $this->appraiseBodyArmourService->appraise($item);
                        $points = $appraisal['points'];
                        if ($points > $highestPoint['body_armours']) {
                            $highestPoint['body_armours'] = $points;
                        }
                        if ($points >= POEAppraisalPassingScore::BODY_ARMOUR_PASSING_SCORE) {
                            $goodGears[$stash['n']][] = [
                                'points' => $points,
                                'name' => $item['name'] . ' ' . $item['baseType'],
                                'stashName' => $stash['n'],
                                'item' => $item
                            ];
                        }
                    }

                    elseif(
                        StringUtil::endsWith($item['baseType'], ' Tower Shield')
                        || StringUtil::endsWith($item['baseType'], ' Round Shield')
                        || StringUtil::endsWith($item['baseType'], ' Kite Shield')
                    ) {
                        $appraisal = $this->appraiseShieldService->appraise($item);
                        $points = $appraisal['points'];
                        if ($points > $highestPoint['shields_2x2']) {
                            $highestPoint['shields_2x2'] = $points;
                        }
                        if ($points >= POEAppraisalPassingScore::SHIELD_PASSING_SCORE) {
                            $goodGears[$stash['n']][] = [
                                'points' => $points,
                                'name' => $item['name'] . ' ' . $item['baseType'],
                                'stashName' => $stash['n'],
                                'item' => $item
                            ];
                        }
                    }
                } // ( $item['w'] === 2 && $item['h'] === 3 )

            }
        }

        return [
            'goodGears' => $goodGears,
            'highestPoints' => $highestPoint,
        ];

    } // findHighValueItems()

}
