<?php


namespace App\Service\POEItemAppraiserService;


use App\Service\POEItemAppraiserService\Util\POEItemModValueExtractorService;
use App\Value\POEAppraisalPassingScore;
use App\Value\POEShields;

class POEAppraiseShieldService {

    /**
     * @var POEAppraisalPassingScore
     */
    private $passingScore;
    /**
     * @var POEShields
     */
    private $poeShields;

    public function __construct(POEShields $poeShields, POEAppraisalPassingScore $passingScore) {
        $this->passingScore = $passingScore;
        $this->poeShields = $poeShields;
    }

    public function appraise($item): array
    {

        $points = 0;

        $tally = POEItemModValueExtractorService::tallyMods($item);

        // % life
        if ( $tally['implicitMods']['percentLife'] > 0 ) {
            $points++;
            $points++;
        }
        if ( $tally['explicitMods']['percentLife'] > 0 ) {
            $points++;
            $points++;
        }

        if ( !empty($item['influences']) ) {

            // if tier 1
            if ( in_array($item['baseType'], $this->poeShields->getAllTier1()) ) {
                $points = $points + $this->passingScore::SHIELD_PASSING_SCORE;
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