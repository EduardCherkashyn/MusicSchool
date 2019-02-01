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
                  'Monday' => 1,
                  'Tuesday' => 2,
                  'Wednesday' => 3,
                  'Thursday' => 4,
                  'Friday' => 5,
                  'Saturday' => 6
            ]])
            ->add('time', TimeType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ScheduleLesson::class,
        ]);
    }
}
