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
     * @Route("/newStudent", name="addStudent")
     */
    public function addAction(Request $request)
    {
        $student = new Student();
        $lesson = new ScheduleLesson();
        $lesson2 = new ScheduleLesson();
        $student->addLesson($lesson);
        $student->addLesson($lesson2);
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->persist($lesson);
            $em->flush();

            return $this->redirectToRoute('showStudents');
        }
        return $this->render('StudentController/StudentForm.html.twig', [
            'register_form'=>$form->createView(),

        ]);
    }

    /**
     * @Route("/delete/{id}", name="deleteStudent")
     */
    public function deleteAction(Student $student)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($student);
        $em->flush();

        return $this->redirectToRoute('showStudents');
    }

    /**
     * @Route("/edit/{id}", name="editStudent")
     */
    public function editAction(Student $student, Request $request)
    {
        $form = $this->createForm(StudentEditByNameType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();

            return $this->redirectToRoute('showStudents');
        }

        return $this->render('StudentController/EditStudentForm.html.twig', [
            'edit_form' => $form->createView(),
            'student' => $student
        ]);
    }

    /**
     * @Route("", name="showStudents")
     */
    public function showAllAction()
    {
        $repository = $this->getDoctrine()->getRepository(Student::class);
        $students = $repository->findAll();

        return $this->render('StudentController/showAllStudents.html.twig', [
          'students' => $students
        ]);
    }

    /**
     * @Route("/student_results/{id}", name="studentScore")
     */
    public function resultsAction(Student $student)
    {
        return $this->render('StudentController/studentResults.html.twig', [
            'student' => $student
        ]);
    }
}
