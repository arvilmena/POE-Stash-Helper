<?php


namespace App\Service\POEItemAppraiserService;


use App\Service\POEItemAppraiserService\Util\POEItemModValueExtractorService;

class POEAppraiseAmuletService {

    public static function appraise($item) {

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
            $points++;
        }

        // life
        if ( $tally['explicitMods']['flatLife'] >= 50 ) {
            $points++;
        }
        if ( $tally['explicitMods']['flatLife'] >= 60 ) {
            $points++;
        }
        if ( $tally['explicitMods']['flatLife'] >= 70 ) {
            $points++;
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

        //mana regeneration
        if ( $tally['explicitMods']['manaRegeneration'] >= 50 ) {
            $points++;
        }
        if ( $tally['explicitMods']['manaRegeneration'] >= 60 ) {
            $points++;
            $points++;
        }

        // flat mana
        if ( $tally['explicitMods']['flatMana'] >= 69 ) {
            $points++;
        }
        if ( $tally['explicitMods']['flatMana'] >= 74 ) {
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

        return [
            'points' => $points,
            'tally' => $tally
        ];

    }

}