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
use App\Services\FileUploader;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StudentController extends AbstractController
{

    /**
     * @Route("/newStudent", name="addStudent")
     */
    public function addAction(Request $request, FileUploader $fileUploader)
    {
        $student = new Student();
        $lesson = new ScheduleLesson();
        $lesson2 = new ScheduleLesson();
        $student->addLesson($lesson);
        $student->addLesson($lesson2);
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var UploadedFile $file
             */
            $file = $request->files->get('student')['avatar'];
            $fileName = $fileUploader->upload($file);
            $student->setAvatar($fileName);
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
    public function editAction(Student $student, Request $request, FileUploader $fileUploader, Filesystem $filesystem, ContainerInterface $container)
    {
        $avatar = $student->getAvatar();
        if($avatar != null) {
            $student->setAvatar(
                new File($this->getParameter('avatars_directory') .'/'.$avatar)
            );
        }
        $form = $this->createForm(StudentType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /**
             * @var UploadedFile $file
             */
            $file = $request->files->get('student')['avatar'];
            if($file !== null) {
                $fileName = $fileUploader->upload($file);
                $student->setAvatar($fileName);
                $root = $container->get('kernel')->getProjectDir();
                if($avatar != null) {
                    $filesystem->remove($root . '/public/avatars/' . $avatar);
                }
            }
            else{
                $student->setAvatar($avatar);
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();

            return $this->redirectToRoute('editStudent',['id'=>$student->getId()]);
        }

        return $this->render('StudentController/EditStudentForm.html.twig', [
            'edit_form' => $form->createView(),
            'student' => $student,
            'avatar' => $avatar
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
