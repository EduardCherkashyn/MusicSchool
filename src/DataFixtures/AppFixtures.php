<?php

namespace App\DataFixtures;

use App\Entity\ScheduleLesson;
use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $student = new Student();
        $student->setName('Edik');
        $student->setEmail('some@gmail.com');
        $student->setPhone('0202022');
        $lesson1 =new ScheduleLesson();
        $lesson1->setDayOfTheWeek(1);
        $lesson1->setTime(\DateTime::createFromFormat('H:i', '15:20'));
        $lesson11 =new ScheduleLesson();
        $lesson11->setDayOfTheWeek(5);
        $lesson11->setTime(\DateTime::createFromFormat('H:i', '10:00'));
        $student->addLesson($lesson11);
        $student->addLesson($lesson1);


        $student1 = new Student();
        $student1->setName('Igor');
        $student1->setEmail('any@gmail.com');
        $student1->setPhone('1111111');
        $lesson2 =new ScheduleLesson();
        $lesson2->setDayOfTheWeek(2);
        $lesson2->setTime(\DateTime::createFromFormat('H:i', '10:00'));
        $lesson22 =new ScheduleLesson();
        $lesson22->setDayOfTheWeek(6);
        $lesson22->setTime(\DateTime::createFromFormat('H:i', '17:00'));
        $student1->addLesson($lesson22);
        $student1->addLesson($lesson2);

        $student2 = new Student();
        $student2->setName('Alina');
        $student2->setEmail('alina@gmail.com');
        $student2->setPhone('22222222');
        $lesson3 =new ScheduleLesson();
        $lesson3->setDayOfTheWeek(3);
        $lesson3->setTime(\DateTime::createFromFormat('H:i', '20:00'));
        $lesson33 =new ScheduleLesson();
        $lesson33->setDayOfTheWeek(6);
        $lesson33->setTime(\DateTime::createFromFormat('H:i', '11:00'));
        $student2->addLesson($lesson33);
        $student2->addLesson($lesson3);

        $student3 = new Student();
        $student3->setName('Igor');
        $student3->setEmail('igor@gmail.com');
        $student3->setPhone('444444');
        $lesson4 =new ScheduleLesson();
        $lesson4->setDayOfTheWeek(4);
        $lesson4->setTime(\DateTime::createFromFormat('H:i', '13:40'));
        $lesson44 =new ScheduleLesson();
        $lesson44->setDayOfTheWeek(6);
        $lesson44->setTime(\DateTime::createFromFormat('H:i', '16:00'));
        $student3->addLesson($lesson44);
        $student3->addLesson($lesson4);


        $manager->persist($student);
        $manager->persist($student1);
        $manager->persist($student2);
        $manager->persist($student3);
        $manager->flush();
    }
}
