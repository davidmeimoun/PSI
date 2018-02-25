<?php


namespace GestionnaireLivret\Domain;

class ServicesNumeriques
{
    private $fid_dip;
    private $email_universitaire;
    private $ent;
    
    
    function getFid_dip() {
        return $this->fid_dip;
    }

    function setFid_dip($fid_dip) {
        $this->fid_dip = $fid_dip;
    }

        function getEmail_universitaire() {
        return $this->email_universitaire;
    }

    function getEnt() {
        return $this->ent;
    }

    function setEmail_universitaire($email_universitaire) {
        $this->email_universitaire = $email_universitaire;
    }

    function setEnt($ent) {
        $this->ent = $ent;
    }


}
