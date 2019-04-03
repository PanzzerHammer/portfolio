<?php

class User {
    
    private $id;
    private $login;
    private $email;
    private $droit;
    
    public function __construct($id, $login, $email, $droit){
        $this->id = $id;
        $this->login = $login;
        $this->email = $email;
        $this->droit = $droit;
    }
    
    function getId() {
        return $this->id;
    }

    function getLogin() {
        return $this->login;
    }

    function getEmail() {
        return $this->email;
    }

    function getDroit() {
        return $this->droit;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setLogin($login) {
        $this->login = $login;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setDroit($droit) {
        $this->droit = $droit;
    }

}