<?php
namespace GestionnaireLivret\Domain;
class Parcours{
    
    private $id;
    private $fid_specialite;
    private $libelle;
    private $pourcentage;
    function getId() {
        return $this->id;
    }
    function getFid_specialite() {
        return $this->fid_specialite;
    }
    function getLibelle() {
        return $this->libelle;
    }
    function getPourcentage() {
        return $this->pourcentage;
    }
    function setId($id) {
        $this->id = $id;
    }
    function setFid_specialite($fid_specialite) {
        $this->fid_specialite = $fid_specialite;
    }
    function setLibelle($libelle) {
        $this->libelle = $libelle;
    }
    function setPourcentage($pourcentage) {
        $this->pourcentage = $pourcentage;
    }
}