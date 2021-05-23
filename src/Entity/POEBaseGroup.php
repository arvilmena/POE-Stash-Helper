<?php

namespace App\Entity;

use App\Repository\POEBaseGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=POEBaseGroupRepository::class)
 */
class POEBaseGroup
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
     * @ORM\OneToMany(targetEntity=POEItem::class, mappedBy="baseGroup")
     */
    private $poeItems;

    /**
     * @ORM\OneToMany(targetEntity=POEBaseGroupAffixes::class, mappedBy="baseGroup", orphanRemoval=true)
     */
    private $poeAffixes;

    public function __construct()
    {
        $this->poeItems = new ArrayCollection();
        $this->poeAffixes = new ArrayCollection();
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

    /**
     * @return Collection|POEItem[]
     */
    public function getPoeItems(): Collection
    {
        return $this->poeItems;
    }

    public function addPoeItem(POEItem $poeItem): self
    {
        if (!$this->poeItems->contains($poeItem)) {
            $this->poeItems[] = $poeItem;
            $poeItem->setBaseGroup($this);
        }

        return $this;
    }

    public function removePoeItem(POEItem $poeItem): self
    {
        if ($this->poeItems->removeElement($poeItem)) {
            // set the owning side to null (unless already changed)
            if ($poeItem->getBaseGroup() === $this) {
                $poeItem->setBaseGroup(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|POEBaseGroupAffixes[]
     */
    public function getPoeAffixes(): Collection
    {
        return $this->poeAffixes;
    }

    public function addPoeAffix(POEBaseGroupAffixes $poeAffix): self
    {
        if (!$this->poeAffixes->contains($poeAffix)) {
            $this->poeAffixes[] = $poeAffix;
            $poeAffix->setBaseGroup($this);
        }

        return $this;
    }

    public function removePoeAffix(POEBaseGroupAffixes $poeAffix): self
    {
        if ($this->poeAffixes->removeElement($poeAffix)) {
            // set the owning side to null (unless already changed)
            if ($poeAffix->getBaseGroup() === $this) {
                $poeAffix->setBaseGroup(null);
            }
        }

        return $this;
    }
}
