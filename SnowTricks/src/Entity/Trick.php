<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TrickRepository")
 */
class Trick
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
    private $trickDescription;

    /**
     * @ORM\Column(type="time")
     */
    private $trickCreation;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $trickUpdate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="tricks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="tricks")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Video", mappedBy="trick")
     */
    private $videos;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Illustration", mappedBy="trick")
     */
    private $illustrations;

    public function __construct()
    {
        $this->videos = new ArrayCollection();
        $this->illustrations = new ArrayCollection();
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
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(Video $video): self
    {
        if (!$this->videos->contains($video)) {
            $this->videos[] = $video;
            $video->setTrick($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        if ($this->videos->contains($video)) {
            $this->videos->removeElement($video);
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
    public function getIllustrations(): Collection
    {
        return $this->illustrations;
    }

    public function addIllustration(Illustration $illustration): self
    {
        if (!$this->illustrations->contains($illustration)) {
            $this->illustrations[] = $illustration;
            $illustration->setTrick($this);
        }

        return $this;
    }

    public function removeIllustration(Illustration $illustration): self
    {
        if ($this->illustrations->contains($illustration)) {
            $this->illustrations->removeElement($illustration);
            // set the owning side to null (unless already changed)
            if ($illustration->getTrick() === $this) {
                $illustration->setTrick(null);
            }
        }

        return $this;
    }

}
