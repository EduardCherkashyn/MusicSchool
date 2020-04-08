<?php
/**
 * Created by PhpStorm.
 * User: eduardcherkashyn
 * Date: 2020-03-25
 * Time: 16:55
 */

namespace App\Controller;


use App\Entity\Student;
use App\Repository\PhotoRepository;
use App\Services\UrlParser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StaticPagesController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function homePageAction(UrlParser $urlParser, PhotoRepository $photoRepository)
    {
        $students = $this->getDoctrine()->getRepository(Student::class)->findAll();

        return $this->render('StaticPagesController/index.html.twig',[
            'students' => $students,
            'videos' => $urlParser->parseUrl(),
            'photos' => $photoRepository->findBy([],['id'=>'DESC'])
        ]);
    }

    /**
     * @Route("/contacts", name="app_contacts")
     */
    public function contactsPageAction()
    {
        return $this->render('StaticPagesController/contacts.html.twig');
    }
}
