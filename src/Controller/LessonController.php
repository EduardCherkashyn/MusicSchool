<?php
/**
 * Created by PhpStorm.
 * User: eduardcherkashyn
 * Date: 11/30/18
 * Time: 5:03 PM
 */

namespace App\Controller;


use App\Entity\Lesson;
use App\Entity\ScheduleLesson;
use App\Entity\Student;
use App\Form\CheckLessonType;
use App\Form\NewLessonType;
use App\Services\SortingByDay;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LessonController extends AbstractController
{
    /**
     * @Route("/listOfLessons", name="lessonsDueDay")
     */
    public function lessonsAction()
    {
        $repository = $this->getDoctrine()->getRepository(ScheduleLesson::class);
        $lessons = $repository->findBy(['dayOfTheWeek' => date('w')]);
        $sortedLessonsByDay = SortingByDay::indexAction($lessons);

        return $this->render('lessons.html.twig',[
            'lesssons' => $sortedLessonsByDay
        ]);
    }

    /**
     * @Route("/newLesson", name="createLesson")
     */
    public function newlessonAction(Request $request)
    {
        $lesson = new Lesson();
        $repository = $this->getDoctrine()->getRepository(Student::class);
        /**
         * @var Student $student
         */
        $student = $repository->findOneBy(['id'=>$_GET['id']]);
        $form = $this->createForm(NewLessonType::class,$lesson);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $student->addLessonsArchive($lesson);
            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->persist($lesson);
            $em->flush();

            return $this->redirectToRoute('lessonsDueDay');

        }

        return $this->render('createNewLesson.html.twig',[
            'create_lesson' => $form->createView(),
            'student' => $student
        ]);
    }


    /**
     * @Route("/checkLesson", name="check_Lesson")
     */
    public function checkLesson(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository(Student::class);
        /**
         * @var Student $student
         */
        $student = $repository->findOneBy(['id'=>$_GET['id']]);
        $lessons = $student->getLessonsArchive();
        if (!$lessons->isEmpty())
        {
            /**
             * @var Lesson $lesson
             */
            $lesson =  $lessons->last();
        }
        if($lesson->getMark()!==null){
            throw new \Exception('Lesson is not created');
            return $this->redirectToRoute('lessonsDueDay');
        }
        $form = $this->createForm(CheckLessonType::class,$lesson);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($lesson);
            $em->flush();

            return $this->redirectToRoute('lessonsDueDay');

        }

        return $this->render('checkLesson.html.twig',[
            'check_form' => $form->createView(),
            'student' => $student,
            'lesson' => $lesson
        ]);
    }

}