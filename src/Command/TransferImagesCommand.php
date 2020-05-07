<?php
/**
 * Created by PhpStorm.
 * User: eduardcherkashyn
 * Date: 2020-05-06
 * Time: 12:48
 */

namespace App\Command;

use App\Entity\Student;
use App\Services\AmazonService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Finder\Finder;


class TransferImagesCommand extends Command
{
// the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:upload-photos';
    private $amazonSdk;
    private $container;
    private $manager;

    public function __construct(
        ?string $name = null,
        AmazonService $amazonService,
        ContainerInterface $container,
        EntityManagerInterface $entityManager
    ){
        parent::__construct($name);
        $this->amazonSdk = $amazonService;
        $this->container = $container;
        $this->manager = $entityManager;
    }

    protected function configure()
    {
        // ...
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $students = $this->manager->getRepository(Student::class)->findAll();
        $finder = new Finder();
        $files = $finder->in($this->container->get('kernel')->getRootDir().'/../public/avatars');
        foreach ($files as $file){
            foreach ($students as $student){
                if($student->getAvatar() === $file->getFilename()){
                    $result = $this->amazonSdk->uploadAvatar($file->getContents(),$file->getFilename(),$file->getExtension());
                    $student->setAvatar($result['ObjectURL']);
                    $this->manager->persist($student);
                    unlink($file->getRealPath());
                }
            }
        }
        $this->manager->flush();
        return 0;
    }
}
