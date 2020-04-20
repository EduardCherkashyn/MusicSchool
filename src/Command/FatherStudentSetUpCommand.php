<?php
/**
 * Created by PhpStorm.
 * User: eduardcherkashyn
 * Date: 2020-04-18
 * Time: 20:27
 */

namespace App\Command;


use App\Entity\Student;
use App\Entity\Teacher;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FatherStudentSetUpCommand extends Command
{
    private $manager;

    public function __construct(?string $name = null, EntityManagerInterface $manager)
    {
        parent::__construct($name);
        $this->manager = $manager;
    }

    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:data-migrate';

    protected function configure()
    {
        // ...
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Alexandr Cherkashyn data Migration',
            '============',
            '',
        ]);
        $teacher = new Teacher();
        $teacher->setName('Олександр Черкашин')
            ->setType('private');
        $students = $this->manager->getRepository(Student::class)->findAll();
        foreach ($students as $student){
            $teacher->addStudent($student);
        }
        $user =  $this->manager->getRepository(User::class)->findOneBy(['email'=>'admin@gmail.com']);
        $teacher->setUser($user);
        $this->manager->persist($teacher);
        $this->manager->flush();


        $output->write('success.');

        return 0;
    }
}
