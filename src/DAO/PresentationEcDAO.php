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
        return array_shift(array_slice($presentation, 0, 1)); ;
    }
           
    
 /* public function save(PresentationEc $presentation) {
        $presentationData = array(
              'id_presentation'=> $presentation->getId_presentation(),
            'fid_ec' => $presentation->getFid_ec(),
            'objectifs' => $presentation->getAuthor()->getId(),
            'competences' => $presentation->getCompetences(),
             'prerequis' => $presentation->getPrerequis(),
             'plan_cours' => $presentation->getPlan_cours(),
             'bibliographie' => $presentation->getBibliographie(),
             'cours_en_ligne' => $presentation->getCours_en_ligne(),
             'modalite_controle' => $presentation->getModalite_controle(),
             'erasmus' => $presentation->getErasmus()
            );
        if ($presentation->getFid_ec()) {
            // The presentation has already been saved : update it
            $this->getDb()->update('presentation_ec', $presentationData, array('presentation_id' => $presentation->getFid_ec()));
        } else {
            // The user has never been saved : insert it
            $this->getDb()->insert('presenttation_ec', $presentationData);
            // Get the id of the newly created user and set it on the entity.
            $id = $this->getDb()->lastInsertId();
            $presentation->setId_presentation($id);
        }
    }*/
    protected function buildDomainObject(array $row) {
        $presentation= new PresentationEc();
        $presentation->setId_presentation($row['ID_PRESENTATION']);
        $presentation->setFid_ec($row['FID_EC']);
        $presentation->setObjectifs($row['OBJECTIFS']);
        $presentation->setCompetences($row['COMPETENCES']);
        $presentation->setPrerequis($row['PREREQUIS']);
        $presentation->setPlan_cours($row['PLAN_COURS']);
        $presentation->setBibliographie($row['BIBLIOGRAPHIE']);
        $presentation->setCours_en_ligne($row['COURS_EN_LIGNE']);
        $presentation->setModalite_controle($row['MODALITE_CONTROLE']);
        $presentation->setErasmus($row['ERASMUS']);
        
        
        return $presentation;
    }
    
   
}