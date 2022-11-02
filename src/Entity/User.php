<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['get_user','post_user','post_comment','get_products','get_comment',"get_like"])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['get_user','post_user'])]
    private ?string $email = null;

    #[ORM\Column]
    #[Groups(['get_user','post_user'])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    #[Groups(['get_user','post_user'])]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    #[Groups(['get_user','post_user','get_comment','get_products'])]
    private ?string $lastName = null;

    #[ORM\Column(length: 255)]
    #[Groups(['get_user','post_user','get_comment','get_products'])]
    private ?string $firstName = null;

    #[ORM\Column]
    #[Groups(['get_user','post_user'])]
    private ?\DateTimeImmutable $registeredAt = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['get_user','post_user'])]
    private ?Adress $adress = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Comment::class)]
    private Collection $comments;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: CakeLike::class)]
    #[Groups(['get_user'])]
    private Collection $cakeLikes;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $resetToken = null;



    public function __construct()
    {
        $this->product = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->cakeLikes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getRegisteredAt(): ?\DateTimeImmutable
    {
        return $this->registeredAt;
    }

    public function setRegisteredAt(\DateTimeImmutable $registeredAt): self
    {
        $this->registeredAt = $registeredAt;

        return $this;
    }

    public function getAdress(): ?Adress
    {
        return $this->adress;
    }

    public function setAdress(Adress $adress): self
    {
        $this->adress = $adress;

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
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
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
            $cakeLike->setUser($this);
        }

        return $this;
    }

    public function removeCakeLike(CakeLike $cakeLike): self
    {
        if ($this->cakeLikes->removeElement($cakeLike)) {
            // set the owning side to null (unless already changed)
            if ($cakeLike->getUser() === $this) {
                $cakeLike->setUser(null);
            }
        }

        return $this;
    }

    public function getResetToken(): ?string
    {
        return $this->resetToken;
    }

    public function setResetToken(?string $resetToken): self
    {
        $this->resetToken = $resetToken;

        return $this;
    }


    
}
