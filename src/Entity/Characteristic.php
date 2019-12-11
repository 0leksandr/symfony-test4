<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CharacteristicRepository")
 */
class Characteristic
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\CharacteristicValue",
     *     mappedBy="characteristic",
     *     orphanRemoval=true,
     *     cascade={"persist"}
     * )
     */
    private $characteristicValues;

    public function __construct()
    {
        $this->characteristicValues = new ArrayCollection();
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
     * @return Collection|CharacteristicValue[]
     */
    public function getCharacteristicValues(): Collection
    {
        return $this->characteristicValues;
    }

    public function addCharacteristicValue(CharacteristicValue $characteristicValue): self
    {
        if (!$this->characteristicValues->contains($characteristicValue)) {
            $this->characteristicValues[] = $characteristicValue;
            $characteristicValue->setCharacteristic($this);
        }

        return $this;
    }

    public function removeCharacteristicValue(CharacteristicValue $characteristicValue): self
    {
        if ($this->characteristicValues->contains($characteristicValue)) {
            $this->characteristicValues->removeElement($characteristicValue);
            // set the owning side to null (unless already changed)
            if ($characteristicValue->getCharacteristic() === $this) {
                $characteristicValue->setCharacteristic(null);
            }
        }

        return $this;
    }
}
