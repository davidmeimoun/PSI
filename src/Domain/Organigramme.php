<?php

namespace GestionnaireLivret\Domain;

class Organigramme
{
   private $fid_dip;
   private $universite;
   private $ufr;
   private $departement;
   
   function getFid_dip() {
       return $this->fid_dip;
   }

   function getUniversite() {
       return $this->universite;
   }

   function getUfr() {
       return $this->ufr;
   }

   function getDepartement() {
       return $this->departement;
   }

   function setFid_dip($fid_dip) {
       $this->fid_dip = $fid_dip;
   }

   function setUniversite($universite) {
       $this->universite = $universite;
   }

   function setUfr($ufr) {
       $this->ufr = $ufr;
   }

   function setDepartement($departement) {
       $this->departement = $departement;
   }


}
