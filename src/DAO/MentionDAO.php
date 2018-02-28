<?php

namespace GestionnaireLivret\DAO;

use Doctrine\DBAL\Connection;
use GestionnaireLivret\Domain\Mention;

class MentionDAO extends DAO
{

	    public function findAll() {
        $sql = "select * from MENTION"; // order by ID_DIP desc
        $result = $this->getDb()->fetchAll($sql);
        
        // Convert query result to an array of domain objects
        $mentions = array();
        foreach ($result as $row) {
            $mentionId = $row['ID_MEN'];
            $mentions[$mentionId] = $this->buildDomainObject($row);
        }
        return $mentions;
    }


    
        public function findByDomaine($id) {
          $sql = 'select * from MENTION where FID_DOM =?';// order by ID_DIP desc
        $result = $this->getDb()->fetchAll($sql,array($id));
        
        // Convert query result to an array of domain objects
        $mentions = array();
        foreach ($result as $row) {
            $mentionId = $row['ID_MEN'];
            $mentions[$mentionId] = $this->buildDomainObject($row);
        }
        return $mentions;
    }
    

    
    protected function buildDomainObject(array $row) {
                $mention = new Mention();
        $mention->setId($row['ID_MEN']);
        $mention->setLibelleMention($row['LIBELLE_MENTION']);
        return $mention;
    }

}
