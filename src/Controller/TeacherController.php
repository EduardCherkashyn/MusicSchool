<?php

namespace App\Controller;

use App\Entity\Teacher;
use App\Entity\User;
use App\Form\TeacherType;
use App\Repository\TeacherRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/sadmin/teacher")
 */
class TeacherController extends AbstractController
{
    /**
     * @Route("/", name="teacher_index", methods="GET")
     */
    public function index(TeacherRepository $teacherRepository): Response
    {
        return $this->render('teacher/index.html.twig', ['teachers' => $teacherRepository->findAll()]);
    }

    /**
     * @Route("/new", name="teacher_new", methods="GET|POST")
     */
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $teacher = new Teacher();
        $form = $this->createForm(TeacherType::class, $teacher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = new User();
            $user->setRoles(['ROLE_ADMIN'])
                ->setPassword($passwordEncoder->encodePassword($user,$form['password']->getData()))
                ->setEmail($form['email']->getData())
                ->setTeacher($teacher);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->persist($teacher);
            $em->flush();

            return $this->redirectToRoute('teacher_index');
        }

        return $this->render('teacher/new.html.twig', [
            'teacher' => $teacher,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="teacher_show", methods="GET")
     */
    public function show(Teacher $teacher): Response
    {
        return $this->render('teacher/show.html.twig', ['teacher' => $teacher]);
    }

    /**
     * @Route("/{id}/edit", name="teacher_edit", methods="GET|POST")
     */
    public function edit(Request $request, Teacher $teacher,  UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form = $this->createForm(TeacherType::class, $teacher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $teacher->getUser();
            $user->setPassword($passwordEncoder->encodePassword($user,$form['password']->getData()))
                ->setEmail($form['email']->getData());
            $this->getDoctrine()->getManager()->persist($user);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('teacher_index', ['id' => $teacher->getId()]);
        }

        return $this->render('teacher/edit.html.twig', [
            'teacher' => $teacher,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="teacher_delete", methods="DELETE")
     */
    public function delete(Request $request, Teacher $teacher): Response
    {
        if ($this->isCsrfTokenValid('delete'.$teacher->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($teacher);
            $em->flush();
        }

        return $this->redirectToRoute('teacher_index');
    }
}