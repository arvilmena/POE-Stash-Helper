<?php


namespace App\Service\POEItemAppraiserService\Util;


class POEItemModValueExtractorService {

    const COLD_RESIST_PATTERN = '/(\+(\d+)\% to Cold Resistance)/';
    const FIRE_RESIST_PATTERN = '/(\+(\d+)\% to Fire Resistance)/';
    const LIGHTNING_RESIST_PATTERN = '/(\+(\d+)\% to Lightning Resistance)/';
    const CHAOS_RESIST_PATTERN = '/(\+(\d+)\% to Chaos Resistance)/';
    const ALL_RESIST_PATTERN = '/(\+(\d+)\% to all Elemental Resistance)/';
    const COLD_AND_LIGHTNING_RESIST_PATTERN = '/(\+(\d+)\% to Cold and Lightning Resistances)/';
    const FIRE_AND_COLD_RESIST_PATTERN = '/(\+(\d+)\% to Fire and Cold Resistances)/';
    const FIRE_AND_LIGHTNING_RESIST_PATTERN = '/(\+(\d+)\% to Fire and Lightning Resistances)/';
    const MAX_FLAT_LIFE_PATTERN = '/(\+(\d+) to maximum Life)/';
    const PERCENT_INC_LIFE_PATTERN = '/^((\d+)\% increased maximum Life)/';
    const PERCENT_INC_MANA_PATTERN = '/((\d+)\% increased maximum Mana)/';
    const MANA_REGENERATION_PATTERN = '/((\d+)\% increased Mana Regeneration Rate)/';
    const MOVEMENT_SPEED_PATTERN = '/((\d+)\% increased Movement Speed)/';
    const FLASK_EFFECT_DURATION_PATTERN = '/((\d+)\% increased Flask Effect Duration)/';
    const FLASK_CHARGES_GAINED_PATTERN = '/((\d+)\% increased Flask Charges gained)/';
    const FLASK_CHARGES_USED_PATTERN = '/((\d+)\% reduced Flask Charges used)/';
    const FLAT_ENERGY_SHIELD_PATTERN = '/(\+(\d+) to maximum Energy Shield)/';
    const FLAT_MANA_PATTERN = '/(\+(\d+) to maximum Mana)/';
    const FLAT_EVASION_PATTERN = '/(\+(\d+) to Evasion Rating)/';
    const INCREASED_ELEMENTAL_DAMAGE_PATTERN = '/((\d+)\% increased Elemental Damage with Attack Skills)/';
    const CORRUPTED_BLOOD_IMMUNITY = '/Corrupted Blood cannot be inflicted on you/';
    const SILENCE_IMMUNITY = '/You cannot be Cursed with Silence/';
    const HINDER_IMMUNITY = '/You cannot be Hindered/';
    const PLUS_LEVEL_GEM_SPELL_PHYSICAL = '/(\+(\d+) to Level of all Physical Spell Skill Gems)/';
    const PLUS_LEVEL_GEM_SPELL_CHAOS = '/(\+(\d+) to Level of all Chaos Spell Skill Gems)/';
    const PLUS_LEVEL_GEM_SPELL_COLD = '/(\+(\d+) to Level of all Cold Spell Skill Gems)/';
    const PLUS_LEVEL_GEM_SPELL_FIRE = '/(\+(\d+) to Level of all Fire Spell Skill Gems)/';
    const PLUS_LEVEL_GEM_SPELL_LIGHTNING = '/(\+(\d+) to Level of all Lightning Spell Skill Gems)/';
    const PLUS_DAMAGE_OVERTIME_MULTIPLIER_CHAOS = '/(\+(\d+)\% to Chaos Damage over Time Multiplier)/';

    public static function getFlatDamageOvertimeMultiplierChaos(array $item) : array
    {
        $tally = [
            'implicitMods' => 0,
            'explicitMods' => 0,
        ];
        foreach($tally as $key => $total) {
            if (empty($item[$key])) {
                continue;
            }
            foreach ($item[$key] as $mod) {
                preg_match(self::PLUS_DAMAGE_OVERTIME_MULTIPLIER_CHAOS, $mod, $matches);
                if (!empty($matches) && ! empty($matches[2]) && is_numeric($matches[2])) {
                    $tally[$key] = $tally[$key] + $matches[2];
                }
            }
        }
        return $tally;
    }

    public static function getPlusLevelGemLightningSpell(array $item) : array
    {
        $tally = [
            'implicitMods' => 0,
            'explicitMods' => 0,
        ];
        foreach($tally as $key => $total) {
            if (empty($item[$key])) {
                continue;
            }
            foreach ($item[$key] as $mod) {
                preg_match(self::PLUS_LEVEL_GEM_SPELL_LIGHTNING, $mod, $matches);
                if (!empty($matches) && ! empty($matches[2]) && is_numeric($matches[2])) {
                    $tally[$key] = $tally[$key] + $matches[2];
                }
            }
        }
        return $tally;
    }

    public static function getPlusLevelGemFireSpell(array $item) : array
    {
        $tally = [
            'implicitMods' => 0,
            'explicitMods' => 0,
        ];
        foreach($tally as $key => $total) {
            if (empty($item[$key])) {
                continue;
            }
            foreach ($item[$key] as $mod) {
                preg_match(self::PLUS_LEVEL_GEM_SPELL_FIRE, $mod, $matches);
                if (!empty($matches) && ! empty($matches[2]) && is_numeric($matches[2])) {
                    $tally[$key] = $tally[$key] + $matches[2];
                }
            }
        }
        return $tally;
    }

    public static function getPlusLevelGemColdSpell(array $item) : array
    {
        $tally = [
            'implicitMods' => 0,
            'explicitMods' => 0,
        ];
        foreach($tally as $key => $total) {
            if (empty($item[$key])) {
                continue;
            }
            foreach ($item[$key] as $mod) {
                preg_match(self::PLUS_LEVEL_GEM_SPELL_COLD, $mod, $matches);
                if (!empty($matches) && ! empty($matches[2]) && is_numeric($matches[2])) {
                    $tally[$key] = $tally[$key] + $matches[2];
                }
            }
        }
        return $tally;
    }

    public static function getPlusLevelGemChaosSpell(array $item) : array
    {
        $tally = [
            'implicitMods' => 0,
            'explicitMods' => 0,
        ];
        foreach($tally as $key => $total) {
            if (empty($item[$key])) {
                continue;
            }
            foreach ($item[$key] as $mod) {
                preg_match(self::PLUS_LEVEL_GEM_SPELL_CHAOS, $mod, $matches);
                if (!empty($matches) && ! empty($matches[2]) && is_numeric($matches[2])) {
                    $tally[$key] = $tally[$key] + $matches[2];
                }
            }
        }
        return $tally;
    }

    public static function getPlusLevelGemPhysicalSpell(array $item) : array
    {
        $tally = [
            'implicitMods' => 0,
            'explicitMods' => 0,
        ];
        foreach($tally as $key => $total) {
            if (empty($item[$key])) {
                continue;
            }
            foreach ($item[$key] as $mod) {
                preg_match(self::PLUS_LEVEL_GEM_SPELL_PHYSICAL, $mod, $matches);
                if (!empty($matches) && ! empty($matches[2]) && is_numeric($matches[2])) {
                    $tally[$key] = $tally[$key] + $matches[2];
                }
            }
        }
        return $tally;
    }

    public static function isHinderImmune(array $item) : array
    {
        $tally = [
            'implicitMods' => false,
            'explicitMods' => false,
        ];
        foreach($tally as $key => $total) {
            if (empty($item[$key])) {
                continue;
            }
            foreach ($item[$key] as $mod) {
                preg_match(self::HINDER_IMMUNITY, $mod, $matches);
                if (!empty($matches)) {
                    $tally[$key] = true;
                }
            }
        }
        return $tally;
    }

    public static function isSilenceImmune(array $item) : array
    {
        $tally = [
            'implicitMods' => false,
            'explicitMods' => false,
        ];
        foreach($tally as $key => $total) {
            if (empty($item[$key])) {
                continue;
            }
            foreach ($item[$key] as $mod) {
                preg_match(self::SILENCE_IMMUNITY, $mod, $matches);
                if (!empty($matches)) {
                    $tally[$key] = true;
                }
            }
        }
        return $tally;
    }

    public static function isCorruptedBloodImmune(array $item) : array
    {
        $tally = [
            'implicitMods' => false,
            'explicitMods' => false,
        ];
        foreach($tally as $key => $total) {
            if (empty($item[$key])) {
                continue;
            }
            foreach ($item[$key] as $mod) {
                preg_match(self::CORRUPTED_BLOOD_IMMUNITY, $mod, $matches);
                if (!empty($matches)) {
                    $tally[$key] = true;
                }
            }
        }
        return $tally;
    }

    public static function getPercentIncreasedMana(array $item) : array
    {
        $tally = [
            'implicitMods' => 0,
            'explicitMods' => 0,
        ];
        foreach($tally as $key => $total) {
            if (empty($item[$key])) {
                continue;
            }
            foreach ($item[$key] as $mod) {
                preg_match(self::PERCENT_INC_MANA_PATTERN, $mod, $matches);
                if (!empty($matches) && ! empty($matches[2]) && is_numeric($matches[2])) {
                    $tally[$key] = $tally[$key] + $matches[2];
                }
            }
        }
        return $tally;
    }

    public static function getTotalFlatEvasion(array $item) : array
    {
        $tally = [
            'implicitMods' => 0,
            'explicitMods' => 0,
        ];
        foreach($tally as $key => $total) {
            if (empty($item[$key])) {
                continue;
            }
            foreach ($item[$key] as $mod) {
                preg_match(self::FLAT_EVASION_PATTERN, $mod, $matches);
                if (!empty($matches) && ! empty($matches[2]) && is_numeric($matches[2])) {
                    $tally[$key] = $tally[$key] + $matches[2];
                }
            }
        }
        return $tally;
    }

    public static function getTotalIncreasedElementalDamage(array $item) : array
    {
        $tally = [
            'implicitMods' => 0,
            'explicitMods' => 0,
        ];
        foreach($tally as $key => $total) {
            if (empty($item[$key])) {
                continue;
            }
            foreach ($item[$key] as $mod) {
                preg_match(self::INCREASED_ELEMENTAL_DAMAGE_PATTERN, $mod, $matches);
                if (!empty($matches) && ! empty($matches[2]) && is_numeric($matches[2])) {
                    $tally[$key] = $tally[$key] + $matches[2];
                }
            }
        }
        return $tally;
    }

    public static function getTotalFlatMana(array $item) : array
    {
        $tally = [
            'implicitMods' => 0,
            'explicitMods' => 0,
        ];
        foreach($tally as $key => $total) {
            if (empty($item[$key])) {
                continue;
            }
            foreach ($item[$key] as $mod) {
                preg_match(self::FLAT_MANA_PATTERN, $mod, $matches);
                if (!empty($matches) && ! empty($matches[2]) && is_numeric($matches[2])) {
                    $tally[$key] = $tally[$key] + $matches[2];
                }
            }
        }
        return $tally;
    }

    public static function getTotalFlatEnergyShield(array $item) : array
    {
        $tally = [
            'implicitMods' => 0,
            'explicitMods' => 0,
        ];
        foreach($tally as $key => $total) {
            if (empty($item[$key])) {
                continue;
            }
            foreach ($item[$key] as $mod) {
                preg_match(self::FLAT_ENERGY_SHIELD_PATTERN, $mod, $matches);
                if (!empty($matches) && ! empty($matches[2]) && is_numeric($matches[2])) {
                    $tally[$key] = $tally[$key] + $matches[2];
                }
            }
        }
        return $tally;
    }

    public static function getTotalFlaskChargesUsed(array $item) : array
    {
        $tally = [
            'implicitMods' => 0,
            'explicitMods' => 0,
        ];
        foreach($tally as $key => $total) {
            if (empty($item[$key])) {
                continue;
            }
            foreach ($item[$key] as $mod) {
                preg_match(self::FLASK_CHARGES_USED_PATTERN, $mod, $matches);
                if (!empty($matches) && ! empty($matches[2]) && is_numeric($matches[2])) {
                    $tally[$key] = $tally[$key] + $matches[2];
                }
            }
        }
        return $tally;
    }

    public static function getTotalFlaskChargesGained(array $item) : array
    {
        $tally = [
            'implicitMods' => 0,
            'explicitMods' => 0,
        ];
        foreach($tally as $key => $total) {
            if (empty($item[$key])) {
                continue;
            }
            foreach ($item[$key] as $mod) {
                preg_match(self::FLASK_CHARGES_GAINED_PATTERN, $mod, $matches);
                if (!empty($matches) && ! empty($matches[2]) && is_numeric($matches[2])) {
                    $tally[$key] = $tally[$key] + $matches[2];
                }
            }
        }
        return $tally;
    }

    public static function getTotalFlaskEffectDuration(array $item) : array
    {
        $tally = [
            'implicitMods' => 0,
            'explicitMods' => 0,
        ];
        foreach($tally as $key => $total) {
            if (empty($item[$key])) {
                continue;
            }
            foreach ($item[$key] as $mod) {
                preg_match(self::FLASK_EFFECT_DURATION_PATTERN, $mod, $matches);
                if (!empty($matches) && ! empty($matches[2]) && is_numeric($matches[2])) {
                    $tally[$key] = $tally[$key] + $matches[2];
                }
            }
        }
        return $tally;
    }

    public static function getTotalIncreaseMovementSpeed(array $item) : array
    {
        $tally = [
            'implicitMods' => 0,
            'explicitMods' => 0,
        ];
        foreach($tally as $key => $total) {
            if (empty($item[$key])) {
                continue;
            }
            foreach ($item[$key] as $mod) {
                preg_match(self::MOVEMENT_SPEED_PATTERN, $mod, $matches);
                if (!empty($matches) && ! empty($matches[2]) && is_numeric($matches[2])) {
                    $tally[$key] = $tally[$key] + $matches[2];
                }
            }
        }
        return $tally;
    }

    public static function getTotalIncreaseManaRegeneration(array $item) : array
    {
        $tally = [
            'implicitMods' => 0,
            'explicitMods' => 0,
        ];
        foreach($tally as $key => $total) {
            if (empty($item[$key])) {
                continue;
            }
            foreach ($item[$key] as $mod) {
                preg_match(self::MANA_REGENERATION_PATTERN, $mod, $matches);
                if (!empty($matches) && ! empty($matches[2]) && is_numeric($matches[2])) {
                    $tally[$key] = $tally[$key] + $matches[2];
                }
            }
        }
        return $tally;
    }

    public static function getTotalColdResistance(array $item) : array
    {
        $tally = [
            'implicitMods' => 0,
            'explicitMods' => 0,
        ];
        foreach($tally as $key => $total) {
            if (empty($item[$key])) {
                continue;
            }
            foreach ($item[$key] as $mod) {
                preg_match(self::COLD_RESIST_PATTERN, $mod, $matches);
                if (!empty($matches) && ! empty($matches[2]) && is_numeric($matches[2])) {
                    $tally[$key] = $tally[$key] + $matches[2];
                }
                preg_match(self::COLD_AND_LIGHTNING_RESIST_PATTERN, $mod, $matches);
                if (!empty($matches) && ! empty($matches[2]) && is_numeric($matches[2])) {
                    $tally[$key] = $tally[$key] + $matches[2];
                }
                preg_match(self::FIRE_AND_COLD_RESIST_PATTERN, $mod, $matches);
                if (!empty($matches) && ! empty($matches[2]) && is_numeric($matches[2])) {
                    $tally[$key] = $tally[$key] + $matches[2];
                }
                preg_match(self::ALL_RESIST_PATTERN, $mod, $matches);
                if (!empty($matches) && ! empty($matches[2]) && is_numeric($matches[2])) {
                    $tally[$key] = $tally[$key] + $matches[2];
                }
            }
        }
        return $tally;
    }

    public static function getTotalFireResistance(array $item) : array
    {
        $tally = [
            'implicitMods' => 0,
            'explicitMods' => 0,
        ];
        foreach($tally as $key => $total) {
            if (empty($item[$key])) {
                continue;
            }
            foreach ($item[$key] as $mod) {
                preg_match(self::FIRE_RESIST_PATTERN, $mod, $matches);
                if (!empty($matches) && ! empty($matches[2]) && is_numeric($matches[2])) {
                    $tally[$key] = $tally[$key] + $matches[2];
                }
                preg_match(self::FIRE_AND_LIGHTNING_RESIST_PATTERN, $mod, $matches);
                if (!empty($matches) && ! empty($matches[2]) && is_numeric($matches[2])) {
                    $tally[$key] = $tally[$key] + $matches[2];
                }
                preg_match(self::FIRE_AND_COLD_RESIST_PATTERN, $mod, $matches);
                if (!empty($matches) && ! empty($matches[2]) && is_numeric($matches[2])) {
                    $tally[$key] = $tally[$key] + $matches[2];
                }
                preg_match(self::ALL_RESIST_PATTERN, $mod, $matches);
                if (!empty($matches) && ! empty($matches[2]) && is_numeric($matches[2])) {
                    $tally[$key] = $tally[$key] + $matches[2];
                }
            }
        }
        return $tally;
    }

    public static function getTotalLightningResistance(array $item) : array
    {
        $tally = [
            'implicitMods' => 0,
            'explicitMods' => 0,
        ];
        foreach($tally as $key => $total) {
            if (empty($item[$key])) {
                continue;
            }
            foreach ($item[$key] as $mod) {
                preg_match(self::LIGHTNING_RESIST_PATTERN, $mod, $matches);
                if (!empty($matches) && ! empty($matches[2]) && is_numeric($matches[2])) {
                    $tally[$key] = $tally[$key] + $matches[2];
                }
                preg_match(self::COLD_AND_LIGHTNING_RESIST_PATTERN, $mod, $matches);
                if (!empty($matches) && ! empty($matches[2]) && is_numeric($matches[2])) {
                    $tally[$key] = $tally[$key] + $matches[2];
                }
                preg_match(self::FIRE_AND_LIGHTNING_RESIST_PATTERN, $mod, $matches);
                if (!empty($matches) && ! empty($matches[2]) && is_numeric($matches[2])) {
                    $tally[$key] = $tally[$key] + $matches[2];
                }
                preg_match(self::ALL_RESIST_PATTERN, $mod, $matches);
                if (!empty($matches) && ! empty($matches[2]) && is_numeric($matches[2])) {
                    $tally[$key] = $tally[$key] + $matches[2];
                }
            }
        }
        return $tally;
    }

    public static function getTotalChaosResistance(array $item): array
    {
        $tally = [
            'implicitMods' => 0,
            'explicitMods' => 0,
        ];
        foreach($tally as $key => $total) {
            if (empty($item[$key])) {
                continue;
            }
            foreach ($item[$key] as $mod) {
                preg_match(self::CHAOS_RESIST_PATTERN, $mod, $matches);
                if (!empty($matches) && ! empty($matches[2]) && is_numeric($matches[2])) {
                    $tally[$key] = $tally[$key] + $matches[2];
                }
            }
        }
        return $tally;
    }

    public static function getTotalMaximumFlatLife(array $item): array
    {
        $tally = [
            'implicitMods' => 0,
            'explicitMods' => 0,
        ];
        foreach($tally as $key => $total) {
            if (empty($item[$key])) {
                continue;
            }
            foreach ($item[$key] as $mod) {
                preg_match(self::MAX_FLAT_LIFE_PATTERN, $mod, $matches);
                if (!empty($matches) && ! empty($matches[2]) && is_numeric($matches[2])) {
                    $tally[$key] = $tally[$key] + $matches[2];
                }
            }
        }
        return $tally;
    }

    public static function getTotalPercentFlatLife(array $item): array
    {
        $tally = [
            'implicitMods' => 0,
            'explicitMods' => 0,
        ];
        foreach($tally as $key => $total) {
            if (empty($item[$key])) {
                continue;
            }
            foreach ($item[$key] as $mod) {
                preg_match(self::PERCENT_INC_LIFE_PATTERN, $mod, $matches);
                if (!empty($matches) && ! empty($matches[2]) && is_numeric($matches[2])) {
                    $tally[$key] = $tally[$key] + $matches[2];
                }
            }
        }
        return $tally;
    }

    public static function tallyMods(array $item): array
    {
        $result = [
            'openAffix' => 6 - (count($item['explicitMods']))
        ];
        foreach(['explicitMods', 'implicitMods'] as $modType) {
            $totalFire = self::getTotalFireResistance($item)[$modType];
            $totalCold = self::getTotalColdResistance($item)[$modType];
            $totalLightning = self::getTotalLightningResistance($item)[$modType];
            $totalChaos = self::getTotalChaosResistance($item)[$modType];
            $result[$modType] = [
                'fire' => $totalFire,
                'cold' => $totalCold,
                'lightning' => $totalLightning,
                'chaos' => $totalChaos,
                'totalResistances' => $totalFire + $totalCold + $totalLightning + $totalChaos,
                'totalElementalResistances' => $totalFire + $totalCold + $totalLightning,
                'flatLife' => self::getTotalMaximumFlatLife($item)[$modType],
                'percentLife' => self::getTotalPercentFlatLife($item)[$modType],
                'manaRegeneration' => self::getTotalIncreaseManaRegeneration($item)[$modType],
                'movementSpeed' => self::getTotalIncreaseMovementSpeed($item)[$modType],
                'flaskChargesGained' => self::getTotalFlaskChargesGained($item)[$modType],
                'flaskChargesUsed' => self::getTotalFlaskChargesUsed($item)[$modType],
                'flaskEffectDuration' => self::getTotalFlaskEffectDuration($item)[$modType],
                'flatMana' => self::getTotalFlatMana($item)[$modType],
                'flatES' => self::getTotalFlatEnergyShield($item)[$modType],
                'flatEvasion' => self::getTotalFlatEvasion($item)[$modType],
                'increasedElementalDamageWithAtk' => self::getTotalIncreasedElementalDamage($item)[$modType],
                'percentMana' => self::getPercentIncreasedMana($item)[$modType],
                'isCorruptedBloodImmune' => self::isCorruptedBloodImmune($item)[$modType],
                'isSilenceImmune' => self::isSilenceImmune($item)[$modType],
                'isHinderImmune' => self::isHinderImmune($item)[$modType],
                'plusLevelGemPhysicalSpell' => self::getPlusLevelGemPhysicalSpell($item)[$modType],
                'plusLevelGemChaosSpell' => self::getPlusLevelGemChaosSpell($item)[$modType],
                'plusLevelGemFireSpell' => self::getPlusLevelGemFireSpell($item)[$modType],
                'plusLevelGemColdSpell' => self::getPlusLevelGemColdSpell($item)[$modType],
                'plusLevelGemLightningSpell' => self::getPlusLevelGemLightningSpell($item)[$modType],
            ];
        }
        return $result;
    }

}