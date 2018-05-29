<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
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
    private $userPseudo;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $userMail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $userPass;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $userPhoto;

    /**
     * @ORM\Column(type="boolean")
     */
    private $userConfirmed;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Trick", mappedBy="user")
     */
    private $tricks;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="user")
     */
    private $comments;

    public function __construct()
    {
        $this->tricks = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUserPseudo(): ?string
    {
        return $this->userPseudo;
    }

    public function setUserPseudo(string $userPseudo): self
    {
        $this->userPseudo = $userPseudo;

        return $this;
    }

    public function getUserMail(): ?string
    {
        return $this->userMail;
    }

    public function setUserMail(string $userMail): self
    {
        $this->userMail = $userMail;

        return $this;
    }

    public function getUserPass(): ?string
    {
        return $this->user�Pass;
    }

    public function setUserPass(string $userPass): self
    {
        $this->userPass = $userPass;

        return $this;
    }

    public function getUserPhoto(): ?string
    {
        return $this->userPhoto;
    }

    public function setUserPhoto(string $userPhoto): self
    {
        $this->userPhoto = $userPhoto;

        return $this;
    }

    public function getUserConfirmed(): ?bool
    {
        return $this->userConfirmed;
    }

    public function setUserConfirmed(bool $userConfirmed): self
    {
        $this->userConfirmed = $userConfirmed;

        return $this;
    }

    /**
     * @return Collection|Trick[]
     */
    public function getTricks(): Collection
    {
        return $this->tricks;
    }

    public function addTrick(Trick $trick): self
    {
        if (!$this->tricks->contains($trick)) {
            $this->tricks[] = $trick;
            $trick->setUser($this);
        }

        return $this;
    }

    public function removeTrick(Trick $trick): self
    {
        if ($this->tricks->contains($trick)) {
            $this->tricks->removeElement($trick);
            // set the owning side to null (unless already changed)
            if ($trick->getUser() === $this) {
                $trick->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }
}
