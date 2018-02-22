<?php

namespace GestionnaireLivret\DAO;

use Doctrine\DBAL\Connection;
use GestionnaireLivret\Domain\Diplome;

class DiplomeDAO extends DAO
{

	    public function findAll() {
        $sql = "select * from DIPLOME"; // order by ID_DIP desc
        $result = $this->db->fetchAll($sql);
        
        // Convert query result to an array of domain objects
        $diplomes = array();
        foreach ($result as $row) {
            $diplomeId = $row['ID_DIP'];
            $diplomes[$diplomeId] = $this->buildDomainObject($row);
        }
        return $diplomes;
    }


    public function find($id) {
        $sql = "select * from DIPLOME where ID_DIP=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));
        if ($row) {
            return $this->buildDomainObject($row);
        } else {
            throw new \Exception("No diplome matching id " . $id);
        }
    }
    
        public function findByMention($id) {

         $sql = 'select * from DIPLOME where FID_MEN=' .$id .'';// order by ID_DIP desc
      $result = $this->getDb()->fetchAll($sql);
     
      // Convert query result to an array of domain objects
      $cours = array();
      foreach ($result as $row) {
          $coursId = $row['ID_DIP'];
          $cours[$coursId] = $this->buildDomainObject($row);
      }
      return $cours;
    }
    
         public function nombreDeSemestreDuDiplome($id) {
        $sql = 'select COUNT(DISTINCT NUM_SEMESTRE) as result from SEMESTRE_UE, UE ue where FID_UE = ue.ID_UE and FID_DIP = ' .$id .'';
        $result = $this->getDb()->fetchAll($sql);
        foreach ($result as $row) {
          $reponse = $row['RESULT'];
         return $reponse;
      }
    }
    
    protected function buildDomainObject(array $row) {
                $diplome = new Diplome();
        $diplome->setId($row['ID_DIP']);
        $diplome->setFidMen($row['FID_MEN']);
        $diplome->setLibelleDiplome($row['LIBELLE_DIPLOME']);
        return $diplome;
    }

}
