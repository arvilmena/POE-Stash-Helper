<?php

namespace App\Entity;

use App\Repository\POEBaseGroupAffixesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=POEBaseGroupAffixesRepository::class)
 */
class POEBaseGroupAffixes
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=POEBaseGroup::class, inversedBy="poeAffixes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $baseGroup;

    /**
     * @ORM\ManyToOne(targetEntity=POEAffix::class, inversedBy="poeBaseGroupAffixes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $poeAffix;

    /**
     * @ORM\OneToMany(targetEntity=POEBaseGroupAffixesTier::class, mappedBy="baseGroupAffixes", orphanRemoval=true)
     */
    private $poeBaseGroupAffixesTiers;

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
        $this->poeBaseGroupAffixesTiers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBaseGroup(): ?POEBaseGroup
    {
        return $this->baseGroup;
    }

    public function setBaseGroup(?POEBaseGroup $baseGroup): self
    {
        $this->baseGroup = $baseGroup;

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
     * @return Collection|POEBaseGroupAffixesTier[]
     */
    public function getPoeBaseGroupAffixesTiers(): Collection
    {
        return $this->poeBaseGroupAffixesTiers;
    }

    public function addPoeBaseGroupAffixesTier(POEBaseGroupAffixesTier $poeBaseGroupAffixesTier): self
    {
        if (!$this->poeBaseGroupAffixesTiers->contains($poeBaseGroupAffixesTier)) {
            $this->poeBaseGroupAffixesTiers[] = $poeBaseGroupAffixesTier;
            $poeBaseGroupAffixesTier->setBaseGroupAffixes($this);
        }

        return $this;
    }

    public function removePoeBaseGroupAffixesTier(POEBaseGroupAffixesTier $poeBaseGroupAffixesTier): self
    {
        if ($this->poeBaseGroupAffixesTiers->removeElement($poeBaseGroupAffixesTier)) {
            // set the owning side to null (unless already changed)
            if ($poeBaseGroupAffixesTier->getBaseGroupAffixes() === $this) {
                $poeBaseGroupAffixesTier->setBaseGroupAffixes(null);
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
