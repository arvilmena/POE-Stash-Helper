<?php

namespace App\Entity;

use App\Repository\POEAffixRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=POEAffixRepository::class)
 */
class POEAffix
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $aModGrp;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $coeAffixID;

    /**
     * @ORM\OneToMany(targetEntity=POEBaseAffixes::class, mappedBy="poeAffix", orphanRemoval=true)
     */
    private $POEBaseAffixes;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $regexPattern;

    public function __construct()
    {
        $this->POEBaseAffixes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAModGrp(): ?string
    {
        return $this->aModGrp;
    }

    public function setAModGrp(?string $aModGrp): self
    {
        $this->aModGrp = $aModGrp;

        return $this;
    }

    public function getCoeAffixID(): ?int
    {
        return $this->coeAffixID;
    }

    public function setCoeAffixID(?int $coeAffixID): self
    {
        $this->coeAffixID = $coeAffixID;

        return $this;
    }

    /**
     * @return Collection|POEBaseAffixes[]
     */
    public function getPOEBaseAffixes(): Collection
    {
        return $this->POEBaseAffixes;
    }

    public function addPOEBaseAffix(POEBaseAffixes $POEBaseAffix): self
    {
        if (!$this->POEBaseAffixes->contains($POEBaseAffix)) {
            $this->POEBaseAffixes[] = $POEBaseAffix;
            $POEBaseAffix->setPoeAffix($this);
        }

        return $this;
    }

    public function removePOEBaseAffix(POEBaseAffixes $POEBaseAffix): self
    {
        if ($this->POEBaseAffixes->removeElement($POEBaseAffix)) {
            // set the owning side to null (unless already changed)
            if ($POEBaseAffix->getPoeAffix() === $this) {
                $POEBaseAffix->setPoeAffix(null);
            }
        }

        return $this;
    }

    public function getRegexPattern(): ?string
    {
        return $this->regexPattern;
    }

    public function setRegexPattern(string $regexPattern): self
    {
        $this->regexPattern = $regexPattern;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
