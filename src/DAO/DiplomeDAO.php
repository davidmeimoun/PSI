<?php

namespace GestionnaireLivret\DAO;

use Doctrine\DBAL\Connection;
use GestionnaireLivret\Domain\Diplome;

class DiplomeDAO
{
    /**
     * Database connection
     *
     * @var \Doctrine\DBAL\Connection
     */
    private $db;

    /**
     * Constructor
     *
     * @param \Doctrine\DBAL\Connection The database connection object
     */
    public function __construct(Connection $db) {
        $this->db = $db;
    }
	
	    public function findAll() {
        $sql = "select * from DIPLOME"; // order by ID_DIP desc
        $result = $this->db->fetchAll($sql);
        
        // Convert query result to an array of domain objects
        $diplomes = array();
        foreach ($result as $row) {
            $diplomeId = $row['ID_DIP'];
            $diplomes[$diplomeId] = $this->buildDiplome($row);
        }
        return $diplomes;
    }

	    private function buildDiplome(array $row) {
        $diplome = new Diplome();
        $diplome->setId($row['ID_DIP']);
        $diplome->setLibelleDiplome($row['LIBELLE_DIPLOME']);
        return $diplome;
    }
    
}
