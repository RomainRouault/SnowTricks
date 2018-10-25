<?php

namespace App\Domain\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Table(name="app_users")
 * @ORM\Entity(repositoryClass="App\Domain\Repository\UserRepository")
 * @UniqueEntity(
 *     "userMail",
 *     message="Cette adresse email est déjà utilisée")
 */
class User implements UserInterface, \Serializable
{
    const STATUS_DISABLED = false;
    const STATUS_ENABLED = true;
    const DEFAULT_PIC = "default-profil.jpg";

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Merci de compléter ce champ")
     * @ORM\Column(type="string", length=255)
     */
    private $userPseudo;

    /**
     * @Assert\NotBlank(message="Merci de compléter ce champ")
     * @Assert\Email(message="L'adresse email {{ value }} n'est pas valide")
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $userMail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $userPass;

    /**
     * @Assert\NotBlank(message="Merci de compléter ce champ")
     * @Assert\Length(min=8, minMessage="La longueur de votre mot de passe doit être d'au moins {{ limit }} caractères.", max=4096, maxMessage="La longueur de votre mot de passe ne peut pas excéder {{ limit }} caractères.")
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $userPhoto = self::DEFAULT_PIC;

    /**
     * @ORM\Column(type="boolean")
     */
    private $userConfirmed = self::STATUS_DISABLED;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $token;


    /**
     * @ORM\OneToMany(targetEntity="App\Domain\Entity\Trick", mappedBy="user")
     */
    private $tricks;

    /**
     * @ORM\OneToMany(targetEntity="App\Domain\Entity\Comment", mappedBy="user")
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

    public function getUsername(): ?string
    {
        return $this->userPseudo;
    }

    public function setUsername(string $userPseudo): self
    {
        $this->userPseudo = $userPseudo;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->userMail;
    }

    public function setEmail(string $userMail): self
    {
        $this->userMail = $userMail;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->userPass;
    }

    public function setUserPass(string $userPass): self
    {
        $this->userPass = $userPass;

        return $this;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
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

    public function setUserConfirmed(bool $userConfirmed = false): self
    {
        $this->userConfirmed = $userConfirmed;

        return $this;
    }

    /**
     * Set a trick
     */

    public function getToken(): ?string
    {
        return $this->token;

    }

    public function setToken($token)
    {

        $this->token = $token;
    }

    public function initiateToken()
    {
        $token = bin2hex(random_bytes(32));

        $this->token = $token;
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

    public function getRoles()
    {
        return array('ROLE_USER');
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->userPseudo,
            $this->userPass,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->userPseudo,
            $this->userPass,
            ) = unserialize($serialized, ['allowed_classes' => false]);
    }
}
