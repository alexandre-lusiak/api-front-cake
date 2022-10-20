<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['post_product','get_products'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['post_product','get_products'])]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(['post_product','get_products'])]
    private ?float $priceHT = null;

    #[ORM\Column]
    #[Groups(['post_product','get_products'])]
    private ?float $priceTTC = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['post_product','get_products'])]
    private ?float $tva = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['post_product','get_products'])]
    private ?int $nbPerson = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['post_product','get_products'])]
    private ?float $weight = null;

    #[ORM\Column]
    #[Groups(['post_product','get_products'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'product')]
    #[Groups(['post_product','get_products'])]
    private ?Category $category = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?File $file = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['post_product','get_products'])]
    private ?bool $isActif = null;

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

    public function getPriceHT(): ?float
    {
        return $this->priceHT;
    }

    public function setPriceHT(float $priceHT): self
    {
        $this->priceHT = $priceHT;

        return $this;
    }

    public function getPriceTTC(): ?float
    {
        return $this->priceTTC;
    }

    public function setPriceTTC(float $priceTTC): self
    {
        $this->priceTTC = $priceTTC;

        return $this;
    }

    public function getTva(): ?float
    {
        return $this->tva;
    }

    public function setTva(?float $tva): self
    {
        $this->tva = $tva;

        return $this;
    }

    public function getNbPerson(): ?int
    {
        return $this->nbPerson;
    }

    public function setNbPerson(?int $nbPerson): self
    {
        $this->nbPerson = $nbPerson;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(?float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(?File $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function isIsActif(): ?bool
    {
        return $this->isActif;
    }

    public function setIsActif(?bool $isActif): self
    {
        $this->isActif = $isActif;

        return $this;
    }
}
