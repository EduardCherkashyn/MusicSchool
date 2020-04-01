<?php

namespace App\Form;

use App\Entity\ScheduleLesson;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScheduleLessonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dayOfTheWeek', ChoiceType::class, [
                'choices' => [
                  'Понедельник' => 1,
                  'Вторник' => 2,
                  'Среда' => 3,
                  'Четверг' => 4,
                  'Пятница' => 5,
                  'Суббота' => 6
            ],
                'label'=> 'День недели:'
            ])
            ->add('time', TimeType::class,[
                'label' => 'Время:'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ScheduleLesson::class,
        ]);
    }
}
