<?php
/**
 * Created by PhpStorm.
 * User: eduardcherkashyn
 * Date: 2020-04-21
 * Time: 08:19
 */

namespace App\Form;


use App\Entity\Lesson;
use App\Entity\Student;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    $builder
        ->add('student',EntityType::class,[
            'required' => false,
            'placeholder' => 'Обрати всіх',
            'class' => Student::class,
            'label' => 'Фільтр за учнем:',
            'mapped' => false,
            'choice_label' => 'name',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('s')
                    ->orderBy('s.name', 'ASC');
            }
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


