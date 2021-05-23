<?php

namespace App\Entity;

use App\Repository\POEBaseGroupAffixesTierRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=POEBaseGroupAffixesTierRepository::class)
 */
class POEBaseGroupAffixesTier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=POEBaseGroupAffixes::class, inversedBy="poeBaseGroupAffixesTiers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $baseGroupAffixes;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tier;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ilvl;

    /**
     * @ORM\ManyToOne(targetEntity=POEAffix::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $poeAffix;

    /**
     * @ORM\Column(type="decimal", nullable=false)
     */
    private $min;

    /**
     * @ORM\Column(type="decimal", nullable=false)
     */
    private $max;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBaseGroupAffixes(): ?POEBaseGroupAffixes
    {
        return $this->baseGroupAffixes;
    }

    public function setBaseGroupAffixes(?POEBaseGroupAffixes $baseGroupAffixes): self
    {
        $this->baseGroupAffixes = $baseGroupAffixes;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTier(): ?int
    {
        return $this->tier;
    }

    public function setTier(?int $tier): self
    {
        $this->tier = $tier;

        return $this;
    }

    public function getIlvl(): ?int
    {
        return $this->ilvl;
    }

    public function setIlvl(?int $ilvl): self
    {
        $this->ilvl = $ilvl;

        return $this;
    }

    public function getPoeAffix(): ?POEAffix
    {
        return $this->poeAffix;
    }

    public function setPoeAffix(?POEAffix $poeAffix): self
    {
        $this->poeAffix = $poeAffix;

        return $this;
    }

    public function getMin(): ?string
    {
        return $this->min;
    }

    public function setMin(string $min): self
    {
        $this->min = $min;

        return $this;
    }

    public function getMax(): ?string
    {
        return $this->max;
    }

    public function setMax(string $max): self
    {
        $this->max = $max;

        return $this;
    }
}
