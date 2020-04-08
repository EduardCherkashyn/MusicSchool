<?php

namespace App\Form;

use App\Entity\Lesson;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CheckLessonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('attendance', CheckboxType::class, [
                'required' => false,
                'label' => 'Посещение:'
            ])
            ->add('mark', IntegerType::class, [
                'required' => false,
                'attr' => [
                    'min' => 1,
                    'max' => 12
                ],
                'label'=>'Оценка:'
            ])
            ->add('markComment', TextareaType::class,[
                'required' => false,
                'label'=>'Комментарий:'
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lesson::class,
            'isProcessorDisable'=> false
        ]);
    }
}
