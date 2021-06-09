<?php


namespace App\Value;


class POEBodyArmours {

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

    public function getAll2by2Tier1(): array
    {
        return array_merge(
            $this->getTier1Evasion(),
            $this->getTier1ES(),
            $this->getTier1ESEvasion()
        );
    }

    public function getAll2by3Tier1(): array
    {
        return array_merge(
            $this->getTier1Armour(),
            $this->getTier1ArmourEvasion(),
            $this->getTier1ArmourES()
        );
    }

    public function getTier1Armour(): array
    {
        return [
            'Astral Plate',
            'Glorious Plate',
        ];
    }

    public function getTier1Evasion(): array
    {
        return [
            "Assassin's Garb",
            'Zodiac Leather',
        ];
    }

    public function getTier1ES(): array
    {
        return [
            'Vaal Regalia',
        ];
    }

    public function getTier1ArmourEvasion(): array
    {
        return [
            'Triumphant Lamellar',
        ];
    }

    public function getTier1ArmourES(): array
    {
        return [
            "Saintly Chainmail",
        ];
    }

    public function getTier1ESEvasion(): array
    {
        return [
            "Carnal Armour",
            "Sadist Garb",
        ];
    }
}