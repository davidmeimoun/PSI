<?php
namespace GestionnaireLivret\Domain;
class UE{
    
    /**
     * ID de l'UE
     * @var integer Description
     */
    private $id;
    
    /** 
     * Libelle de l'UE
     * @var string 
     */
    private $libelle;
    
    /**
     * Liste des EC associés à cette UE
     * 
     */
    private $ec ;
    
    /**
     * Diplome associé à cette UE
     * @var Diplome
     */
    private $diplome;
    
 
        
    
    function getId() {
        return $this->id;
    }
    function getLibelle() {
        return $this->libelle;
    }
    function getEc() {
        return $this->ec;
    }
    function getDiplome() {
        return $this->diplome;
    }
    function setId($id) {
        $this->id = $id;
    }
    function setLibelle($libelle) {
        $this->libelle = $libelle;
    }
    function setEc($ec) {
        $this->ec = $ec;
    }
    function setDiplome(type $diplome) {
        $this->diplome = $diplome;
    }
}