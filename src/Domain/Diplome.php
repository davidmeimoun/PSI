<?php

namespace GestionnaireLivret\Domain;

class Diplome 
{
    /**
     * Diplome id.
     *
     * @var integer
     */
    private $id;

    /**
     * Diplome libelleDiplome.
     *
     * @var string
     */
    private $libelleDiplome;

    /**
     * Diplome FID_MEN.
     *
     * @var string
     */
    private $fidMen;
    
    
    
    

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getLibelleDiplome() {
        return $this->libelleDiplome;
    }

    public function setLibelleDiplome($libelleDiplome) {
        $this->libelleDiplome = $libelleDiplome;
        return $this;
    }

    function getFidMen() {
        return $this->fidMen;
    }

    function setFidMen($fidMen) {
        $this->fidMen = $fidMen;
    }


}
