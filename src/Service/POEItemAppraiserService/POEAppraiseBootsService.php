<?php


namespace App\Service\POEItemAppraiserService;


use App\Service\POEItemAppraiserService\Util\POEItemModValueExtractorService;
use App\Value\POEAppraisalPassingScore;
use App\Value\POEBodyArmours;
use App\Value\POEBoots;

class POEAppraiseBootsService {
    /**
     * @var POEAppraisalPassingScore
     */
    private $passingScore;
    /**
     * @var POEBoots
     */
    private $poeBoots;

    public function __construct(POEBoots $poeBoots, POEAppraisalPassingScore $passingScore) {
        $this->passingScore = $passingScore;
        $this->poeBoots = $poeBoots;
    }

    public function appraise($item) {

        $points = 0;

        $tally = POEItemModValueExtractorService::tallyMods($item);

        // resistances
        if ( $tally['explicitMods']['totalResistances'] > 70 ) {
            $points++;
        }
        if ( $tally['explicitMods']['totalResistances'] > 90 ) {
            $points++;
        }
        if ( $tally['explicitMods']['totalResistances'] > 110 ) {
            $points++;
            $points++;
        }

        //tier
        foreach(['fire', 'cold', 'lightning'] as $r) {
            if ( $tally['explicitMods'][$r] > 36 ) {
                $points++;
            }
            if ( $tally['explicitMods'][$r] > 42 ) {
                $points++;
            }
            if ( $tally['explicitMods'][$r] > 46 ) {
                $points++;
            }
        }
        //tier chaos
        if ( $tally['explicitMods']['chaos'] > 21 ) {
            $points++;
        }
        if ( $tally['explicitMods']['chaos'] > 26 ) {
            $points++;
        }
        if ( $tally['explicitMods']['chaos'] > 31 ) {
            $points++;
        }

        // % life
        if ( $tally['implicitMods']['percentLife'] > 0 ) {
            $points++;
            $points++;
        }
        if ( $tally['explicitMods']['percentLife'] > 0 ) {
            $points++;
            $points++;
        }

        // craftable
        if ( $tally['openAffix'] < 0 ) {
            $points--;
        }

        // life
        if ( $tally['explicitMods']['flatLife'] >= 60 ) {
            $points++;
        }
        if ( $tally['explicitMods']['flatLife'] >= 70 ) {
            $points++;
        }
        if ( $tally['explicitMods']['flatLife'] >= 80 ) {
            $points++;
            $points++;
        }

        // flat ES
        if ( $tally['explicitMods']['flatES'] >= 31 ) {
            $points++;
        }
        if ( $tally['explicitMods']['flatES'] >= 39 ) {
            $points++;
        }

        // flat mana
        if ( $tally['explicitMods']['flatMana'] >= 65 ) {
            $points++;
        }
        if ( $tally['explicitMods']['flatMana'] >= 69 ) {
            $points++;
        }

        // movementspeed
        if ( $tally['explicitMods']['movementSpeed'] > 25 ) {
            $points++;
        }
        if ( $tally['explicitMods']['movementSpeed'] > 30 ) {
            $points++;
            $points++;
        }
        if ( $tally['explicitMods']['movementSpeed'] >= 35 ) {
            $points++;
        }

        if ( !empty($item['influences']) ) {
            // if tier 1
            if ( in_array($item['baseType'], $this->poeBoots->getAllTier1()) ) {
                $points = $points + $this->passingScore::BOOTS_PASSING_SCORE;
                if (intval($item['ilvl']) >= 80) {
                    $points = $points + (intval($item['ilvl']) - 80);
                }
            }
        }

        return [
            'points' => $points,
            'tally' => $tally
        ];

    }

}