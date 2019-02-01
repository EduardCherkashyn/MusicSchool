<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StudentRepository")
 */
class Student
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Length(min="3", max="15")
     */
    private $name;

    /**
     * @Assert\Email()
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @Assert\Length(min="6", max="12")
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ScheduleLesson", mappedBy="student", cascade={"all"}, orphanRemoval=true)
     */
    private $lessons = [];

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Lesson", mappedBy="student",cascade={"all"}, orphanRemoval=true)
     */
    private $lessonsArchive;

    public function __construct()
    {
        $this->lessons = new ArrayCollection();
        $this->lessonsArchive = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getLessons(): Collection
    {
        return $this->lessons;
    }

    public function setLessons(array $lessons): self
    {
        $this->lessons = $lessons;

        return $this;
    }

    public function addLesson(ScheduleLesson $lesson): self
    {
        if (!$this->lessons->contains($lesson)) {
            $this->lessons[] = $lesson;
            $lesson->setStudent($this);
        }

        return $this;
    }

    public function removeLesson(ScheduleLesson $lesson): self
    {
        if ($this->lessons->contains($lesson)) {
            $this->lessons->removeElement($lesson);
            // set the owning side to null (unless already changed)
            if ($lesson->getStudent() === $this) {
                $lesson->setStudent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Lesson[]
     */
    public function getLessonsArchive(): Collection
    {
        return $this->lessonsArchive;
    }

    public function addLessonsArchive(Lesson $lessonsArchive): self
    {
        if (!$this->lessonsArchive->contains($lessonsArchive)) {
            $this->lessonsArchive[] = $lessonsArchive;
            $lessonsArchive->setStudent($this);
        }

        return $this;
    }

    public function removeLessonsArchive(Lesson $lessonsArchive): self
    {
        if ($this->lessonsArchive->contains($lessonsArchive)) {
            $this->lessonsArchive->removeElement($lessonsArchive);
            // set the owning side to null (unless already changed)
            if ($lessonsArchive->getStudent() === $this) {
                $lessonsArchive->setStudent(null);
            }
        }

        return $this;
    }
}
