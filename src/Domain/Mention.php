<?php

namespace GestionnaireLivret\Domain;

class Mention 
{
    /**
     * Mention id.
     *
     * @var integer
     */
    private $id;

    /**
     * Diplome libelleMention.
     *
     * @var string
     */
    private $libelleMention;
    
        /**
     * Diplome FID_DOM.
     *
     * @var string
     */
    private $fid_dom;
    
    



    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function getLibelleMention() {
        return $this->libelleMention;
    }

    public function setLibelleMention($libelleMention) {
        $this->libelleMention = $libelleMention;
        return $this;
    }

    function getFid_dom() {
        return $this->fid_dom;
    }

    function setFid_dom($fid_dom) {
        $this->fid_dom = $fid_dom;
    }


}
