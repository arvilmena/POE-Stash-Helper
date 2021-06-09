<?php


namespace App\Value;


class POEBoots {

    public function getAllTier1(): array
    {
        return array_merge(
            $this->getTier1Armour(),
            $this->getTier1ArmourES(),
            $this->getTier1ArmourEvasion(),
            $this->getTier1ES(),
            $this->getTier1ESEvasion(),
            $this->getTier1Evasion()
        );
    }

    public function getTier1Armour(): array
    {
        return [
            'Brimstone Treads',
            'Titan Greaves',
        ];
    }

    public function getTier1Evasion(): array
    {
        return [
            "Stormrider Boots",
            "Slink Boots",
        ];
    }

    public function getTier1ES(): array
    {
        return [
            'Dreamquest Slippers',
            'Sorcerer Boots',
        ];
    }

    public function getTier1ArmourEvasion(): array
    {
        return [
            'Two-Toned Boots',
            'Dragonscale Boots',
        ];
    }

    public function getTier1ArmourES(): array
    {
        return [
            'Two-Toned Boots',
            'Crusader Boots',
        ];
    }

    public function getTier1ESEvasion(): array
    {
        return [
            "Blessed Boots",
            "Two-Toned Boots",
            "Murder Boots",
            "Assassin's Boots",
        ];
    }

}