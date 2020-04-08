<?php

namespace App\Controller;

use App\Entity\Video;
use App\Form\VideoType;
use App\Services\UrlParser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/video")
 */
class VideoController extends AbstractController
{
    /**
     * @Route("/", name="video_index", methods="GET")
     */
    public function index(UrlParser $urlParser): Response
    {
        return $this->render('video/index.html.twig', ['videos' => $urlParser->parseUrl()]);
    }

    /**
     * @Route("/new", name="video_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $video = new Video();
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($video);
            $em->flush();

            return $this->redirectToRoute('video_index');
        }

        return $this->render('video/new.html.twig', [
            'video' => $video,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="video_delete", methods="DELETE")
     */
    public function delete(Request $request, Video $video): Response
    {
        if ($this->isCsrfTokenValid('delete'.$video->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($video);
            $em->flush();
        }

        return $this->redirectToRoute('video_index');
    }
}
