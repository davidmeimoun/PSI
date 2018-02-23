<?php
namespace GestionnaireLivret\DAO;
use Doctrine\DBAL\Connection;
use GestionnaireLivret\DAO\DiplomeDAO;
use GestionnaireLivret\DAO\CoursDAO;
use GestionnaireLivret\Domain\UE;
class UeDAO extends DAO
{
    
    public function findAll() {
        $sql = "select * from UE";
        $result = $this->getDb()->fetchAll($sql);
        
        // Convert query result to an array of domain objects
        $ue = array();
        foreach ($result as $row) {
            $ueId = $row['ID_UE'];;
            $ue[$ueId] = $this->buildDomainObject($row);
        }
        return $ue;
    }
    public function find($id) {
        $sql = "select * from UE where ID_UE=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));
        if ($row) {
            return $this->buildDomainObject($row);
        } else {
            throw new \Exception("No ue matching id " . $id);
        }
    }
    

    
        public function findByDiplomeEtSemestre($diplome, $semestre) {
            $sql = 'select * from DIPLOME dip, UE ue,SEMESTRE_UE sem where dip.ID_DIP = ' .$diplome .' and dip.ID_DIP = ue.FID_DIP and ue.ID_UE = sem.FID_UE and sem.NUM_SEMESTRE = '.$semestre.'';
    
        $result = $this->getDb()->fetchAll($sql);
        
        // Convert query result to an array of domain objects
        $ues = array();
        $i = 0;
        foreach ($result as $row) {
            
            $ueId = $row['ID_UE'];
            $ues[$i] = $this->buildDomainObject($row);
            $i++;
        }
        return $ues;
        }
        
                public function findByParcours($parcours) {
        $sql = 'select * from UE, SEMESTRE_UE S where S.FID_UE = UE.ID_UE and FID_PARCOURS=' .$parcours .'';
        $result = $this->getDb()->fetchAll($sql);
        
        // Convert query result to an array of domain objects
        $ues = array();
        foreach ($result as $row) {
            $ueId = $row['ID_UE'];
            $ues[$ueId] = $this->buildDomainObject($row);
        }
        return $ues;
        }
        
        
        
    protected function buildDomainObject(array $row) {
         $ue= new UE();
         $ue->setId($row['ID_UE']);
         $ue->setLibelle($row['LIBELLE_UE']);
         //$ue->setDiplome(DiplomeDAO::find($row['FID_DIP']));
         
        
     
         
      
        return $ue;
    }
}