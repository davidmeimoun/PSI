<?php

namespace GestionnaireLivret\Domain;

class ModulesEnseignement 
{

   private $fid_dip;
   private $modules_transversaux;
   private $langues_vivantes;
   private $bonus_diplomes;
   
   function getFid_dip() {
       return $this->fid_dip;
   }

   function getModules_transversaux() {
       return $this->modules_transversaux;
   }

   function getLangues_vivantes() {
       return $this->langues_vivantes;
   }

   function getBonus_diplomes() {
       return $this->bonus_diplomes;
   }

   function setFid_dip($fid_dip) {
       $this->fid_dip = $fid_dip;
   }

   function setModules_transversaux($modules_transversaux) {
       $this->modules_transversaux = $modules_transversaux;
   }

   function setLangues_vivantes($langues_vivantes) {
       $this->langues_vivantes = $langues_vivantes;
   }

   function setBonus_diplomes($bonus_diplomes) {
       $this->bonus_diplomes = $bonus_diplomes;
   }




}
