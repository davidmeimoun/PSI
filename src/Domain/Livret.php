<?php


namespace GestionnaireLivret\Domain;

class Livret 
{
   private $page_presentation;
   private $calendrier;
   private $organigramme;
   private $presentation;
   private $maquette;
   private $modules_enseignement;
   private $stage;
   private $modalites_examens;
   private $charte;
   

   function getPage_presentation() {
       return $this->page_presentation;
   }

   function getCalendrier() {
       return $this->calendrier;
   }

   function getOrganigramme() {
       return $this->organigramme;
   }

   function getPresentation() {
       return $this->presentation;
   }

   function getMaquette() {
       return $this->maquette;
   }

   function getModules_enseignement() {
       return $this->modules_enseignement;
   }

   function getStage() {
       return $this->stage;
   }

   function getModalites_examens() {
       return $this->modalites_examens;
   }

   function getCharte() {
       return $this->charte;
   }

   function setPage_presentation($page_presentation) {
       $this->page_presentation = $page_presentation;
   }

   function setCalendrier($calendrier) {
       $this->calendrier = $calendrier;
   }

   function setOrganigramme($organigramme) {
       $this->organigramme = $organigramme;
   }

   function setPresentation($presentation) {
       $this->presentation = $presentation;
   }

   function setMaquette($maquette) {
       $this->maquette = $maquette;
   }

   function setModules_enseignement($modules_enseignement) {
       $this->modules_enseignement = $modules_enseignement;
   }

   function setStage($stage) {
       $this->stage = $stage;
   }

   function setModalites_examens($modalites_examens) {
       $this->modalites_examens = $modalites_examens;
   }

   function setCharte($charte) {
       $this->charte = $charte;
   }


   
}
