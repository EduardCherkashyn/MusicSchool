<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Form\PhotoType;
use App\Repository\PhotoRepository;
use App\Services\AmazonService;
use App\Services\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/photo")
 */
class PhotoController extends AbstractController
{
    /**
     * @Route("/", name="photo_index", methods="GET")
     */
    public function index(PhotoRepository $photoRepository): Response
    {
        return $this->render('photo/index.html.twig', ['photos' => $photoRepository->findBy(['teacher'=>$this->getUser()->getTeacher()],['id'=>'DESC'])]);
    }

    /**
     * @Route("/new", name="photo_new", methods="GET|POST")
     */
    public function new(Request $request, AmazonService $amazonService): Response
    {
        $photo = new Photo();
        $photo->setTeacher($this->getUser()->getTeacher());
        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var UploadedFile $asset
             */
            $asset = $request->files->get('photo')['path'];
            if($asset !== null) {
                $result = $amazonService->upload(
                    'photos/'.$this->getUser()->getTeacher()->getName(),
                    file_get_contents($_FILES['photo']['tmp_name']['path']),
                    md5(uniqid()).'.'.$asset->guessExtension(),
                    'image/'.$asset->guessExtension()
                );
                $photo->setPath($result['ObjectURL']);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($photo);
            $em->flush();

            return $this->redirectToRoute('photo_index');
        }

        return $this->render('photo/new.html.twig', [
            'photo' => $photo,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="photo_delete", methods="DELETE")
     */
    public function delete(Request $request, Photo $photo, AmazonService $amazonService): Response
    {
        if ($this->isCsrfTokenValid('delete'.$photo->getId(), $request->request->get('_token'))) {
            $amazonService->delete($photo->getPath());
            $em = $this->getDoctrine()->getManager();
            $em->remove($photo);
            $em->flush();
        }

        return $this->redirectToRoute('photo_index');
    }
}
