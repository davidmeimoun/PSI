<?php

namespace GestionnaireLivret\DAO;

use Doctrine\DBAL\Connection;
use GestionnaireLivret\Domain\Cours;

class CoursDAO extends DAO
{
   
public function findAll() {
      $sql = "select * from EC"; // order by ID_DIP desc
      $result = $this->getDb()->fetchAll($sql);
     
      // Convert query result to an array of domain objects
      $cours = array();
      foreach ($result as $row) {
          $coursId = $row['ID_EC'];
          $cours[$coursId] = $this->buildDomainObject($row);
      }
      return $cours;
  }
   
public function findByTeacher($FID_PERS){
              $sql = 'select distinct  LIBELLE_EC , ID_EC, ID_LIGNE, COD_ELP, VOLUME_HEURE_CM,VOLUME_HEURE_TD,NB_CREDIT from EC, LIGNE_SERVICE L where L.FID_EC = EC.ID_EC and L.FID_PERS =' .$FID_PERS .'';// order by ID_DIP desc
      $result = $this->getDb()->fetchAll($sql);
     
      // Convert query result to an array of domain objects
      $cours = array();
      foreach ($result as $row) {
          $coursId = $row['ID_LIGNE'];
          $cours[$coursId] = $this->buildDomainObject($row);
      }
      return $cours;
  }
  
  public function findByDiplome($id_dip){
              $sql = 'select * from EC_UE_LISTEEC , EC, UE where FID_UE = ID_UE and FID_EC = ID_EC and UE.FID_DIP = ' .$id_dip .'';// order by ID_DIP desc
      $result = $this->getDb()->fetchAll($sql);
     
      // Convert query result to an array of domain objects
      $cours = array();
      foreach ($result as $row) {
          $coursId = $row['ID_EC'];
          $cours[$coursId] = $this->buildDomainObject($row);
      }
      return $cours;
  }
   
   
public function find($id) {
      $sql = "select * from EC where ID_EC=?";
      $row = $this->getDb()->fetchAssoc($sql, array($id));

      if ($row) {
          return $this->buildDomainObject($row);
      } else {
          throw new \Exception("No cours matching id " . $id);
      }
  }
public function findByUE($ue) {
      //$sql = 'select * from EC, EC_UE_LISTEEC L where EC.ID_EC = L.FID_EC and L.FID_UE=' .$ue .'';// order by ID_DIP desc
         $sql = 'select * from EC , EC_UE_LISTEEC L  where  EC.ID_EC = L.FID_EC and L.FID_UE=' .$ue .'';
         $result = $this->getDb()->fetchAll($sql);
     
      // Convert query result to an array of domain objects
      $ec = array();
      foreach ($result as $row) {
          $ecId = $row['ID_EC'];
          $ec[$ecId] = $this->buildDomainObject($row);
      }
      return $ec;
  }


protected function buildDomainObject(array $row) {
       $cours= new Cours();
      $cours->setId_ligne($row['ID_EC']);
      //$cours->setNomEnseignant($row['NOM']);
      //$cours->setNumHarpegeEnseignant($row['N_HARP']);
      $cours->setLibelle($row['LIBELLE_EC']);
      $cours->setCode($row['COD_ELP']);
      //$cours->setLib_groupe($row['LIB_GROUPE']);
      //$cours->setSemestre($row['SEM']);
      //$cours->setVet($row['VET']);
      $cours->setH_cm($row['VOLUME_HEURE_CM']);
      $cours->setH_td($row['VOLUME_HEURE_TD']);
      $cours->setEcts($row['NB_CREDIT']);
     
      return $cours;
  }
  }

