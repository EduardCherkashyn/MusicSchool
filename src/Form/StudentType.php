<?php

namespace App\Form;

use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Имя:'
            ])
            ->add('avatar',FileType::class,[
                'required' => false,
                'label' => 'Аватар:'
            ])
            ->add('email', EmailType::class,[
                'label'=> 'Имейл:'
            ])
            ->add('phone', TextType::class,[
                'label' => 'Телефон:'
            ])
            ->add(
                'lessons',
                CollectionType::class,
                [
                    'entry_type' => ScheduleLessonType::class,
                    'entry_options' => array('label' => false),
                ]
            );
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
