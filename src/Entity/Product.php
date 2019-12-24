<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
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
    private string $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $image;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private string $price;

    /**
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\Feedback",
     *     mappedBy="product",
     *     orphanRemoval=true,
     *     cascade={"persist"}
     * )
     */
    private Collection $feedbacks;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\CharacteristicValue")
     * @ORM\JoinTable(
     *     name="products_characteristic_values",
     *     joinColumns={@ORM\JoinColumn(name="product_id", nullable=false)},
     *     inverseJoinColumns={
     *         @ORM\JoinColumn(name="characteristic_value_id", nullable=false)
     *     }
     * )
     */
    private Collection $characteristicValues;

    public function __construct()
    {
        $this->feedbacks            = new ArrayCollection();
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|Feedback[]
     */
    public function getFeedbacks(): Collection
    {
        return $this->feedbacks;
    }

    public function addFeedback(Feedback $feedback): self
    {
        if (!$this->feedbacks->contains($feedback)) {
            $this->feedbacks[] = $feedback;
            $feedback->setProduct($this);
        }

        return $this;
    }

    public function removeFeedback(Feedback $feedback): self
    {
        if ($this->feedbacks->contains($feedback)) {
            $this->feedbacks->removeElement($feedback);
            // set the owning side to null (unless already changed)
            if ($feedback->getProduct() === $this) {
                $feedback->setProduct(null);
            }
        }

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
            $this->characteristicValues->add($characteristicValue);
        }

        return $this;
    }
}
