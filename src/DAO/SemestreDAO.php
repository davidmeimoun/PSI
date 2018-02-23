<?php

namespace GestionnaireLivret\DAO;

use Doctrine\DBAL\Connection;
use GestionnaireLivret\Domain\Semestre;

class SemestreDAO extends DAO
{
   
public function findAll() {
      $sql = "select * from SEMESTRE_UE"; // order by ID_DIP desc
      $result = $this->getDb()->fetchAll($sql);
     
      // Convert query result to an array of domain objects
      $cours = array();
      foreach ($result as $row) {
          $coursId = $row['NUM_SEMESTRE'];
          $cours[$coursId] = $this->buildDomainObject($row);
      }
      return $cours;
  }
   

   
public function find($id) {
      $sql = "select  DISTINCT NUM_SEMESTRE  from SEMESTRE_UE, UE ue where FID_UE = ue.ID_UE and FID_DIP =?";
      $row = $this->getDb()->fetchAssoc($sql, array($id));
      $cours = array();
      foreach ($result as $row) {
          $coursId = $row['NUM_SEMESTRE'];
          $cours[$coursId] = $this->buildDomainObject($row);
      }
      return $cours;
}

protected function buildDomainObject(array $row) {
       $semestre= new Semestre();
      $semestre->setNumSemestre($row['NUM_SEMESTRE']);
      $semestre->setFidParcours ($row['FID_PARCOURS']);
      
     
      return $semestre;
  }

 

}

