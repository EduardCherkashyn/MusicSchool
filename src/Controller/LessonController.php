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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


class LessonController extends AbstractController
{
    /**
     * @Route("/listOfLessons", name="lessonsDueDay")
     */
    public function lessonsAction(SortingByDay $sortingByDay)
    {
        $repository = $this->getDoctrine()->getRepository(ScheduleLesson::class);
        $lessons = $repository->findBy(['dayOfTheWeek' => date('w')]);
        $sortedLessonsByDay = $sortingByDay->indexAction($lessons);

        return $this->render('LessonController/lessons.html.twig',[
            'lesssons' => $sortedLessonsByDay
        ]);
    }

    /**
     * @Route("/newLesson/{id}", name="createLesson")
     */
    public function newLessonAction(Student $student,Request $request)
    {
        $lesson = new Lesson();
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

        return $this->render('LessonController/createNewLesson.html.twig',[
            'create_lesson' => $form->createView(),
            'student' => $student
        ]);
    }


    /**
     * @Route("/checkLesson/{id}", name="checkLesson")
     */
    public function checkLesson(Request $request,Student $student)
    {
        $lessons = $student->getLessonsArchive();
        if (!$lessons->isEmpty()) {
            /**
             * @var Lesson $lesson
             */
            $lesson = $lessons->last();
        }else{
            $lesson=null;
            $this->addFlash(
                'notice',
                'The lesson have not been created yet !'
            );
            return $this->redirectToRoute('lessonsDueDay');
        }

        if($lesson->getMark()!==null){
            $this->addFlash(
                'notice',
                'The lesson have not been created yet !'
            );
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

        return $this->render('LessonController/checkLesson.html.twig',[
            'check_form' => $form->createView(),
            'student' => $student,
            'lesson' => $lesson
        ]);


}
}