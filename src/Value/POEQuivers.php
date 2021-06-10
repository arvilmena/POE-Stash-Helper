<?php


namespace App\Value;


class POEQuivers {

    public function getAllTier1(): array
    {
        return array_merge(
            $this->getSpecialBases(),
            $this->getGoodBases()
        );
    }

    public function getSpecialBases() : array {
        return [
            'Artillery Quiver',
            'Ornate Quiver',
        ];
    }

    public function getGoodBases() : array {
        return [
            'Penetrating Arrow Quiver',
            'Broadhead Arrow Quiver',
            'Spike-Point Arrow Quiver',
        ];
    }

}