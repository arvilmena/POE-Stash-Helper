<?php


namespace App\Service\POEItemAppraiserService;


use App\Service\POEItemAppraiserService\Util\POEItemModValueExtractorService;
use App\Util\StringUtil;
use App\Value\POEAppraisalPassingScore;
use App\Value\POEBelts;

class POEAppraiseBeltService {

    /**
     * @var POEBelts
     */
    private $poeBelts;
    /**
     * @var POEAppraisalPassingScore
     */
    private $passingScore;

    public function __construct(POEBelts $poeBelts, POEAppraisalPassingScore $passingScore)
    {

        $this->poeBelts = $poeBelts;
        $this->passingScore = $passingScore;
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
        if ( $tally['explicitMods']['flatLife'] >= 70 ) {
            $points++;
        }
        if ( $tally['explicitMods']['flatLife'] >= 80 ) {
            $points++;
        }
        if ( $tally['explicitMods']['flatLife'] >= 90 ) {
            $points++;
            $points++;
        }

        if ( $tally['explicitMods']['flaskChargesGained'] >= 21 ) {
            $points++;
        }
        if ( $tally['explicitMods']['flaskChargesUsed'] >= 18 ) {
            $points++;
        }
        if ( $tally['explicitMods']['flaskChargesUsed'] >= 20 ) {
            $points++;
        }

        // flat mana
        if ( $tally['explicitMods']['flatMana'] >= 60 ) {
            $points++;
        }
        if ( $tally['explicitMods']['flatMana'] >= 65 ) {
            $points++;
            $points++;
        }

        // flat ES
        if ( $tally['explicitMods']['flatES'] >= 38 ) {
            $points++;
        }
        if ( $tally['explicitMods']['flatES'] >= 44 ) {
            $points++;
            $points++;
        }

        // elemental attack
        if ( $tally['explicitMods']['increasedElementalDamageWithAtk'] >= 37 ) {
            $points++;
        }
        if ( $tally['explicitMods']['increasedElementalDamageWithAtk'] >= 43 ) {
            $points++;
            $points++;
        }

        if (
            (!empty($item['influences']))
            && (intval($item['ilvl']) >= 80)
            && ( in_array($item['baseType'], $this->poeBelts->getAllTier1()) )
        ) {
            $points = $points + $this->passingScore::BELT_PASSING_SCORE;
            $points = $points + (intval($item['ilvl']) - 80);
        }

        return [
            'points' => $points,
            'tally' => $tally
        ];

    }

}