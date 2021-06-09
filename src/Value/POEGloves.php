<?php


namespace App\Value;


class POEGloves {

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
            'Debilitation Gauntlets',
            'Spiked Gloves',
            'Titan Gauntlets',
        ];
    }

    public function getTier1Evasion(): array
    {
        return [
            'Sinistral Gloves',
            'Stealth Gloves',
            'Gripped Gloves',
            'Slink Gloves',
        ];
    }

    public function getTier1ES(): array
    {
        return [
            'Fingerless Silk Gloves',
            'Nexus Gloves',
            'Sorcerer Gloves',
        ];
    }

    public function getTier1ArmourEvasion(): array
    {
        return [
            'Dragonscale Gauntlets',
        ];
    }

    public function getTier1ArmourES(): array
    {
        return [
            "Apothecary's Gloves",
            'Crusader Gloves'
        ];
    }

    public function getTier1ESEvasion(): array
    {
        return [
            "Murder Mitts"
        ];
    }

}