<?php

namespace App\Entity;

use App\Repository\AdressRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AdressRepository::class)]
class Adress
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['get_user','post_user'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['get_user','post_user'])]
    private ?string $country = null;

    #[ORM\Column(length: 255)]
    #[Groups(['get_user','post_user'])]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    #[Groups(['get_user','post_user'])]
    private ?string $postalCode = null;

    #[ORM\Column(length: 255)]
    #[Groups(['get_user','post_user'])]
    private ?string $adress1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['get_user','post_user'])]
    private ?string $adress2 = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getAdress1(): ?string
    {
        return $this->adress1;
    }

    public function setAdress1(string $adress1): self
    {
        $this->adress1 = $adress1;

        return $this;
    }

    public function getAdress2(): ?string
    {
        return $this->adress2;
    }

    public function setAdress2(?string $adress2): self
    {
        $this->adress2 = $adress2;

        return $this;
    }
}
