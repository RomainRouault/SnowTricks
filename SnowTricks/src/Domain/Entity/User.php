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
 *     fields="userMail",
 *     message="Cette adresse email est déjà utilisée",
 *     groups="registration, update")
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
     * @Assert\NotBlank(message="Merci de compléter ce champ", groups="registration")
     * @ORM\Column(type="string", length=255)
     */
    private $userName;

    /**
     * @Assert\NotBlank(message="Merci de compléter ce champ", groups="login")
     * @Assert\Email(message="L'adresse email {{ value }} n'est pas valide")
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $userMail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $userPass;

    /**
     * @Assert\NotBlank(message="Merci de compléter ce champ", groups="registration")
     * @Assert\Length(min=8, minMessage="La longueur de votre mot de passe doit être d'au moins {{ limit }} caractères.", max=4096, maxMessage="La longueur de votre mot de passe ne peut pas excéder {{ limit }} caractères.")
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Image(
     *     mimeTypes = {"image/jpg", "image/jpeg", "image/png"}, mimeTypesMessage="Format d'image autorisée : jpeg, png",
     *     maxSize = "5M", maxSizeMessage="Taille maximum de l'image : 5mo ",
     *     minHeight = "100", minHeightMessage="L'image est trop courte. Valeur minimum : 100 pixels",
     *     minWidth="100", minWidthMessage="L'image n'est pas assez large. Valeur minimum : 100 pixels",
     *     groups="update"
     * )
     */
    private $userPhoto = self::DEFAULT_PIC;

    /**
     * @ORM\Column(type="boolean")
     */
    private $userConfirmed = self::STATUS_DISABLED;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
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

    public function getUserName(): ?string
    {
        return $this->userName;
    }

    public function setUserName(string $userName): self
    {
        $this->userName = $userName;

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

    public function getPassword(): ?string
    {
        return $this->userPass;
    }

    public function setPassword(string $userPass): self
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

    public function getUserPhoto()
    {
        return $this->userPhoto;
    }

    public function setUserPhoto($userPhoto): self
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

        return $this->token = $token;
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
            $this->userName,
            $this->userPass,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->userName,
            $this->userPass,
            ) = unserialize($serialized, ['allowed_classes' => false]);
    }
}
