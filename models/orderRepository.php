<?php
class orderRepository{
    public static function getOrder($id_user){
        $db = Conectar::conexion();
        $result = $db->query("SELECT * FROM order_product WHERE id_user = '".$id_user."' AND state = 0");
        if($row=$result->fetch_assoc()){
            return new orderModel($row);
        }else{
            return orderRepository::createOrder($id_user);
        };
    }

    public static function getOrders($id_user){
        $db = Conectar::conexion();
        $result = $db->query("SELECT * FROM order_product WHERE id_user = '".$id_user."' AND state > 1");
        $orders = array();
        while($row=$result->fetch_assoc()){
            $orders[] = new orderModel($row);
        }
        return $orders;
    }

    public static function getOrderStates(){ 
        $db = Conectar::conexion();
        $result = $db->query("SELECT * FROM order_product WHERE state = 1 OR state = 2");
        $orders = array();
        while($row=$result->fetch_assoc()){
            $orders[] = new orderModel($row);
        }
        return $orders;
    }


    public static function makeOrder($id_user, $state){
        $db = Conectar::conexion();
        $result = $db->query("SELECT id FROM order_product WHERE id_user = '".$id_user."' AND state = 0");
        if($row=$result->fetch_assoc()){
            $id = $row['id'];
            if($state === 2){
                $lineas = $db->query("SELECT id_product, amount FROM line_product WHERE id_order_product = ".$id);
                while($rowLines=$lineas->fetch_assoc()){
                    $db->query("UPDATE product SET stock = stock- ".$rowLines['amount']." WHERE id = ".$rowLines['id_product']);
                }
            }
            $db->query("UPDATE order_product SET state = '".$state."' WHERE id=".$id);
            return true;
        }else{
            return false;
        }
    }

    public static function changeState($id_order, $state){
        $db = Conectar::conexion();
        if($state == 1){
            $result = $db->query("UPDATE order_product SET state = 2 WHERE id = '".$id_order."'");
        }else{
            $result = $db->query("UPDATE order_product SET state = 3 WHERE id = '".$id_order."'");
        }
        return $result ? true : false; 
    }


    private static function createOrder($id_user){
        $db = Conectar::conexion();
        $db->query("INSERT INTO order_product (id, id_user, date, state) VALUES (NULL, '".$id_user."', '". (new DateTime())->format('Y-m-d')."', 0)");
        $result = $db->query("SELECT * FROM order_product WHERE id_user = '".$id_user."'");
        if($row=$result->fetch_assoc()){
            return new orderModel($row);
        }
    }


}
?>