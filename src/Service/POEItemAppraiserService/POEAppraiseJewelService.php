<?php


namespace App\Service\POEItemAppraiserService;


use App\Service\POEItemAppraiserService\Util\POEItemModValueExtractorService;
use App\Value\POEAppraisalPassingScore;

class POEAppraiseJewelService {

    /**
     * @var POEAppraisalPassingScore
     */
    private $passingScore;

    public function __construct(POEAppraisalPassingScore $passingScore)
    {
        $this->passingScore = $passingScore;
    }


    public function appraise($item) {

        $points = 0;

        $tally = POEItemModValueExtractorService::tallyMods($item);

        // resistances
        if ( $tally['explicitMods']['totalResistances'] >= 10 ) {
            $points++;
        }

        if ( $tally['explicitMods']['percentLife'] > 0 ) {
            $points = $points + $this->passingScore::JEWEL_PASSING_SCORE;
        }
        if ( $tally['explicitMods']['percentLife'] >= 7 ) {
            $points++;
        }

        if ( $tally['explicitMods']['percentMana'] > 0 ) {
            $points = $points + $this->passingScore::JEWEL_PASSING_SCORE;
        }
        if ( $tally['explicitMods']['percentMana'] >= 10 ) {
            $points++;
        }

        if ( $tally['explicitMods']['isCorruptedBloodImmune'] ) {
            $points = $points + $this->passingScore::JEWEL_PASSING_SCORE;
        }
        if ( $tally['implicitMods']['isSilenceImmune'] ) {
            $points = $points + $this->passingScore::JEWEL_PASSING_SCORE;
        }
        if ( $tally['implicitMods']['isHinderImmune'] ) {
            $points = $points + $this->passingScore::JEWEL_PASSING_SCORE;
        }

        return [
            'points' => $points,
            'tally' => $tally
        ];

    }

}