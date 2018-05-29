<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
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
    private $commentContent;

    /**
     * @ORM\Column(type="time")
     */
    private $commentCreation;

    public function getId()
    {
        return $this->id;
    }

    public function getCommentContent(): ?string
    {
        return $this->commentContent;
    }

    public function setCommentContent(string $commentContent): self
    {
        $this->commentContent = $commentContent;

        return $this;
    }

    public function getCommentCreation(): ?\DateTimeInterface
    {
        return $this->commentCreation;
    }

    public function setCommentCreation(\DateTimeInterface $commentCreation): self
    {
        $this->commentCreation = $commentCreation;

        return $this;
    }
}
