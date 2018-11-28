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
     * @Route("/deleteStudent", name="delete_student")
     */
    public function deleteAction()
    {
        $em = $this->getDoctrine()->getManager();

    }
}