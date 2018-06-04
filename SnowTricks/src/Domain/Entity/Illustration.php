<?php

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Domain\Repository\IllustrationRepository")
 */
class Illustration
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $illustrationName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $illustrationUrl;

    /**
     * @ORM\Column(type="boolean")
     */
    private $illustrationIsMain;

    /**
     * @ORM\ManyToOne(targetEntity="App\Domain\Entity\Trick", inversedBy="illustrations")
     */
    private $trick;

    public function getId()
    {
        return $this->id;
    }

    public function getIllustrationName(): ?string
    {
        return $this->illustrationName;
    }

    public function setIllustrationName(?string $illustrationName): self
    {
        $this->illustrationName = $illustrationName;

        return $this;
    }

    public function getIllustrationUrl(): ?string
    {
        return $this->illustrationUrl;
    }

    public function setIllustrationUrl(string $illustrationUrl): self
    {
        $this->illustrationUrl = $illustrationUrl;

        return $this;
    }

    public function getIllustrationIsMain(): ?bool
    {
        return $this->illustrationIsMain;
    }

    public function setIllustrationIsMain(bool $illustrationIsMain): self
    {
        $this->illustrationIsMain = $illustrationIsMain;

        return $this;
    }

    public function getTrick(): ?Trick
    {
        return $this->trick;
    }

    public function setTrick(?Trick $trick): self
    {
        $this->trick = $trick;

        return $this;
    }
}
