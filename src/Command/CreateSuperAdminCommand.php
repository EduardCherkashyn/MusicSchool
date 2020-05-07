<?php
/**
 * Created by PhpStorm.
 * User: eduardcherkashyn
 * Date: 2020-04-18
 * Time: 20:37
 */

namespace App\Command;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class CreateSuperAdminCommand extends Command
{
    private $manager;
    private $passwordEncoder;

    public function __construct(?string $name = null, EntityManagerInterface $manager, UserPasswordEncoderInterface $passwordEncoder)
    {
        parent::__construct($name);
        $this->manager = $manager;
        $this->passwordEncoder = $passwordEncoder;
    }

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:create-super-admin';

    protected function configure()
    {
        // ...
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Super Admin Creation',
            '============',
            '',
        ]);
        $user = new User();
        $user->setEmail('super@gmail.com')
            ->setRoles(['ROLE_S_ADMIN'])
            ->setPassword($this->passwordEncoder->encodePassword($user,'123456'));
        $this->manager->persist($user);
        $this->manager->flush();


        $output->write('success.');

        return 0;
    }
}
