<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\YoutubeLinkRepository")
 */
class YoutubeLink
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, unique=true)
     * @Assert\NotBlank()
     * @Assert\Regex("^(http:\/\/|https:\/\/)(vimeo\.com|youtu\.be|www\.youtube\.com)\/([\w\/]+)([\?].*)?$^",message="Введите верную ютуб ссылку")
     */
    private $path;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Lesson", inversedBy="youtubeLinks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lesson_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getLessonId(): ?Lesson
    {
        return $this->lesson_id;
    }

    public function setLessonId(?Lesson $lesson_id): self
    {
        $this->lesson_id = $lesson_id;

        return $this;
    }
}
