<?php

class UserModel{
    private $id;
    private $username;
    private $isAdmin;
    function __construct($datos)
	{
		$this->id=$datos['id'];
		$this->username=$datos['username'];
        $this->isAdmin=$datos['isAdmin'];
	}

    function getId(){
        return $this->id;
    }

    function getUsername(){
        return $this->username;
    }

    function getIsAdmin(){
        return $this->isAdmin;
    }
}

?>