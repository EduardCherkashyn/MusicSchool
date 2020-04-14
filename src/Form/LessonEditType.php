<?php

namespace App\Form;

use App\Entity\Lesson;
use App\Entity\Student;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LessonEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date',DateType::class,[
                'label' => 'Дата'
            ])
            ->add('homework',TextareaType::class,[
                'label'=>'Завдання',
                'attr' => ['rows' => '10']
            ])
            ->add('attendance',CheckboxType::class, [
                'required' => false,
                'label' => 'Відвідування'])
            ->add('mark', ChoiceType::class,[
                'label'=>'Оцінка',
                'choices'  => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                    '7' => 7,
                    '8' => 8,
                    '9' => 9,
                    '10' => 10,
                    '11' => 11,
                    '12' => 12,
                ],
            ])
            ->add('markComment',TextType::class,[
                'label' => 'Коментар',
                'required'=> false
            ])
            ->add('youtubeLinks',CollectionType::class,[
                'entry_type' => YoutubeLinkType::class,
                'label' => 'Ютуб посилання'
            ])
            ->add('student',EntityType::class,[
                'class' => Student::class,
                'label' => 'Додати учня',
                'choice_label' => 'name'
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
