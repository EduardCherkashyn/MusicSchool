<?php

namespace App\Controller;

use App\Entity\File;
use App\Form\FileEditType;
use App\Form\FileType;
use App\Repository\FileRepository;
use App\Services\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/file")
 */
class FileController extends AbstractController
{
    /**
     * @Route("/", name="file_index", methods="GET")
     */
    public function index(FileRepository $fileRepository): Response
    {
        return $this->render('file/index.html.twig', ['files' => $fileRepository->findAll()]);
    }

    /**
     * @Route("/new", name="file_new", methods="GET|POST")
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $file = new File();
        $form = $this->createForm(FileType::class, $file);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var UploadedFile $file
             */
            $asset = $request->files->get('file')['path'];
            $fileName = $fileUploader->uploadAsset($asset);
            $file->setPath($fileName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($file);
            $em->flush();

            return $this->redirectToRoute('file_index');
        }

        return $this->render('file/new.html.twig', [
            'file' => $file,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="file_show", methods="GET")
     */
    public function show(File $file): Response
    {
        return $this->render('file/show.html.twig', ['file' => $file,]);
    }

    /**
     * @Route("/{id}/edit", name="file_edit", methods="GET|POST")
     */
    public function edit(Request $request, File $file): Response
    {
        $form = $this->createForm(FileEditType::class, $file);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('file_index', ['id' => $file->getId()]);
        }

        return $this->render('file/edit.html.twig', [
            'file' => $file,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="file_delete", methods="DELETE")
     */
    public function delete(Request $request, File $file): Response
    {
        if ($this->isCsrfTokenValid('delete'.$file->getId(), $request->request->get('_token'))) {
            $filesystem = new Filesystem();
            if ($filesystem->exists('assets/'.$file->getPath())){
                $filesystem->remove('assets/'.$file->getPath());
            }
            $em = $this->getDoctrine()->getManager();
            $em->remove($file);
            $em->flush();
        }

        return $this->redirectToRoute('file_index');
    }
}
