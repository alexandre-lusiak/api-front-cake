<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['post_product','get_products','post_comment','get_user','get_like','get_category'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['post_product','get_products','get_category'])]
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
    #[Groups(['post_product','get_products'])]
    private ?File $file = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['post_product','get_products'])]
    private ?bool $isActif = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Comment::class)]
    #[Groups(['post_product','get_products'])]
    private Collection $comments;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: CakeLike::class)]
    #[Groups(['get_products','get_like'])]
    private Collection $cakeLikes;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $brochureFilename = null;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->cakeLikes = new ArrayCollection();
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

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setProduct($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getProduct() === $this) {
                $comment->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CakeLike>
     */
    public function getCakeLikes(): Collection
    {
        return $this->cakeLikes;
    }

    public function addCakeLike(CakeLike $cakeLike): self
    {
        if (!$this->cakeLikes->contains($cakeLike)) {
            $this->cakeLikes->add($cakeLike);
            $cakeLike->setProduct($this);
        }

        return $this;
    }

    public function removeCakeLike(CakeLike $cakeLike): self
    {
        if ($this->cakeLikes->removeElement($cakeLike)) {
            // set the owning side to null (unless already changed)
            if ($cakeLike->getProduct() === $this) {
                $cakeLike->setProduct(null);
            }
        }

        return $this;
    }

    /*method crée pour voir si l'utilisateur aime déja l'article*/
    public function likedByUser(User $user): bool 
    {
        foreach($this->cakeLikes as $cakeLike) {
            
            if($cakeLike->getUser()== $user) {
                return true;
            }
        }
        return false; 
    }

    public function getBrochureFilename(): ?string
    {
        return $this->brochureFilename;
    }

    public function setBrochureFilename(?string $brochureFilename): self
    {
        $this->brochureFilename = $brochureFilename;

        return $this;
    } 
}
