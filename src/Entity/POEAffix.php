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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $groupName;

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
     * @ORM\OneToMany(targetEntity=POEBaseGroupAffixes::class, mappedBy="poeAffix", orphanRemoval=true)
     */
    private $poeBaseGroupAffixes;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $regexPattern;

    public function __construct()
    {
        $this->poeBaseGroupAffixes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGroupName(): ?string
    {
        return $this->groupName;
    }

    public function setGroupName(?string $groupName): self
    {
        $this->groupName = $groupName;

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
     * @return Collection|POEBaseGroupAffixes[]
     */
    public function getPoeBaseGroupAffixes(): Collection
    {
        return $this->poeBaseGroupAffixes;
    }

    public function addPoeBaseGroupAffix(POEBaseGroupAffixes $poeBaseGroupAffix): self
    {
        if (!$this->poeBaseGroupAffixes->contains($poeBaseGroupAffix)) {
            $this->poeBaseGroupAffixes[] = $poeBaseGroupAffix;
            $poeBaseGroupAffix->setPoeAffix($this);
        }

        return $this;
    }

    public function removePoeBaseGroupAffix(POEBaseGroupAffixes $poeBaseGroupAffix): self
    {
        if ($this->poeBaseGroupAffixes->removeElement($poeBaseGroupAffix)) {
            // set the owning side to null (unless already changed)
            if ($poeBaseGroupAffix->getPoeAffix() === $this) {
                $poeBaseGroupAffix->setPoeAffix(null);
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
}
