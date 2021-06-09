<?php


namespace App\Service\POEItemAppraiserService;


use App\Service\POEItemAppraiserService\Util\POEItemModValueExtractorService;
use App\Value\POEAppraisalPassingScore;
use App\Value\POEBodyArmours;
use App\Value\POEGloves;

class POEAppraiseBodyArmourService {

    /**
     * @var POEBodyArmours
     */
    private $poeBodyArmours;
    /**
     * @var POEAppraisalPassingScore
     */
    private $passingScore;

    public function __construct(POEBodyArmours $poeBodyArmours, POEAppraisalPassingScore $passingScore) {
        $this->poeBodyArmours = $poeBodyArmours;
        $this->passingScore = $passingScore;
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
            if ( in_array($item['baseType'], $this->poeBodyArmours->getAllTier1()) ) {
                $points = $points + $this->passingScore::BODY_ARMOUR_PASSING_SCORE;
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