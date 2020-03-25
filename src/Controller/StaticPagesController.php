<?php
/**
 * Created by PhpStorm.
 * User: eduardcherkashyn
 * Date: 2020-03-25
 * Time: 16:55
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StaticPagesController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function homePageAction()
    {
        return $this->render('StaticPagesController/index.html.twig');
    }
}
