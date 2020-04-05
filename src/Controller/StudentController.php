<?php
/**
 * Created by PhpStorm.
 * User: eduardcherkashyn
 * Date: 11/25/18
 * Time: 4:25 PM
 */

namespace App\Controller;

use App\Entity\Lesson;
use App\Entity\Student;
use App\Entity\ScheduleLesson;
use App\Entity\User;
use App\Form\StudentType;
use App\Services\FileUploader;
use App\Services\PasswordEditing;
use App\Services\UrlParser;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use RicardoFiorani\Matcher\VideoServiceMatcher;


class StudentController extends AbstractController
{

    /**
     * @Route("/admin/newStudent", name="addStudent")
     */
    public function addAction(Request $request, FileUploader $fileUploader,UserPasswordEncoderInterface $passwordEncoder)
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
            $user = new User();
            $user->setEmail($student->getEmail());
            $user->setPassword($passwordEncoder->encodePassword($user,$student->getPhone()));
            $user->setStudent($student);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
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
     * @Route("/admin/delete/{id}", name="deleteStudent")
     */
    public function deleteAction(Student $student)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($student);
        $em->flush();

        return $this->redirectToRoute('showStudents');
    }

    /**
     * @Route("/admin/edit/{id}", name="editStudent")
     */
    public function editAction(Student $student, Request $request, FileUploader $fileUploader, Filesystem $filesystem, ContainerInterface $container, PasswordEditing $passwordEditing)
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
            $passwordEditing->check($student);
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
     * @Route("/admin", name="showStudents")
     */
    public function showAllAction()
    {
        $repository = $this->getDoctrine()->getRepository(Student::class);
        $students = $repository->findBy([],['name' => 'ASC']);

        return $this->render('StudentController/showAllStudents.html.twig', [
          'students' => $students
        ]);
    }

    /**
     * @Route("/admin/student_results/{id}", name="studentScore")
     */
    public function resultsAction(Student $student)
    {
        return $this->render('StudentController/studentResults.html.twig', [
            'student' => $student
        ]);
    }

    /**
     * @Route("/profile", name="studentProfile")
     */
    public function profileAction(UrlParser $parser)
    {
        $parser->parse($this->getUser()->getStudent());

        return $this->render('StudentController/profile.html.twig', [
            'student' => $this->getUser()->getStudent()
        ]);
    }

    /**
     * @Route("/video_upload", name="videoUpload")
     */
    public function videoUploadAction(Request $request)
    {
        if($this->getDoctrine()->getRepository(Lesson::class)->findOneBy(['youtubeLink'=>$request->get('data')])){
            return new JsonResponse('',404);
        }
        $lesson = $this->getDoctrine()->getRepository(Lesson::class)->findOneBy(['id'=> $request->get('id')]);
        $lesson->setYoutubeLink($request->get('data'));
        $this->getDoctrine()->getManager()->persist($lesson);
        $this->getDoctrine()->getManager()->flush();
        $vsm = new VideoServiceMatcher();
        $video = $vsm->parse($lesson->getYoutubeLink());
        $link = $video->getEmbedUrl();

        return new JsonResponse(['output' => $link]);

    }
}
