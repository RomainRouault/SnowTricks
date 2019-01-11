<?php

namespace App\Domain\Entity;

use App\Domain\Tools\SlugTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Domain\Repository\TrickRepository")
 */
class Trick
{
    use SlugTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $trickName;

    /**
     * @ORM\Column(type="text")
     */
    private $trickDescription;

    /**
     * @ORM\Column(type="datetime")
     */
    private $trickCreation;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $trickUpdate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $trickSlug;


    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\Entity\User", inversedBy="tricks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\Entity\Category", inversedBy="tricks")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Domain\Entity\Video", mappedBy="trick")
     */
    private $video;

    /**
     * @ORM\OneToMany(targetEntity="App\Domain\Entity\Illustration", mappedBy="trick")
     */
    private $illustration;

    /**
     * @ORM\OneToMany(targetEntity="App\Domain\Entity\Comment", mappedBy="trick", orphanRemoval=true)
     */
    private $comment;


    public function __construct()
    {
        $this->video = new ArrayCollection();
        $this->illustration = new ArrayCollection();
        $this->comment = new ArrayCollection();
    }


    public function getId()
    {
        return $this->id;
    }

    public function getTrickDescription(): ?string
    {
        return $this->trickDescription;
    }

    public function setTrickDescription(string $trickDescription): self
    {
        $this->trickDescription = $trickDescription;

        return $this;
    }

    public function getTrickCreation(): ?\DateTimeInterface
    {
        return $this->trickCreation;
    }

    public function setTrickCreation(\DateTimeInterface $trickCreation): self
    {
        $this->trickCreation = $trickCreation;

        return $this;
    }

    public function getTrickUpdate(): ?\DateTimeInterface
    {
        return $this->trickUpdate;
    }

    public function setTrickUpdate(?\DateTimeInterface $trickUpdate): self
    {
        $this->trickUpdate = $trickUpdate;

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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Video[]
     */
    public function getVideo(): Collection
    {
        return $this->video;
    }

    public function addVideo(Video $video): self
    {
        if (!$this->video->contains($video)) {
            $this->video[] = $video;
            $video->setTrick($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        if ($this->video->contains($video)) {
            $this->video->removeElement($video);
            // set the owning side to null (unless already changed)
            if ($video->getTrick() === $this) {
                $video->setTrick(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Illustration[]
     */
    public function getIllustration(): Collection
    {
        return $this->illustration;
    }

    public function addIllustration(Illustration $illustration): self
    {
        if (!$this->illustration->contains($illustration)) {
            $this->illustration[] = $illustration;
            $illustration->setTrick($this);
        }

        return $this;
    }

    public function removeIllustration(Illustration $illustration): self
    {
        if ($this->illustration->contains($illustration)) {
            $this->illustration->removeElement($illustration);
            // set the owning side to null (unless already changed)
            if ($illustration->getTrick() === $this) {
                $illustration->setTrick(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comment;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comment->contains($comment)) {
            $this->comment[] = $comment;
            $comment->setTrick($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comment->contains($comment)) {
            $this->comment->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getTrick() === $this) {
                $comment->setTrick(null);
            }
        }

        return $this;
    }

    public function getTrickName(): ?string
    {
        return $this->trickName;
    }

    public function setTrickName(string $trickName): self
    {
        $this->setTrickSlug($trickName);

        $this->trickName = $trickName;

        return $this;
    }

    public function getTrickSlug(): ?string
    {
        return $this->trickDescription;
    }

    public function setTrickSlug(string $trickName): self
    {

        $this->trickSlug = $this->slugify($trickName);

        return $this;
    }

}
