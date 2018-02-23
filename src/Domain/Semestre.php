<?php

namespace GestionnaireLivret\Domain;

class Semestre 
{
    /**
     * Diplome id.
     *
     * @var integer
     */
    private $numSemestre;

    /**
     * Diplome libelleDiplome.
     *
     * @var string
     */
    private $fidParcours;

    /**
     * Diplome FID_MEN.
     *
     * @var string
     */
    
    private  $ue;
    
    private $diplome;
    
    
    function getDiplome() {
        return $this->diplome;
    }

    function setDiplome($diplome) {
        $this->diplome = $diplome;
    }

        function getNumSemestre() {
        return $this->numSemestre;
    }

    function getFidParcours() {
        return $this->fidParcours;
    }

    function getUe() {
        return $this->ue;
    }

    function setUe($ue) {
        $this->ue = $ue;
    }

    
    function setNumSemestre($numSemestre) {
        $this->numSemestre = $numSemestre;
    }

    function setFidParcours($fidParcours) {
        $this->fidParcours = $fidParcours;
    }

 



}
