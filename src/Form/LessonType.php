<?php

namespace App\Form;

use App\Entity\File;
use App\Entity\Lesson;
use App\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LessonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date',DateType::class,[
                'label' => 'Дата'
            ])
            ->add('homework',TextareaType::class,[
                'label'=>'Задание',
                'attr' => ['rows' => '10']
            ])
            ->add('student',EntityType::class,[
                'class' => Student::class,
                'label' => 'Имя студента',
                'choice_label' => 'name'
            ])
            ->add('files',  EntityType::class,[
                'class' => File::class,
                'label' => 'Добавить файл',
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'mapped' => false
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
