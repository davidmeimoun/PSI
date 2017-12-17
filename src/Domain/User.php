<?php

namespace GestionnaireLivret\Domain;

use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    /**
     * User id.
     *
     * @var integer
     */
    private $id;

    /**
     * User name.
     *
     * @var string
     */
    private $username;

    /**
     * User password.
     *
     * @var string
     */
    private $password;

    /**
     * Salt that was originally used to encode the password.
     *
     * @var string
     */
    private $salt;

    /**
     * Role.
     * Values : ROLE_USER or ROLE_ADMIN.
     *
     * @var string
     */
    private $role;
    
        /**
     * Role.
     * Values : string.
     *
     * @var string
     */
    private $nom;
            /**
     * Role.
     * Values : string.
     *
     * @var string
     */
    private $prenom;
    
    
        /**
     * Role.
     * Values : ***@u-paris10.fr.
     *
     * @var string
     */
    private $email;
    
            /**
     * Role.
     * Values : string.
     *
     * @var string
     */
    private $numHarpege;
    
    function getId() {
        return $this->id;
    }

    function getUsername() {
        return $this->username;
    }

    function getPassword() {
        return $this->password;
    }

    function getSalt() {
        return $this->salt;
    }

    function getRole() {
        return $this->role;
    }

    function getNom() {
        return $this->nom;
    }

    function getPrenom() {
        return $this->prenom;
    }

    function getEmail() {
        return $this->email;
    }

    function getNumHarpege() {
        return $this->numHarpege;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUsername($username) {
        $this->username = $username;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setSalt($salt) {
        $this->salt = $salt;
    }

    function setRole($role) {
        $this->role = $role;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setNumHarpege($numHarpege) {
        $this->numHarpege = $numHarpege;
    }
        /**
     * @inheritDoc
     */
    public function eraseCredentials() {
        // Nothing to do here
    }

    public function getRoles() {
       return array($this->getRole());
    }

}
