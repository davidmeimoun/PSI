<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace GestionnaireLivret\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Description of PrensentationEcType
 *
 * @author makadji
 */
class PresentationEcType extends AbstractType {
    
//    private $fid_ec;
    private $objectifs;
    private $competences;
    private $prerequis;
    private $plan_cours;
    private $bibliographie;
    private $cours_en_ligne;
    private $modalite_controle;
    private $erasmus;
    
     public function buildForm(FormBuilderInterface $builder, array $options)
    {   
//        $this->fid_ec = $options['fid_ec'];
        $this->objectifs = $options['objectifs'];
        $this->competences = $options['competences'];
        $this->prerequis = $options['prerequis'];
        $this->plan_cours = $options['plan_cours'];
        $this->bibliographie = $options['bibliographie'];
        $this->cours_en_ligne = $options['cours_en_ligne'];
        $this->modalite_controle = $options['modalite_controle'];
        $this->erasmus = $options['erasmus'];
         
        $builder
            ->add('objectifs', TextareaType::class, array(
                'label' => 'Objectifs' ,
                'data' => $this->objectifs,
                'required' => false,
                'attr' => array('cols' => 60, 'rows' => 5),
            ))
                 ->add('competences', TextareaType::class, array(
                'label' => 'Compétences' ,
                'data' => $this->competences,
                 'required' => false,
                'attr' => array('cols' => 60, 'rows' => 5),
            ))
                 ->add('prerequis', TextareaType::class, array(
                'label' => 'Pré-requis' ,
                'data' => $this->prerequis,
                 'required' => false,
                'attr' => array('cols' => 60, 'rows' => 5),
            ))
                 ->add('plan_cours', TextareaType::class, array(
                'label' => 'Approche pédagogique' ,
                'data' => $this->plan_cours,
                 'required' => false,
                'attr' => array('cols' => 60, 'rows' => 5),
            ))
                 ->add('bibliographie', TextareaType::class, array(
                'label' => 'Bibliographie' ,
                'data' => $this->bibliographie,
                'required' => false,
            ))
                 ->add('cours_en_ligne', ChoiceType::class, array(
                 'label' => 'Espace cours en ligne' ,
                 'choices' => array('OUI' => 'OUI', 'NON' => 'NON'),
                 'expanded' => FALSE,
                 'multiple' => false,
                 'preferred_choices' => array('OUI'),
                 'data' => $this->cours_en_ligne,
                 'required' => false,
            ))
                 ->add('modalite_controle', TextareaType::class, array(
                'label' => 'Modalités de contôle' ,
                'data' => $this->modalite_controle,
                 'required' => false,
                'attr' => array('cols' => 60, 'rows' => 5),
            ))
                 ->add('erasmus', TextareaType::class, array(
                'label' => 'ERASMUS' ,
                'data' => $this->erasmus,
                'required' => false,
                'attr' => array('cols' => 60, 'rows' => 5),
            ));
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'objectifs' => null,
            'competences' => null,
            'prerequis' => null,
            'plan_cours' => null,
            'bibliographie' => null,
            'cours_en_ligne' => null,
            'modalite_controle' => null,
            'erasmus' => null,
        ));
    }

    public function getName()
    {
        return 'presentation';
    }
}
