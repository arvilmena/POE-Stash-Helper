<?php


namespace App\Value;


class POEShields {

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
            'Heat-attuned Tower Shield',
            'Pinnacle Tower Shield',
        ];
    }

    public function getTier1Evasion(): array
    {
        return [
            'Cold-attuned Buckler',
            'Imperial Buckler',
            'Crusader Buckler',
        ];
    }

    public function getTier1ES(): array
    {
        return [
            'Transfer-attuned Spirit Shield',
            'Titanium Spirit Shield',
            'Harmonic Spirit Shield',
        ];
    }

    public function getTier1ArmourEvasion(): array
    {
        return [
            'Elegant Round Shield',
            'Cardinal Round Shield',
        ];
    }

    public function getTier1ArmourES(): array
    {
        return [
            "Archon Kite Shield",
            'Mosaic Kite Shield'
        ];
    }

    public function getTier1ESEvasion(): array
    {
        return [
            "Supreme Spiked Shield"
        ];
    }
}