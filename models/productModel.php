<?php
class productModel{
    private $id;
    private $name;
    private $stock;
    private $img;
    private $price;
    private $description;
    private $id_user;

    function __construct($datos)
    {
        $this->id=$datos['id'];
        $this->name=$datos['name'];
        $this->stock=$datos['stock'];
        $this->img=$datos['img'];
        $this->price=$datos['price'];
        $this->description=$datos['description'];
        $this->id_user=$datos['id_user'];
    }
    
    function getId(){
        return $this->id;
    }

    function getName(){
        return $this->name;
    }

    function getStock(){
        return $this->stock;
    }

    function getImg(){
        return $this->img;
    }

    function getPrice(){
        return $this->price;
    }

    function getDescription(){
        return $this->description;
    }

    function getId_user(){
        return $this->id_user;
    }
}
?>