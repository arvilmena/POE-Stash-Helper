<?php


namespace App\Value;


class POEHelmets {

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
            'Eternal Burgonet',
            'Royal Burgonet',
        ];
    }

    public function getTier1Evasion(): array
    {
        return [
            'Lion Pelt',
        ];
    }

    public function getTier1ES(): array
    {
        return [
            'Hubris Circlet',
        ];
    }

    public function getTier1ArmourEvasion(): array
    {
        return [
            'Penitent Mask',
            'Nightmare Bascinet',
        ];
    }

    public function getTier1ArmourES(): array
    {
        return [
            "Archdemon Crown",
            'Bone Helmet',
            'Praetor Crown',
            'Demon Crown',
        ];
    }

    public function getTier1ESEvasion(): array
    {
        return [
            "Blizzard Crown",
            "Deicide Mask",
            "Vaal Mask",
        ];
    }

}