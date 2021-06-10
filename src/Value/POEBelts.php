<?php


namespace App\Value;


class POEBelts {

    public function getAllTier1(): array
    {
        return $this->getSpecialBases();
    }

    public function getSpecialBases() : array {
        return [
            'Stygian Vise',
            'Crystal Belt',
            'Vanguard Belt',
            'Mechalarm Belt',
            'Micro-Distillery Belt',
        ];
    }

    public function getGoodBases() : array {
        return [
            'Leather Belt',
        ];
    }

}