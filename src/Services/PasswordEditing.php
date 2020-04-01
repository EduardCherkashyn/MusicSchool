<?php
/**
 * Created by PhpStorm.
 * User: eduardcherkashyn
 * Date: 2020-03-31
 * Time: 18:56
 */

namespace App\Services;


use App\Entity\Student;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordEditing
{
    private $manager;
    private $encoder;

    public function __construct(EntityManagerInterface $manager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->manager = $manager;
        $this->encoder = $passwordEncoder;
    }

    public function check(Student $student) :void
    {
        $user = $this->manager->getRepository(User::class)->findOneBy(['student'=>$student->getId()]);
        if(!$this->encoder->isPasswordValid($user,$student->getPhone())){
            $user->setPassword($this->encoder->encodePassword($user,$student->getPhone()));
            $this->manager->persist($user);
        }
    }
}
