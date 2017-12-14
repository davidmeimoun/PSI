<?php

namespace GestionnaireLivret\DAO;

use Doctrine\DBAL\Connection;
use GestionnaireLivret\Domain\Cours;

class CoursDAO extends DAO
{
    
    	    public function findAll() {
        $sql = "select * from VUE_LS_PER where VET != 'Charge pour fonction'"; // order by ID_DIP desc
        $result = $this->getDb()->fetchAll($sql);
        
        // Convert query result to an array of domain objects
        $cours = array();
        foreach ($result as $row) {
            $coursId = $row['ID_LIGNE'];
            $cours[$coursId] = $this->buildDomainObject($row);
        }
        return $cours;
    }
    
        public function findByTeacher($FID_PERS){
                $sql = 'select * from VUE_LS_PER where VET != \'Charge pour fonction\' and FID_PERS =' .$FID_PERS .'';// order by ID_DIP desc
        $result = $this->getDb()->fetchAll($sql);
        
        // Convert query result to an array of domain objects
        $cours = array();
        foreach ($result as $row) {
            $coursId = $row['ID_LIGNE'];
            $cours[$coursId] = $this->buildDomainObject($row);
        }
        return $cours;
    }
    
    public function find($id) {
        $sql = "select * from VUE_LS_PER where VET != 'Charge pour fonction' and ID_LIGNE=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));

        if ($row) {
            return $this->buildDomainObject($row);
        } else {
            throw new \Exception("No cours matching id " . $id);
        }
    }



    protected function buildDomainObject(array $row) {
         $cours= new Cours();
        $cours->setId_ligne($row['ID_LIGNE']);
        $cours->setNomEnseignant($row['NOM']);
        $cours->setNumHarpegeEnseignant($row['N_HARP']);
        $cours->setLibelle($row['LIBELLE']);
        $cours->setCode($row['CODE']);
        $cours->setLib_groupe($row['LIB_GROUPE']);
        $cours->setSemestre($row['SEM']);
        $cours->setVet($row['VET']);
        $cours->setH_cm($row['H_CM']);
        $cours->setH_td($row['H_TD']);
        
        return $cours;
    }

}
