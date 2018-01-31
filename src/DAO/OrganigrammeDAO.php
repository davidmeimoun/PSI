<?php

namespace GestionnaireLivret\DAO;

use Doctrine\DBAL\Connection;
use GestionnaireLivret\Domain\Organigramme;

class OrganigrammeDAO extends DAO
{
 
          public function findAll() {
      $sql = "select * from ORGANIGRAMME"; // order by ID_DIP desc
      $result = $this->getDb()->fetchAll($sql);
     
      // Convert query result to an array of domain objects
      $organigramme = array();
      foreach ($result as $row) {
          $organigrammeId = $row['FID_DIP'];
          $organigramme[$organigrammeId] = $this->buildDomainObject($row);
      }
      return $organigramme;
  }
 
 
  public function find($id) {
      $sql = "select * from ORGANIGRAMME where FID_DIP=?";
      $row = $this->getDb()->fetchAssoc($sql, array($id));

      if ($row) {
          return $this->buildDomainObject($row);
      } else {
          //throw new \Exception("No organigramme universitaire matching id " . $id);
      }
  }


  protected function buildDomainObject(array $row) {
       $organigramme= new Organigramme();
      $organigramme->setFid_dip($row['FID_DIP']);
      $organigramme->setDepartement($row['DEPARTEMENT']);
      $organigramme->setUfr($row['UFR']);
      $organigramme->setUniversite($row['UNIVERSITE']);
      return $organigramme;
  }
}
