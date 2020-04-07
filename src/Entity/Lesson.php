<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LessonRepository")
 */
class Lesson
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Student", inversedBy="lessonsArchive", cascade={"persist"})
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     */
    private $student;

    /**
     * @Assert\DateTime
     * @var string A "Y-m-d" formatted value
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @Assert\Length(
     *      min = 10,
     *      max = 300,
     *      minMessage = "Your text be at least {{ limit }} characters long",
     *      maxMessage = "Your text cannot be longer than {{ limit }} characters"
     * )
     * @ORM\Column(type="text")
     */
    private $homework;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $attendance;

    /**
     * @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @ORM\Column(type="integer", nullable=true)
     */
    private $mark;

    /**
     * @Assert\Length(
     *      min = 20,
     *      max = 250,
     *      minMessage = "Your comment must be at least {{ limit }} characters long",
     *      maxMessage = "Your comment cannot be longer than {{ limit }} characters"
     * )
     * @ORM\Column(type="text", nullable=true)
     */
    private $markComment;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, unique=true)
     */
    private $youtubeLink;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\File", mappedBy="lessons")
     */
    private $files;



    public function __construct()
    {
        $this->files = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudent()
    {
        return $this->student;
    }

    public function setStudent($student): self
    {
        $this->student = $student;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getHomework(): ?string
    {
        return $this->homework;
    }

    public function setHomework(string $homework): self
    {
        $this->homework = $homework;

        return $this;
    }

    public function getAttendance(): ?bool
    {
        return $this->attendance;
    }

    public function setAttendance(bool $attendance): self
    {
        $this->attendance = $attendance;

        return $this;
    }

    public function getMark(): ?int
    {
        return $this->mark;
    }

    public function setMark(int $mark): self
    {
        $this->mark = $mark;

        return $this;
    }

    public function getMarkComment(): ?string
    {
        return $this->markComment;
    }

    public function setMarkComment(string $markComment): self
    {
        $this->markComment = $markComment;

        return $this;
    }

    public function getYoutubeLink(): ?string
    {
        return $this->youtubeLink;
    }

    public function setYoutubeLink(?string $youtubeLink): self
    {
        $this->youtubeLink = $youtubeLink;

        return $this;
    }

    /**
     * @return Collection|File[]
     */
    public function getFiles(): Collection
    {
        return $this->files;
    }

    public function addFile(File $file): self
    {
        if (!$this->files->contains($file)) {
            $this->files[] = $file;
            $file->addLesson($this);
        }

        return $this;
    }

    public function removeFile(File $file): self
    {
        if ($this->files->contains($file)) {
            $this->files->removeElement($file);
            $file->removeLesson($this);
        }

        return $this;
    }
}
