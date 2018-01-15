<?php

namespace GestionnaireLivret\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    private $teachers;
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->teachers = $options['teacher_choices'];
        
        $builder        
            ->add('id', ChoiceType::class, [
                'label' => 'Teacher',
                'mapped' => true,
                'choices' => $this->teachers,
            ])
            ->add('username', TextType::class, array(
                'label' => 'username' ,
            ))
            ->add('password', RepeatedType::class, array(
                'type'            => PasswordType::class,
                 'invalid_message' => 'The password fields must match.',
                 'options'         => array('required' => true),
                 'first_options'   => array('label' => 'Password'),
                 'second_options'  => array('label' => 'Repeat password'),
             ))
            ->add('role', ChoiceType::class, array(
                'choices' => array('Admin' => 'ROLE_ADMIN', 'User' => 'ROLE_USER')
            ));
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
        'teacher_choices' => null,
        ));
    }

    public function getName()
    {
        return 'user';
    }
}