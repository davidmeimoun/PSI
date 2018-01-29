<?php
namespace GestionnaireLivret\DAO;
use Doctrine\DBAL\Connection;
use GestionnaireLivret\Domain\Parcours;
class ParcoursDAO extends DAO{
    
       
    public function findAll() {
        $sql = "select * from PARCOURS "; 
        $result = $this->getDb()->fetchAll($sql);
        
        // Convert query result to an array of domain objects
        $parcours = array();
        foreach ($result as $row) {
            $parcoursId = $row['ID_PARCOURS'];
            $parcours[$parcoursId] = $this->buildDomainObject($row);
        }
        return $parcours;
    }
    
    
        
    public function find($id) {
        $sql = "select * from PARCOURS where ID_LIGNE=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));
        if ($row) {
            return $this->buildDomainObject($row);
        } else {
            throw new \Exception("No parcours matching id " . $id);
        }
    }
    
        protected function buildDomainObject(array $row) {
            $parcours= new Parcours();
            $parcours->setId($row['ID_PARCOURS']);
            $parcours->setFid_specialite($row['FID_SPECIALITE']);
            $parcours->setLibelle($row['LIBELLE_PARCOURS']);
            $parcours->setPourcentage($row['POURCENTAGE']);  
            return $parcours;
    }
}