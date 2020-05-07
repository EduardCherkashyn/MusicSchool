<?php
/**
 * Created by PhpStorm.
 * User: eduardcherkashyn
 * Date: 11/30/18
 * Time: 5:03 PM
 */

namespace App\Controller;

use App\Entity\File;
use App\Entity\Lesson;
use App\Entity\ScheduleLesson;
use App\Entity\Student;
use App\Form\CheckLessonType;
use App\Form\NewLessonType;
use App\Services\LessonCheck;
use App\Services\ScheduleSorting;
use App\Services\UrlParser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LessonController extends AbstractController
{
    /**
     * @Route("/admin/listOfLessons", name="lessonsDueDay")
     */
    public function lessonsAction()
    {
        $repository = $this->getDoctrine()->getRepository(ScheduleLesson::class);

        return $this->render('LessonController/lessons.html.twig', [
               'lesssons' => $repository->findByTeacherFieldLessonDueDay($this->getUser()->getTeacher(),date('w'))
        ]);
    }

    /**
     * @Route("/admin/newLesson/{id}", name="createLesson")
     */
    public function newLessonAction(Student $student, Request $request)
    {
        $lessons = $student->getLessonsArchive();
        if (!$lessons->isEmpty()) {
            /** @var Lesson $lesson */
            $lesson = $lessons->last();
            if ($lesson->getAttendance() === null) {
                $this->addFlash(
                    'notice',
                    'Перевірте попередній урок !'
                );
                return $this->redirectToRoute('lessonsDueDay');
            }
        }
        $lesson = new Lesson();
        $lesson->setStudent($student);
        $form = $this->createForm(NewLessonType::class, $lesson, ['data' => $lesson]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $student->addLessonsArchive($lesson);
            $files = $form['files']->getData();
            /** @var File $file */
            foreach ($files as $file){
                $lesson->addFile($file);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->persist($lesson);
            $em->flush();

            return $this->redirectToRoute('lessonsDueDay');
        }

        return $this->render('LessonController/createNewLesson.html.twig', [
                'create_lesson' => $form->createView(),
                'student' => $student
            ]);
    }

    /**
     * @Route("/admin/checkLesson/{id}", name="checkLesson")
     */
    public function checkLesson(Request $request, Student $student, LessonCheck $lessonCheck, UrlParser $parser)
    {
        $lesson = $lessonCheck->beforePutMark($student);
        if($lesson === null || $lesson->getAttendance() !== null) {
            $this->addFlash(
                    'notice',
                    'Урок ще не створений!'
                );
            return $this->redirectToRoute('lessonsDueDay');
        }
        if($lesson->getYoutubeLinks()){
            $parser->parseOneLink($lesson);
        }
        $form = $this->createForm(CheckLessonType::class, $lesson);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($lesson->getAttendance() === false){
              $lesson->setMark(null);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($lesson);
            $em->flush();

            return $this->redirectToRoute('lessonsDueDay');
        }

        return $this->render('LessonController/checkLesson.html.twig', [
                'check_form' => $form->createView(),
                'student' => $student,
                'lesson' => $lesson
            ]);
    }

    /**
     * @Route("/admin/schedule", name="lessonsDueWeek")
     */
    public function scheduleAction(ScheduleSorting $sorting)
    {
        $repository = $this->getDoctrine()->getRepository(ScheduleLesson::class);
        $lessons = $sorting->sort($repository->findByTeacherField($this->getUser()->getTeacher()));

        return $this->render('LessonController/schedule.html.twig', [
            'lessons' => $lessons
        ]);
    }
}
