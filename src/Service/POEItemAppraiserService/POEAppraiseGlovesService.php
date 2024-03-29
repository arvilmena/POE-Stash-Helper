<?php


namespace App\Service\POEItemAppraiserService;


use App\Service\POEItemAppraiserService\Util\POEItemModValueExtractorService;
use App\Value\POEAppraisalPassingScore;
use App\Value\POEGloves;

class POEAppraiseGlovesService {

    /**
     * @var POEGloves
     */
    private $poeGloves;
    /**
     * @var POEAppraisalPassingScore
     */
    private $passingScore;

    public function __construct(POEGloves $poeGloves, POEAppraisalPassingScore $passingScore) {
        $this->poeGloves = $poeGloves;
        $this->passingScore = $passingScore;
    }

    public function appraise($item): array
    {

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
        if ( $tally['explicitMods']['flatLife'] >= 90 ) {
            $points++;
        }
        if ( $tally['explicitMods']['flatLife'] >= 100 ) {
            $points++;
        }
        if ( $tally['explicitMods']['flatLife'] >= 110 ) {
            $points++;
        }

        // flat mana
        if ( $tally['explicitMods']['flatMana'] >= 65 ) {
            $points++;
        }
        if ( $tally['explicitMods']['flatMana'] >= 69 ) {
            $points++;
        }
        if ( $tally['explicitMods']['flatMana'] >= 74 ) {
            $points++;
        }

        // flat ES
        if ( $tally['explicitMods']['flatES'] >= 31 ) {
            $points++;
        }
        if ( $tally['explicitMods']['flatES'] >= 39 ) {
            $points++;
        }
        if ( $tally['explicitMods']['flatES'] >= 49 ) {
            $points++;
        }

        // flat Evasion
        if ( $tally['explicitMods']['flatEvasion'] >= 36 ) {
            $points++;
        }
        if ( $tally['explicitMods']['flatEvasion'] >= 61 ) {
            $points++;
        }

        if ( !empty($item['influences']) ) {

            // if tier 1
            if ( in_array($item['baseType'], $this->poeGloves->getAllTier1()) ) {
                $points = $points + $this->passingScore::GLOVES_PASSING_SCORE;
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