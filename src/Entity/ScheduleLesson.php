<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CheduleLessonRepository")
 */
class ScheduleLesson
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $dayOfTheWeek;

    /**
     * @ORM\Column(type="time")
     */
    private $time;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Student", inversedBy="lessons", cascade={"persist"})
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     */
    private $student;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDayOfTheWeek(): ?int
    {
        return $this->dayOfTheWeek;
    }

    public function setDayOfTheWeek(int $dayOfTheWeek): self
    {
        $this->dayOfTheWeek = $dayOfTheWeek;

        return $this;
    }

    public function getTime(): ?\DateTimeInterface
    {
        return $this->time;
    }

    public function setTime(\DateTimeInterface $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): self
    {
        $this->student = $student;

        return $this;
    }
}
