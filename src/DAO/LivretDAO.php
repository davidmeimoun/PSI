<?php
namespace GestionnaireLivret\DAO;

use GestionnaireLivret\Domain\Livret;
use GestionnaireLivret\Domain\ModalitesControle;
use GestionnaireLivret\Domain\ModulesEnseignement;

class LivretDAO extends DAO {
   
     
public function findMention($id) {
       $sql = "select LIBELLE_MENTION from DIPLOME, MENTION where ID_MEN = FID_MEN and ID_DIP =?";
       $row = $this->getDb()->fetchAssoc($sql, array($id));
       if ($row) {
           return $row['LIBELLE_MENTION'];
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
           return " ";
       }  
   }
       
   public function findPresentation($id) {
       $sql = "select DESCRIPTIF from PRESENTATION_FORMATION where FID_DIP=?";
       $row = $this->getDb()->fetchAssoc($sql, array($id));
       if ($row) {
           return $row['DESCRIPTIF'];
       } else {
           return " ";
       }  
   }
   
       public function findCharte() {
       $sql = "select descriptif from CHARTE_VIVRE_ENSEMBLE where FID_DIP=1";
       $row = $this->getDb()->fetchAssoc($sql);
       if ($row) {
           return $row['DESCRIPTIF'];
       } else {
           return " ";
       }  
   }
   
   
       public function findModalitesControle($id) {
       $sql = "select * from MODALITES_DE_CONTROLE where FID_DIP=?";
       $row = $this->getDb()->fetchAssoc($sql, array($id));
       $modalites = new ModalitesControle();
       if ($row) {
           $modalites->setFid_dip($row['FID_DIP']);
           $modalites->setModalites_generales($row['MODALITES_GENERALES']);
           $modalites->setModalites_specifiques($row['MODALITES_SPECIFIQUES']);
           $modalites->setParticularite_validation($row['PARTICULARITE_VALIDATION']);
           $modalites->setDeroulement_charte_examens($row['DEROULEMENT_CHARTE_EXAMENS']);
           $modalites->setDelivrance_diplome($row['DELIVRANCE_DIPLOME']);

           return $modalites;
       } else {
           $modalites->setFid_dip($id);
           $modalites->setModalites_generales(" ");
           $modalites->setModalites_specifiques(" ");
           $modalites->setParticularite_validation(" ");
           $modalites->setDeroulement_charte_examens(" ");
           $modalites->setDelivrance_diplome(" ");
           return $modalites;
       }  
   }
   
   
      public function findStages($id) {
       $sql = "select descriptif from STAGES where FID_DIP=?";
       $row = $this->getDb()->fetchAssoc($sql, array($id));
       if ($row) {
           return $row['DESCRIPTIF'];
       } else {
           return " ";
       }  
   }
   
       
       public function findModulesEnseignement($id) {
       $sql = "select * from MODULES_ENSEIGNEMENT where FID_DIP=?";
       $row = $this->getDb()->fetchAssoc($sql, array($id));
       $modules = new ModulesEnseignement();
       if ($row) {
           $modules->setFid_dip($row['FID_DIP']);
           $modules->setModules_transversaux($row['MODULES_TRANSVERSAUX']);
           $modules->setLangues_vivantes($row['LANGUES_VIVANTES']);
           $modules->setBonus_diplomes($row['BONUS_DIPLOMES']);

           return $modules;
       } else {
           $modules->setFid_dip($id);
           $modules->setModules_transversaux(" ");
           $modules->setLangues_vivantes(" ");
           $modules->setBonus_diplomes(" ");
           return $modules;
       }  
   }
   
       public function save(Livret $livret) {
         $CalendrierData = array(
             'FID_DIP' => $livret->getOrganigramme()->getFid_dip(),
            'descriptif' => $livret->getCalendrier(),
            );
         
         $PresentationData = array(
            'FID_DIP' => $livret->getOrganigramme()->getFid_dip(),
            'descriptif' => $livret->getPresentation(),
            );
         
         $charteData = array(
            'descriptif' => $livret->getCharte(),
            );
         
         $modalitesEnseignementData = array(
            'FID_DIP' => $livret->getModules_enseignement()->getFid_dip(),
            'MODULES_TRANSVERSAUX' => $livret->getModules_enseignement()->getModules_transversaux(),
            'LANGUES_VIVANTES' => $livret->getModules_enseignement()->getLangues_vivantes(),
            'BONUS_DIPLOMES' => $livret->getModules_enseignement()->getBonus_diplomes(),
            );
  
          $modalitesControleData = array(
           'FID_DIP' => $livret->getModalites_examens()->getFid_dip(),
           'MODALITES_GENERALES' => $livret->getModalites_examens()->getModalites_generales(),
           'MODALITES_SPECIFIQUES'=> $livret->getModalites_examens()->getModalites_specifiques(),
           'PARTICULARITE_VALIDATION'=> $livret->getModalites_examens()->getParticularite_validation(),
           'DEROULEMENT_CHARTE_EXAMENS'=> $livret->getModalites_examens()->getDeroulement_charte_examens(),
           'DELIVRANCE_DIPLOME'=> $livret->getModalites_examens()->getDelivrance_diplome(),
            );
         
           $stageData = array(
            'FID_DIP' => $livret->getModalites_examens()->getFid_dip(),
            'descriptif' => $livret->getStage(),
            );
           
        if($this->isExistingInDB($livret->getOrganigramme()->getFid_dip(), 'CALENDRIER_UNIVERSITAIRE')){
            $this->getDb()->update('CALENDRIER_UNIVERSITAIRE', $CalendrierData, array('FID_DIP' => $livret->getOrganigramme()->getFid_dip()));
        } else {
            $this->getDb()->insert('CALENDRIER_UNIVERSITAIRE', $CalendrierData);
        }
           if($this->isExistingInDB($livret->getOrganigramme()->getFid_dip(), 'PRESENTATION_FORMATION')){
            $this->getDb()->update('PRESENTATION_FORMATION', $PresentationData, array('FID_DIP' => $livret->getOrganigramme()->getFid_dip()));
        } else {
            $this->getDb()->insert('PRESENTATION_FORMATION', $PresentationData);
        }
           if($this->isExistingInDB(1, 'CHARTE_VIVRE_ENSEMBLE')){
            $this->getDb()->update('CHARTE_VIVRE_ENSEMBLE', $charteData, array('FID_DIP' => 1));
        } else {
            $this->getDb()->insert('CHARTE_VIVRE_ENSEMBLE', $charteData);
        }
           if($this->isExistingInDB($livret->getModules_enseignement()->getFid_dip(), 'MODULES_ENSEIGNEMENT')){
            $this->getDb()->update('MODULES_ENSEIGNEMENT', $modalitesEnseignementData, array('FID_DIP' => $livret->getModules_enseignement()->getFid_dip()));
        } else {
            $this->getDb()->insert('MODULES_ENSEIGNEMENT', $modalitesEnseignementData);
        }
           if($this->isExistingInDB($livret->getModalites_examens()->getFid_dip(), 'MODALITES_DE_CONTROLE')){
            $this->getDb()->update('MODALITES_DE_CONTROLE', $modalitesControleData, array('FID_DIP' => $livret->getModalites_examens()->getFid_dip()));
        } else {
            $this->getDb()->insert('MODALITES_DE_CONTROLE', $modalitesControleData);
        }
           if($this->isExistingInDB($livret->getModalites_examens()->getFid_dip(), 'STAGES')){
            $this->getDb()->update('STAGES', $stageData, array('FID_DIP' => $livret->getModalites_examens()->getFid_dip()));
        } else {
            $this->getDb()->insert('STAGES', $stageData);
        }
        
    }
    
    public function isExistingInDB($id, $db_name) {
        $req = "select * from $db_name where FID_DIP = ".$id;
        $result = $this->getDb()->executeQuery($req); 
        if($result->fetch() == null){
            return FALSE;
        }else{
            return TRUE;
        }
    }
   
     protected function buildDomainObject(array $row) {
       $livret= new Livret();
      return $livret;
  }
   

}
