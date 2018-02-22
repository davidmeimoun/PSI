<?php

namespace GestionnaireLivret\Domain;

class Domaine 
{
    /**
     * Diplome id.
     *
     * @var integer
     */
    private $id;

    /**
     * Diplome libelleDomaine.
     *
     * @var string
     */
    private $libelleDomaine;



    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getLibelleDomaine() {
        return $this->libelleDomaine;
    }

    public function setLibelleDomaine($libelleDomaine) {
        $this->libelleDomaine = $libelleDomaine;
        return $this;
    }

}
