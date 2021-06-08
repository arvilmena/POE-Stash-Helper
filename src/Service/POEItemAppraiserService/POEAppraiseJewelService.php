<?php


namespace App\Service\POEItemAppraiserService;


use App\Service\POEItemAppraiserService\Util\POEItemModValueExtractorService;

class POEAppraiseJewelService {


    public static function appraise($item) {

        $points = 0;

        $tally = POEItemModValueExtractorService::tallyMods($item);

        // resistances
        if ( $tally['explicitMods']['totalResistances'] >= 10 ) {
            $points++;
        }

        if ( $tally['explicitMods']['percentLife'] > 0 ) {
            $points++;
            $points++;
        }
        if ( $tally['explicitMods']['percentLife'] >= 7 ) {
            $points++;
            $points++;
        }

        if ( $tally['explicitMods']['percentMana'] > 0 ) {
            $points++;
            $points++;
        }
        if ( $tally['explicitMods']['percentMana'] >= 10 ) {
            $points++;
            $points++;
        }

        if ( $tally['explicitMods']['isCorruptedBloodImmune'] ) {
            $points = $points + 5;
        }
        if ( $tally['implicitMods']['isSilenceImmune'] ) {
            $points = $points + 2;
        }
        if ( $tally['implicitMods']['isHinderImmune'] ) {
            $points = $points + 2;
        }

        return [
            'points' => $points,
            'tally' => $tally
        ];

    }

}