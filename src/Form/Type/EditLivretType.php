<?php

namespace GestionnaireLivret\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class EditLivretType extends AbstractType {
    
   private $calendrier;
   private $presentation;
   private $maquette;
   private $modules_transversaux;
   private $ufr;
   private $departement;
   private $stage;
   private $langues_vivantes;
   private $bonus_diplomes;
   private $modalites_generales;
   private $modalites_specifiques;
   private $particularite_validation;
   private $deroulement_charte_examens;
   private $delivrance_diplome;
   private $charte;
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {   
        $this->calendrier = $options['calendrier'];
        $this->universite = $options['universite'];
        $this->ufr = $options['ufr'];
        $this->departement = $options['departement'];
        $this->presentation = $options['presentation'];
        $this->maquette = $options['maquette'];
        $this->modules_transversaux = $options['modules_transversaux'];
        $this->langues_vivantes = $options['langues_vivantes'];
        $this->bonus_diplomes = $options['bonus_diplomes'];
        $this->stage = $options['stage'];
        $this->modalites_generales = $options['modalites_generales'];
        $this->modalites_specifiques = $options['modalites_specifiques'];
        $this->particularite_validation = $options['particularite_validation'];
        $this->deroulement_charte_examens = $options['deroulement_charte_examens'];
        $this->delivrance_diplome = $options['delivrance_diplome'];
        $this->charte = $options['charte'];
         
        $builder
                ->add('calendrier', TextareaType::class, array(
                'label' => 'Calendrier universitaire' ,
                'data' => $this->calendrier,
                 'required' => false,
                'attr' => array('cols' => 60, 'rows' => 5),
            ))
                ->add('universite', TextareaType::class, array(
                'label' => 'Universite' ,
                'data' => $this->universite,
                'required' => false,
                'mapped' => false,
                'attr' => array('cols' => 60, 'rows' => 5),
            ))
                ->add('ufr', TextareaType::class, array(
                'label' => 'UFR' ,
                'data' => $this->ufr,
                'required' => false,
                'mapped' => false,
                'attr' => array('cols' => 60, 'rows' => 5),
            ))
                ->add('departement', TextareaType::class, array(
                'label' => 'DEPARTEMENT' ,
                'data' => $this->departement,
                'required' => false,
                'mapped' => false,
                'attr' => array('cols' => 60, 'rows' => 5),
            ))
                 ->add('presentation', TextareaType::class, array(
                'label' => 'Présentation de la formation' ,
                'data' => $this->presentation,
                 'required' => false,
                'attr' => array('cols' => 60, 'rows' => 5),
            ))
                 ->add('modules_transversaux', TextareaType::class, array(
                'label' => 'Modules transversaux' ,
                'data' => $this->modules_transversaux,
                 'required' => false,
                 'mapped' => false,
                'attr' => array('cols' => 60, 'rows' => 5),
            ))
                     ->add('langues_vivantes', TextareaType::class, array(
                'label' => 'Langues vivantes' ,
                'data' => $this->langues_vivantes,
                'mapped' => false,
                 'required' => false,
                'attr' => array('cols' => 60, 'rows' => 5),
            ))
                ->add('bonus_diplomes', TextareaType::class, array(
                'label' => 'Bonus diplômes' ,
                'data' => $this->bonus_diplomes,
                 'required' => false,
                 'mapped' => false,
                'attr' => array('cols' => 60, 'rows' => 5),
            ))
                 ->add('stage', TextareaType::class, array(
                'label' => 'STAGES' ,
                'data' => $this->stage,
                 'required' => false,
                'attr' => array('cols' => 60, 'rows' => 5),
            ))
                 ->add('modalites_generales', TextareaType::class, array(
                'label' => 'Modalités générales' ,
                'data' => $this->modalites_generales,
                'required' => false,
                 'mapped' => false,
                'attr' => array('cols' => 60, 'rows' => 5),
            ))
                     ->add('modalites_specifiques', TextareaType::class, array(
                'label' => 'Modalités spécifiques' ,
                'data' => $this->modalites_specifiques,
                'required' => false,
                 'mapped' => false,
                'attr' => array('cols' => 60, 'rows' => 5),
            ))
                     ->add('particularite_validation', TextareaType::class, array(
                'label' => 'Particularités de validation ' ,
                'data' => $this->particularite_validation,
                'required' => false,
                 'mapped' => false,
                'attr' => array('cols' => 60, 'rows' => 5),
            ))
                     ->add('deroulement_charte_examens', TextareaType::class, array(
                'label' => 'Déroulement et charte des examens' ,
                'data' => $this->deroulement_charte_examens,
                'required' => false,
                 'mapped' => false,
                'attr' => array('cols' => 60, 'rows' => 5),
            ))
                     ->add('delivrance_diplome', TextareaType::class, array(
                'label' => 'Délivrance du diplôme ' ,
                'data' => $this->delivrance_diplome,
                'required' => false,
                 'mapped' => false,
                'attr' => array('cols' => 60, 'rows' => 5),
            ))
                 ->add('charte', TextareaType::class, array(
                'label' => 'CHARTE DU VIVRE ENSEMBLE' ,
                'data' => $this->charte,
                'required' => false,
                'attr' => array('cols' => 60, 'rows' => 5),
            ));
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'calendrier' => null,
            'organigramme' => null,
            'presentation' => null,
            'maquette' => null,
            'modules_transversaux' => null,
            'bonus_diplomes'  => null,
            'stage' => null,
            'modalites_generales' => null,
            'modalites_specifiques' => null,
            'particularite_validation' => null,
            'deroulement_charte_examens' => null,
            'delivrance_diplome' => null,
            'charte' => null,
            'ufr' => null,
            'universite' => null,
            'departement' => null,
            'langues_vivantes' => null
        ));
    }

    public function getName()
    {
        return 'editLivret';
    }
}
