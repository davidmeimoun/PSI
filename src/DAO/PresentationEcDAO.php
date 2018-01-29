<?php
namespace GestionnaireLivret\DAO;
use Doctrine\DBAL\Connection;
use GestionnaireLivret\Domain\PresentationEc;
class PresentationEcDAO extends DAO
{
    
    	    public function findAll() {
        $sql = "select * from PRESENTATION_EC"; // order by ID_DIP desc
        $result = $this->getDb()->fetchAll($sql);
        
        // Convert query result to an array of domain objects
        $presentation = array();
        foreach ($result as $row) {
            $presentationId = $row['ID_PRESENTATION'];
            $presentation[$presentationId] = $this->buildDomainObject($row);
        }
        return $presentation;
    }
    
    public function find($id) {
        $sql = "select * from PRESENTATION_EC where ID_PRESENTATION=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));
        if ($row) {
            return $this->buildDomainObject($row);
        } else {
            throw new \Exception("No ec presentation matching id " . $id);
        }
    }
       public function findByEC($ec) {
        
           $sql = 'select * from PRESENTATION_EC  where FID_EC =' .$ec .'';
           $result = $this->getDb()->fetchAll($sql);
        
        // Convert query result to an array of domain objects
        $presentation = array();
        foreach ($result as $row) {
            $presentationId = $row['ID_PRESENTATION'];
            $presentation[$presentationId] = $this->buildDomainObject($row);
        }
        return array_shift(array_slice($presentation, 0, 1));
//            return $presentation;
    }
        // Retourne la présentation d'un cours
        public function findEcPresentation($ec) {
        $sql = "select * from PRESENTATION_EC  where FID_EC = ?";
        $row = $this->getDb()->fetchAll($sql, array($ec));//fetchAssoc($sql, array($ec));

        return $this->buildDomainObject($row);
    }
      
        public function isPresentationInDB(PresentationEc $presentation) {
        $req = "select * from PRESENTATION_EC  where FID_EC = ".$presentation->getFid_ec();
        $result = $this->getDb()->executeQuery($req); 
        if($result->fetch() == null){
            return FALSE;
        }else{
            return TRUE;
        }
    }
    
    public function save(PresentationEc $presentation) {
        $presentationData = array(
            'id_presentation'=> $presentation->getId_presentation(),
            'fid_ec' => $presentation->getFid_ec(),
            'objectifs' => $presentation->getObjectifs(),
            'competences' => $presentation->getCompetences(),
            'prerequis' => $presentation->getPrerequis(),
            'plan_cours' => $presentation->getPlanCours(),
            'bibliographie' => $presentation->getBibliographie(),
            'cours_en_ligne' => $presentation->getCoursEnLigne(),
            'modalite_controle' => $presentation->getModaliteControle(),
            'erasmus' => $presentation->getErasmus()
            );
        if ($this->isPresentationInDB($presentation)) {
            // The presentation has already been saved : update it
            $this->getDb()->update('presentation_ec', $presentationData, array('id_presentation' => $presentation->getFid_ec()));
        } else {
            // The presentation has never been saved : insert it
            $this->getDb()->insert('presentation_ec', $presentationData);
            // Get the id of the newly created user and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $presentation->setIdPresentation($id);
        }
    }
    
    
    protected function buildDomainObject(array $row) {
        $presentation= new PresentationEc();
        $presentation->setIdPresentation($row['ID_PRESENTATION']);
        $presentation->setFidEc($row['FID_EC']);
        $presentation->setObjectifs($row['OBJECTIFS']);
        $presentation->setCompetences($row['COMPETENCES']);
        $presentation->setPrerequis($row['PREREQUIS']);
        $presentation->setPlanCours($row['PLAN_COURS']);
        $presentation->setBibliographie($row['BIBLIOGRAPHIE']);
        $presentation->setCoursEnLigne($row['COURS_EN_LIGNE']);
        $presentation->setModaliteControle($row['MODALITE_CONTROLE']);
        $presentation->setErasmus($row['ERASMUS']);
        
        return $presentation;
    }
    
   
}