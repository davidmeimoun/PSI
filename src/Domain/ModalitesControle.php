<?php

namespace GestionnaireLivret\Domain;

class ModalitesControle
{
   private $fid_dip;
   private $descriptif;
   private $modalites_generales;
   private $modalites_specifiques;
   private $particularite_validation;
   private $deroulement_charte_examens;
   private $delivrance_diplome;
   
   function getFid_dip() {
       return $this->fid_dip;
   }

   function getDescriptif() {
       return $this->descriptif;
   }

   function getModalites_generales() {
       return $this->modalites_generales;
   }

   function getModalites_specifiques() {
       return $this->modalites_specifiques;
   }

   function getParticularite_validation() {
       return $this->particularite_validation;
   }

   function getDeroulement_charte_examens() {
       return $this->deroulement_charte_examens;
   }

   function getDelivrance_diplome() {
       return $this->delivrance_diplome;
   }

   function setFid_dip($fid_dip) {
       $this->fid_dip = $fid_dip;
   }

   function setDescriptif($descriptif) {
       $this->descriptif = $descriptif;
   }

   function setModalites_generales($modalites_generales) {
       $this->modalites_generales = $modalites_generales;
   }

   function setModalites_specifiques($modalites_specifiques) {
       $this->modalites_specifiques = $modalites_specifiques;
   }

   function setParticularite_validation($particularite_validation) {
       $this->particularite_validation = $particularite_validation;
   }

   function setDeroulement_charte_examens($deroulement_charte_examens) {
       $this->deroulement_charte_examens = $deroulement_charte_examens;
   }

   function setDelivrance_diplome($delivrance_diplome) {
       $this->delivrance_diplome = $delivrance_diplome;
   }


}
