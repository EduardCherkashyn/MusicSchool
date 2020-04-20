<?php

namespace App\Form;

use App\Entity\File;
use App\Entity\Lesson;
use App\Entity\Student;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class LessonType extends AbstractType
{

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
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
            ->add('student',EntityType::class,[
                'class' => Student::class,
                'label' => 'Ім\'я учня',
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->andWhere('s.teacher = ?1')
                        ->orderBy('s.name', 'ASC')
                        ->setParameter('1',$this->security->getUser()->getTeacher());
                }])
            ->add('files',  EntityType::class,[
                'class' => File::class,
                'label' => 'Додати файл',
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'mapped' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('f')
                        ->andWhere('f.teacher = ?1')
                        ->setParameter('1', $this->security->getUser()->getTeacher());
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
