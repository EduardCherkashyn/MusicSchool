<?php

namespace App\Form;

use App\Entity\File;
use App\Entity\Lesson;
use App\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewLessonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $days = [1 => "Monday",2 => "Tuesday", 3 => "Wednesday", 4 => "Thursday", 5 => "Friday", 6 => "Saturday"];

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
        $firstLesson2 = new \DateTime(date('Y-m-d', strtotime($days[$studLessons[0]])));
        $secondLesson2 = new \DateTime(date('Y-m-d', strtotime($days[$studLessons[1]])));
        $firstLesson2->modify('+7 days');
        $secondLesson2->modify('+7 days');

        $builder
            ->add('date', ChoiceType::class, [
                'choices' => [
                    $firstLesson->format('Y-m-d') => $firstLesson,
                    $secondLesson->format('Y-m-d') => $secondLesson,
                    $firstLesson2->format('Y-m-d') => $firstLesson2,
                    $secondLesson2->format('Y-m-d') => $secondLesson2,
                ],
                'label'=>'Дата:'
            ])
            ->add('files',  EntityType::class,[
                'class' => File::class,
                'label' => 'Додати файл',
                'choice_label' => 'name',
                'choice_value' => function (File $entity) {
                    return $entity ? $entity->getId() : '';
                },
                 'multiple' => true,
                 'expanded' => true,
                 'mapped' => false
            ])
            ->add('homework', TextareaType::class,[
                'label'=>'Завдання:'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lesson::class,
        ]);
    }
}

