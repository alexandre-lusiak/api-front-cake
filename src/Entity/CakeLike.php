<?php

namespace App\Entity;

use App\Repository\CakeLikeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CakeLikeRepository::class)]
class CakeLike
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["get_like","get_user"])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'cakeLikes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["get_like","get_user"])]
    private ?Product $product = null;

    #[ORM\ManyToOne(inversedBy: 'cakeLikes')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["get_like"])]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }


}
