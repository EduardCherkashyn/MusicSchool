<?php

namespace App\Controller;

use App\Entity\File;
use App\Entity\Lesson;
use App\Form\FilterType;
use App\Form\LessonEditType;
use App\Form\LessonType;
use App\Repository\LessonRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/lesson")
 */
class LessonCrudController extends AbstractController
{
    /**
     * @Route("/", name="lesson_index")
     */
    public function index(Request $request, PaginatorInterface $paginator, LessonRepository $lessonRepository): Response
    {
        if ($student = $request->query->get('id')) {
            $pagination = $paginator->paginate(
                $lessonRepository->getStudentLesson($student), /* query NOT result */
                $request->query->getInt('page', 1),
                10
            );
        } else {
        $pagination = $paginator->paginate(
            $lessonRepository->getQueryLessonCrud($this->getUser()->getTeacher()), /* query NOT result */
            $request->query->getInt('page', 1),
            10);
        }
        $form = $this->createForm(FilterType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = [];
            if ($student = $form->get('student')->getData()) {
              $data['id'] = $student->getId();
            }
            return $this->redirectToRoute('lesson_index', $data);
        }
        return $this->render('lesson/index.html.twig', [
            'lessons' => $pagination,
            'form' => $form->createView()
            ]);
    }

    /**
     * @Route("/new", name="lesson_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $lesson = new Lesson();
        $form = $this->createForm(LessonType::class, $lesson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $files = $form['files']->getData();
            /** @var File $file */
            foreach ($files as $file){
                $lesson->addFile($file);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($lesson);
            $em->flush();

            return $this->redirectToRoute('lesson_index');
        }

        return $this->render('lesson/new.html.twig', [
            'lesson' => $lesson,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="lesson_edit", methods="GET|POST")
     */
    public function edit(Request $request, Lesson $lesson): Response
    {
        $form = $this->createForm(LessonEditType::class, $lesson);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lesson);
            $em->flush();

            return $this->redirectToRoute('lesson_index', ['id' => $lesson->getId()]);
        }

        return $this->render('lesson/edit.html.twig', [
            'lesson' => $lesson,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="lesson_delete", methods="DELETE")
     */
    public function delete(Request $request, Lesson $lesson): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lesson->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($lesson);
            $em->flush();
        }

        return $this->redirectToRoute('lesson_index');
    }
}
