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
                  'Понеділок' => 1,
                  'Вівторок' => 2,
                  'Середа' => 3,
                  'Четвер' => 4,
                  'П\'ятниця' => 5,
                  'Субота' => 6
            ],
                'label'=> 'День тижня:'
            ])
            ->add('time', TimeType::class,[
                'label' => 'Час:'
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
