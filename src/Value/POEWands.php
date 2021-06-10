<?php


namespace App\Value;


class POEWands {

    public function getAllTier1(): array
    {
        return array_merge(
            $this->getSpecialBases(),
            $this->getGoodCastSpeedBases(),
            $this->getGoodCritBases(),
            $this->getGoodAPSBases()
        );
    }

    public function getSpecialBases(): array
    {
        return [
            'Convoking Wand',
            'Accumulator Wand',
        ];
    }

    public function getGoodCastSpeedBases() : array
    {
        return [
            'Profane Wand',
            'Heathen Wand',
        ];
    }

    public function getGoodCritBases() : array
    {
        return [
            'Prophecy Wand',
        ];
    }

    public function getGoodAPSBases() : array
    {
        return [
            'Imbued Wand',
        ];
    }

}