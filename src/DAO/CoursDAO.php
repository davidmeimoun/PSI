<?php

namespace GestionnaireLivret\DAO;

use Doctrine\DBAL\Connection;
use GestionnaireLivret\Domain\Cours;

class CoursDAO extends DAO
{
   
           public function findAll() {
       $sql = "select * from VUE_EC where VET != 'Charge pour fonction'"; // order by ID_DIP desc
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
               $sql = 'select * from VUE_EC  where VET != \'Charge pour fonction\' and FID_PERS =' .$FID_PERS .'';// order by ID_DIP desc
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
       $sql = "select * from VUE_EC where VET != 'Charge pour fonction' and ID_LIGNE=?";
       $row = $this->getDb()->fetchAssoc($sql, array($id));

       if ($row) {
           return $this->buildDomainObject($row);
       } else {
           throw new \Exception("No cours matching id " . $id);
       }
   }
      public function findByUE($ue) {
       //$sql = 'select * from EC, EC_UE_LISTEEC L where EC.ID_EC = L.FID_EC and L.FID_UE=' .$ue .'';// order by ID_DIP desc
          $sql = 'select * from VUE_EC V, EC_UE_LISTEEC L  where VET != \'Charge pour fonction\' and V.ID_LIGNE = L.FID_EC and L.FID_UE=' .$ue .'';
          $result = $this->getDb()->fetchAll($sql);
       
       // Convert query result to an array of domain objects
       $ec = array();
       foreach ($result as $row) {
           $ecId = $row['ID_LIGNE'];
           $ec[$ecId] = $this->buildDomainObject($row);
       }
       return $ec;
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
       $cours->setEcts($row['ECTS']);
       
       return $cours;
   }
}

