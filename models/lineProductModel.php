<?php
class lineProductModel{
    private $id_order_product;
    private $id_product;
    private $amount;
    private $price_unity;
    private $discount;

    function __construct($datos)
    {
        $this->id_order_product=$datos['id_order_product'];
        $this->id_product=$datos['id_product'];
        $this->amount=$datos['amount'];
        $this->price_unity=$datos['price_unity'];
        $this->discount=$datos['discount'];
    }
    
    function getId_order_product(){
        return $this->id_order_product;
    }

    function getId_product(){
        return $this->id_product;
    }

    function getAmount(){
        return $this->amount;
    }

    function getPrice_unity(){
        return $this->price_unity;
    }

    function getDiscount(){
        return $this->discount;
    }
}
?>