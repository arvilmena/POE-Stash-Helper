<?php

namespace App\Entity;

use App\Repository\POEBaseAffixesTierRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=POEBaseAffixesTierRepository::class)
 */
class POEBaseAffixesTier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=POEBaseAffixes::class, inversedBy="POEBaseAffixesTiers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $baseAffixes;

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
     * @ORM\Column(type="decimal", nullable=true)
     */
    private $min;

    /**
     * @ORM\Column(type="decimal", nullable=true)
     */
    private $max;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $regexPattern;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBaseAffixes(): ?POEBaseAffixes
    {
        return $this->baseAffixes;
    }

    public function setBaseAffixes(?POEBaseAffixes $baseAffixes): self
    {
        $this->baseAffixes = $baseAffixes;

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
    public function __toString()
    {
        return $this->getBaseAffixes()->getPoeAffix()->getName() . ' - T' . $this->tier;
    }

    public function getRegexPattern(): ?string
    {
        return $this->regexPattern;
    }

    public function setRegexPattern(?string $regexPattern): self
    {
        $this->regexPattern = $regexPattern;

        return $this;
    }
}
