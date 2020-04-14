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
use App\Entity\YoutubeLink;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use App\Services\FileUploader;
use App\Services\PasswordEditing;
use App\Services\UrlParser;
use Knp\Component\Pager\PaginatorInterface;
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
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy(['student'=> $student->getId()]);
        $em->remove($user);
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
    public function profileAction(Request $request, PaginatorInterface $paginator, UrlParser $parser)
    {
        $parser->parse($this->getUser()->getStudent());
        $pagination = $paginator->paginate(
            $this->getUser()->getStudent()->getLessonsArchive(), /* query NOT result */
            $request->query->getInt('page', 1),
            3
        );
        return $this->render('StudentController/profile.html.twig', [
            'student' => $this->getUser()->getStudent(),
            'lessons' => $pagination
        ]);
    }

    /**
     * @Route("/video_upload", name="videoUpload")
     */
    public function videoUploadAction(Request $request)
    {
        if($this->getDoctrine()->getRepository(YoutubeLink::class)->findOneBy(['path'=>$request->get('data')])){
            return new JsonResponse('',404);
        }
        $lesson = $this->getDoctrine()->getRepository(Lesson::class)->findOneBy(['id'=> $request->get('id')]);
        $link = new YoutubeLink();
        $link->setPath($request->get('data'));
        $lesson->addYoutubeLink($link);
        $this->getDoctrine()->getManager()->persist($lesson);
        $this->getDoctrine()->getManager()->persist($link);
        $this->getDoctrine()->getManager()->flush();
        $vsm = new VideoServiceMatcher();
        $video = $vsm->parse($link->getPath());
        $link = $video->getEmbedUrl();

        return new JsonResponse(['output' => $link]);

    }

    /**
     * @Route("/diagramm_data", name="diagramm_data")
     */
    public function getResultsdAction(Request $request, StudentRepository $studentRepository)
    {
        $student = $studentRepository->findOneBy(['id'=> $request->get('student')]);
        $lessons = $student->getLessonsArchive();
        $data = [];
        $data[0] = ['Дата', 'Оцінка' ];
        $i = 1;
        /** @var Lesson $lesson */
        foreach ($lessons as $lesson){
            $data[$i][] = $lesson->getDate()->format('d-m-Y');
            $data[$i][] = $lesson->getMark();
            $i++;
        }

        return new JsonResponse($data);

    }
}
