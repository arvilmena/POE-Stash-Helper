<?php

namespace App\Entity;

use App\Repository\POEItemRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=POEItemRepository::class)
 */
class POEItem
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
     * @ORM\ManyToOne(targetEntity=POEBaseGroup::class, inversedBy="poeItems")
     */
    private $baseGroup;

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

    public function getBaseGroup(): ?POEBaseGroup
    {
        return $this->baseGroup;
    }

    public function setBaseGroup(?POEBaseGroup $baseGroup): self
    {
        $this->baseGroup = $baseGroup;

        return $this;
    }
}
