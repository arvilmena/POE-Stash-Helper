<?php


namespace App\Value;


class POERings {

    public function getAllTier1(): array
    {
        return array_merge(
            $this->getSpecialBases(),
            $this->getGoodBases()
        );
    }

    public function getSpecialBases() : array {
        return [
            'Cerulean Ring',
            'Steel Ring',
            'Vermillion Ring',
            'Iolite Ring',
            'Cogwork Ring',
            'Geodesic Ring',
        ];
    }

    public function getGoodBases() : array {
        return [
            'Amethyst Ring',
            'Prismatic Ring',
            'Vermillion Ring',
            'Iolite Ring',
            'Two-Stone Ring',
            'Ruby Ring',
            'Topaz Ring',
            'Sapphire Ring',
        ];
    }

}