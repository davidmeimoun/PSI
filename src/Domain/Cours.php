<?php

namespace GestionnaireLivret\Domain;

class Cours 
{
    /**
     * Article id ligne.
     *
     * @var integer
     */
    private $id_ligne;

    /**
     * Cours nom de l'enseignant.
     *
     * @var string
     */
    private $nomEnseignant;

    /**
     * Cours numero harpege du professeur chargé du cours.
     *
     * @var string
     */
    private $numHarpegeEnseignant;
    
     /**
     * Cours libelle du cours.
     *
     * @var string
     */
    private $libelle;
    
     /**
     * Cours code du cours.
     *
     * @var string
     */
    private $code;

     /**
     * Cours libelle du groupe du cours.
     *
     * @var string
     */
    private $lib_groupe;
    
     /**
     * Cours semestre du cours.
     *
     * @var string
     */
    private $semestre;
    
     /**
     * Cours vet du cours.
     *
     * @var string
     */
    private $vet;
    
     /**
     * Cours heure cm du cours.
     *
     * @var string
     */
    private $h_cm;
    
     /**
     * Cours heure td du cours.
     *
     * @var string
     */
    private $h_td;
    
     /**
     * ects.
     *
     * @var string
     */
    
    private $ects;
    
     /**
     * Presentation.
     *
     * @var string
     */    
    private $presentation;
    
    
    function getId_ligne() {
        return $this->id_ligne;
    }

    function getNomEnseignant() {
        return $this->nomEnseignant;
    }

    function getNumHarpegeEnseignant() {
        return $this->numHarpegeEnseignant;
    }

    function getLibelle() {
        return $this->libelle;
    }

    function getCode() {
        return $this->code;
    }

    function getLib_groupe() {
        return $this->lib_groupe;
    }

    function getSemestre() {
        return $this->semestre;
    }

    function getVet() {
        return $this->vet;
    }

    function getH_cm() {
        return $this->h_cm;
    }

    function getH_td() {
        return $this->h_td;
    }

    function setId_ligne($id_ligne) {
        $this->id_ligne = $id_ligne;
    }

    function setNomEnseignant($nomEnseignant) {
        $this->nomEnseignant = $nomEnseignant;
    }

    function setNumHarpegeEnseignant($numHarpegeEnseignant) {
        $this->numHarpegeEnseignant = $numHarpegeEnseignant;
    }

    function setLibelle($libelle) {
        $this->libelle = $libelle;
    }

    function setCode($code) {
        $this->code = $code;
    }

    function setLib_groupe($lib_groupe) {
        $this->lib_groupe = $lib_groupe;
    }

    function setSemestre($semestre) {
        $this->semestre = $semestre;
    }

    function setVet($vet) {
        $this->vet = $vet;
    }

    function setH_cm($h_cm) {
        $this->h_cm = $h_cm;
    }

    function setH_td($h_td) {
        $this->h_td = $h_td;
    }

    function getPresentation() {
        return $this->presentation;
    }
    function setPresentation($presentation) {
        $this->presentation = $presentation;
    }
  function getEcts() {
        return $this->ects;
    }
    function setEcts($ects) {
        $this->ects = $ects;
    }

}
