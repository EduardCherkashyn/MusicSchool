<?php

namespace App\Form;

use App\Entity\Lesson;
use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewLessonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $days = [1 => "monday",2 => "tuesday", 3 => "wednesday", 4 => "thursday", 5 => "friday", 6 => "saturday"];

        /**
         * @var Student $student
         */
        $student = $options['data']->getStudent();
        $lessons = $student->getLessons();
        $studLessons = [];
        foreach ($lessons as $lesson) {
            $studLessons[] = $lesson->getDayOfTheWeek();
        }
        $firstLesson = new \DateTime(date('Y-m-d', strtotime($days[$studLessons[0]])));
        $secondLesson = new \DateTime(date('Y-m-d', strtotime($days[$studLessons[1]])));
        $firstLesson2 = $firstLesson->modify('+7 days');
        $secondLesson2 = $secondLesson->modify('+7 days');

        $builder
            ->add('date', ChoiceType::class, [
               'choices' => [
                   date('Y-m-d', strtotime($days[$studLessons[0]])) => $firstLesson,
                   date('Y-m-d', strtotime($days[$studLessons[1]])) => $secondLesson,
                   $firstLesson2->format('Y-m-d') => $firstLesson2,
                   $secondLesson2->format('Y-m-d') => $secondLesson2,
               ]])
            ->add('homework', TextareaType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lesson::class,
        ]);
    }
}
