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
    
    protected function buildDomainObject(array $row) {
                $diplome = new Diplome();
        $diplome->setId($row['ID_DIP']);
        $diplome->setLibelleDiplome($row['LIBELLE_DIPLOME']);
        return $diplome;
    }

}
