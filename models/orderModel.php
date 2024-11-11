<?php
class orderModel{
    private $id;
    private $id_user;
    private $date;
    private $state;
    private $total;

    function __construct($datos)
    {
        $this->id=$datos['id'];
        $this->id_user=$datos['id_user'];
        $this->date=$datos['date'];
        $this->state=$datos['state'];
        $this->total=$datos['total'];
    }
    
    function getId(){
        return $this->id;
    }

    function getId_user(){
        return $this->id_user;
    }

    function getDate(){
        return $this->date;
    }

    function getState(){
        return $this->state;
    }

    function getTotal(){
        return $this->total;
    }
}
?>