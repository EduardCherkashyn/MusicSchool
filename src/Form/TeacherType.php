<?php

namespace App\Form;

use App\Entity\Teacher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeacherType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',TextType::class,[
                'label' => 'Ім\'я'
            ])
            ->add('type',ChoiceType::class,[
                'choices'=>[
                    'private' => 'private',
                    'group' => 'group'
                 ],
                'label' => 'Тип'
            ])
            ->add('email',TextType::class,[
                'mapped'=> false,
                'label' => 'Імейл'
            ])
            ->add('password',PasswordType::class,[
                'mapped'=> false,
                'label' => 'Пароль'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Teacher::class,
        ]);
    }
}
