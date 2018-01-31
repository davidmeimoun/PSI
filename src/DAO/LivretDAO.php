<?php
namespace GestionnaireLivret\DAO;
use Doctrine\DBAL\Connection;
use GestionnaireLivret\Domain\Livret;
use GestionnaireLivret\Domain\ModalitesControle;
use GestionnaireLivret\Domain\ModulesEnseignement;

class LivretDAO extends DAO{
   
     
public function findMention($id) {
       $sql = "select mention_apo from APOGEE_LIAISON_PARCOURS where CODE_PARCOURS=?";
       $row = $this->getDb()->fetchAssoc($sql, array($id));
       if ($row) {
           return $row['MENTION_APO'];
       } else {
          throw new \Exception("No presentation matching id " . $id);
       }  
   }
   
       public function findCalendrier($id) {
       $sql = "select descriptif from CALENDRIER_UNIVERSITAIRE where FID_DIP=?";
       $row = $this->getDb()->fetchAssoc($sql, array($id));
       if ($row) {
           return $row['DESCRIPTIF'];
       } else {
           //throw new \Exception("No presentation matching id " . $id);
       }  
   }
       
   public function findPresentation($id) {
       $sql = "select description from PRESENTATION_FORMATION where FID_DIP=?";
       $row = $this->getDb()->fetchAssoc($sql, array($id));
       if ($row) {
           return $row['DESCRIPTION'];
       } else {
           //throw new \Exception("No presentation matching id " . $id);
       }  
   }
   
       public function findCharte() {
       $sql = "select descriptif from CHARTE_VIVRE_ENSEMBLE where FID_DIP=1";
       $row = $this->getDb()->fetchAssoc($sql);
       if ($row) {
           return $row['DESCRIPTIF'];
       } else {
           //throw new \Exception("No charte matching id ");
       }  
   }
   
   
       public function findModalitesControle($id) {
       $sql = "select * from MODALITES_DE_CONTROLE where FID_DIP=?";
       $row = $this->getDb()->fetchAssoc($sql, array($id));
       if ($row) {
           $modalites = new ModalitesControle();
           $modalites->setFid_dip($row['FID_DIP']);
           $modalites->setModalites_generales($row['MODALITES_GENERALES']);
           $modalites->setModalites_specifiques($row['MODALITES_SPECIFIQUES']);
           $modalites->setParticularite_validation($row['PARTICULARITE_VALIDATION']);
           $modalites->setDeroulement_charte_examens($row['DEROULEMENT_CHARTE_EXAMENS']);
           $modalites->setDelivrance_diplome($row['DELIVRANCE_DIPLOME']);

           return $modalites;
       } else {
           //throw new \Exception("No presentation matching id " . $id);
       }  
   }
   
   
      public function findStages($id) {
       $sql = "select descriptif from STAGES where FID_DIP=?";
       $row = $this->getDb()->fetchAssoc($sql, array($id));
       if ($row) {
           return $row['DESCRIPTIF'];
       } else {
           //throw new \Exception("No presentation matching id " . $id);
       }  
   }
   
       
       public function findModulesEnseignement($id) {
       $sql = "select * from MODULES_ENSEIGNEMENT where FID_DIP=?";
       $row = $this->getDb()->fetchAssoc($sql, array($id));
       if ($row) {
           $modules = new ModulesEnseignement();
           $modules->setFid_dip($row['FID_DIP']);
           $modules->setModules_transversaux($row['MODULES_TRANSVERSAUX']);
           $modules->setLangues_vivantes($row['LANGUES_VIVANTES']);
           $modules->setBonus_diplomes($row['BONUS_DIPLOMES']);

           return $modules;
       } else {
           //throw new \Exception("No presentation matching id " . $id);
       }  
   }
     protected function buildDomainObject(array $row) {
       $livret= new Livret();
      return $livret;
  }
   

}
