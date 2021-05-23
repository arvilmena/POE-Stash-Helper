<?php

namespace App\Entity;

use App\Repository\POEBaseAffixesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=POEBaseAffixesRepository::class)
 */
class POEBaseAffixes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=POEBase::class, inversedBy="poeAffixes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $base;

    /**
     * @ORM\ManyToOne(targetEntity=POEAffix::class, inversedBy="POEBaseAffixes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $poeAffix;

    /**
     * @ORM\OneToMany(targetEntity=POEBaseAffixesTier::class, mappedBy="baseAffixes", orphanRemoval=true)
     */
    private $POEBaseAffixesTiers;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prefixOrSuffix;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $affixGroupName;

    public function __construct()
    {
        $this->POEBaseAffixesTiers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBaseGroup(): ?POEBase
    {
        return $this->base;
    }

    public function setBaseGroup(?POEBase $base): self
    {
        $this->base = $base;

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

    /**
     * @return Collection|POEBaseAffixesTier[]
     */
    public function getPOEBaseAffixesTiers(): Collection
    {
        return $this->POEBaseAffixesTiers;
    }

    public function addPOEBaseAffixesTier(POEBaseAffixesTier $POEBaseAffixesTier): self
    {
        if (!$this->POEBaseAffixesTiers->contains($POEBaseAffixesTier)) {
            $this->POEBaseAffixesTiers[] = $POEBaseAffixesTier;
            $POEBaseAffixesTier->setBaseGroupAffixes($this);
        }

        return $this;
    }

    public function removePOEBaseAffixesTier(POEBaseAffixesTier $POEBaseAffixesTier): self
    {
        if ($this->POEBaseAffixesTiers->removeElement($POEBaseAffixesTier)) {
            // set the owning side to null (unless already changed)
            if ($POEBaseAffixesTier->getBaseGroupAffixes() === $this) {
                $POEBaseAffixesTier->setBaseGroupAffixes(null);
            }
        }

        return $this;
    }

    public function getPrefixOrSuffix(): ?string
    {
        return $this->prefixOrSuffix;
    }

    public function setPrefixOrSuffix(?string $prefixOrSuffix): self
    {
        $this->prefixOrSuffix = $prefixOrSuffix;

        return $this;
    }

    public function getAffixGroupName(): ?string
    {
        return $this->affixGroupName;
    }

    public function setAffixGroupName(?string $affixGroupName): self
    {
        $this->affixGroupName = $affixGroupName;

        return $this;
    }
    public function __toString()
    {
        return $this->getPoeAffix()->getName();
    }
}
