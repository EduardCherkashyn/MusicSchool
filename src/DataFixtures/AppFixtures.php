<?php

namespace App\DataFixtures;

use App\Entity\ScheduleLesson;
use App\Entity\Student;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

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
        $user = new User();
        $user->setEmail($student->getEmail());
        $user->setPassword($this->passwordEncoder->encodePassword($user,$student->getPhone()));
        $user->setStudent($student);


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
        $user1 = new User();
        $user1->setEmail($student1->getEmail());
        $user1->setPassword($this->passwordEncoder->encodePassword($user1,$student1->getPhone()));
        $user1->setStudent($student1);

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
        $user2 = new User();
        $user2->setEmail($student2->getEmail());
        $user2->setPassword($this->passwordEncoder->encodePassword($user2,$student2->getPhone()));
        $user2->setStudent($student2);

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
        $user3 = new User();
        $user3->setEmail($student3->getEmail());
        $user3->setPassword($this->passwordEncoder->encodePassword($user3,$student3->getPhone()));
        $user3->setStudent($student3);

        $user4 = new User();
        $user4->setEmail('admin@gmail.com');
        $user4->setPassword($this->passwordEncoder->encodePassword($user4,'123456'));
        $user4->setRoles(['ROLE_ADMIN']);


        $manager->persist($student);
        $manager->persist($student1);
        $manager->persist($student2);
        $manager->persist($student3);
        $manager->persist($user);
        $manager->persist($user1);
        $manager->persist($user2);
        $manager->persist($user3);
        $manager->persist($user4);

        $manager->flush();
    }
}
