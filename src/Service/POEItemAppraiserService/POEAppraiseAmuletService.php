<?php


namespace App\Service\POEItemAppraiserService;


use App\Service\POEItemAppraiserService\Util\POEItemModValueExtractorService;
use App\Util\StringUtil;
use App\Value\POEAppraisalPassingScore;
use App\Value\POERings;

class POEAppraiseAmuletService {

    /**
     * @var POERings
     */
    private $poeRings;
    /**
     * @var POEAppraisalPassingScore
     */
    private $appraisalPassingScore;

    public function __construct(POERings $poeRings, POEAppraisalPassingScore $appraisalPassingScore) {

        $this->poeRings = $poeRings;
        $this->appraisalPassingScore = $appraisalPassingScore;
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

        if (
            StringUtil::endsWith($item['baseType'], 'Amulet')
            && (!empty($item['influences']))
            && (intval($item['ilvl']) >= 82)
            &&  (
                ! StringUtil::endsWith($item['baseType'], 'Coral Amulet')
                && ! StringUtil::endsWith($item['baseType'], 'Paua Amulet')
                && ! StringUtil::endsWith($item['baseType'], 'Gold Amulet')
            )
        ) {
            $points = $points + $this->appraisalPassingScore::AMULET_PASSING_SCORE;
        }

        if (
            (!empty($item['influences']))
            && in_array($item['baseType'], $this->poeRings->getAllTier1())
            && (intval($item['ilvl']) >= 80)
        ) {
            $points = $points + $this->appraisalPassingScore::AMULET_PASSING_SCORE;
            $points = $points + (intval($item['ilvl']) - 80);
        }

        // high ilvl special bases
        if (
            in_array($item['baseType'], $this->poeRings->getSpecialBases())
            && (intval($item['ilvl']) >= 84)
        ) {
            $points = $points + $this->appraisalPassingScore::AMULET_PASSING_SCORE;
            $points = $points + (intval($item['ilvl']) >= 84);
        }

        return [
            'points' => $points,
            'tally' => $tally
        ];

    }

}