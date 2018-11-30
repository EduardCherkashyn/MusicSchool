<?php
/**
 * Created by PhpStorm.
 * User: eduardcherkashyn
 * Date: 11/25/18
 * Time: 4:25 PM
 */

namespace App\Controller;

use App\Entity\Student;
use App\Entity\ScheduleLesson;
use App\Form\StudentEditByNameType;
use App\Form\StudentType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StudentController extends AbstractController
{

    /**
     * @Route("/newStudent", name="add_student")
     */
    public function addAction(Request $request)
    {
        $student = new Student();
        $lesson = new ScheduleLesson();
        $lesson2 = new ScheduleLesson();
        $student->addLesson($lesson);
        $student->addLesson($lesson2);
        $form = $this->createForm(StudentType::class,$student);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->persist($lesson);
            $em->flush();
        }
        return $this->render('StudentForm.html.twig',[
            'register_form'=>$form->createView(),

        ]);

    }

    /**
     * @Route("/delete", name="delete_student")
     */
    public function deleteAction()
    {
        $repository = $this->getDoctrine()->getRepository(Student::class);
        /**
         * @var Student $student
         */
        $student = $repository->findOneBy(['id'=>$_GET['id']]);
        $em = $this->getDoctrine()->getManager();
        $em->remove($student);
        $em->flush();

        return $this->redirectToRoute('show_students');
    }

    /**
     * @Route("/edit", name="edit_student")
     */
    public function editAction(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Student::class);
        /**
         * @var Student $student
         */
        $student = $repository->findOneBy(['id'=>$_GET['id']]);
        $form = $this->createForm(StudentEditByNameType::class,$student);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();

            return $this->redirectToRoute('show_students');
        }

        return $this->render('EditStudentForm.html.twig',[
            'edit_form' => $form->createView(),
            'student' => $student
        ]);
    }

    /**
     * @Route("/showAll", name="show_students")
     */
    public function showAllAction()
    {
        $repository = $this->getDoctrine()->getRepository(Student::class);
        $students = $repository->findAll();

        return $this->render('showAllStudents.html.twig',[
          'students' => $students
        ]);
    }

    /**
     * @Route("/index", name="indexAction")
     */
    public function indexAction()
    {
        return $this->render('indexAction.html.twig');
    }

    /**
     * @Route("/student_results", name="student_score")
     */
    public function resultsAction()
    {
        $repository = $this->getDoctrine()->getRepository(Student::class);
        /**
         * @var Student $student
         */
        $student = $repository->findOneBy(['id'=>$_GET['id']]);

        return $this->render('studentResults.html.twig',[
            'student' => $student
        ]);
    }


}