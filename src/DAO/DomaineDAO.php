<?php

namespace GestionnaireLivret\DAO;

use GestionnaireLivret\Domain\Domaine;

class DomaineDAO extends DAO
{
    public function findAll() {
        $sql = "select * from DOMAINE"; // order by ID_DIP desc
      //  $result = $this->db->fetchAll($sql);
         $result = $this->getDb()->fetchAll($sql);
        // Convert query result to an array of domain objects
        $domaines = array();
        foreach ($result as $row) {
            $domaineId = $row['ID_DOM'];
            $domaines[$domaineId] = $this->buildDomainObject($row);
        }
        return $domaines;
    }


    public function find($id) {
        $sql = "select * from DOMAINE where ID_DOM=?";
        $row = $this->getDb()->fetchAssoc($sql, array($id));
        if ($row) {
            return $this->buildDomainObject($row);
        } else {
            throw new \Exception("No domaine matching id " . $id);
        }
    }
    
    protected function buildDomainObject(array $row) {
                $domaine = new Domaine();
        $domaine->setId($row['ID_DOM']);
        $domaine->setLibelleDomaine($row['LIBELLE_DOMAINE']);
        return $domaine;
    }

}
