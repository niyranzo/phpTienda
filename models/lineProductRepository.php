<?php
    class lineProduct{

        public static function getLinesProducts($idUser){
            $db = Conectar::conexion();
            $result = $db->query("SELECT * FROM line_product WHERE id_order_product = '".orderRepository::getOrder($idUser)->getId()."'");
            $lines= array();
            while($row=$result->fetch_assoc()){
                $lines[]= new lineProductModel($row);
            }
            return $lines;
        }           

        public static function getLinesEnviados($idOrder){
            $db = Conectar::conexion();
            $result = $db->query("SELECT * FROM line_product WHERE id_order_product = '".$idOrder->getId()."'");
            $lines= array();
            while($row=$result->fetch_assoc()){
                $lines[]= new lineProductModel($row);
            }
            return $lines;
        }

        public static function setLineProduct($idOrder, $idProduct, $amount, $price_unity, $discount){
            $db = Conectar::conexion();
            $result = $db->query("SELECT * FROM line_product WHERE id_order_product ='".$idOrder->getId()."' AND id_product = '".$idProduct."'");
            //actualizar el total del pedido:
            $productPrice = $db->query("SELECT price FROM product WHERE id = '".$idProduct."'");
            if($rowPrice=$productPrice->fetch_assoc()){
                $db->query("UPDATE order_product SET total = total + ('".$amount."'*'".$rowPrice['price']."') WHERE id = '".$idOrder->getId()."'");
            }
            //si la linea existe, se actualiza
            if($row=$result->fetch_assoc()){
                $db->query("UPDATE line_product SET amount = amount+'".$amount."' WHERE id_order_product ='".$idOrder->getId()."' AND id_product = '".$idProduct."'");
                return true;
            }else{
                $db->query("INSERT INTO line_product (id_order_product, id_product, amount, price_unity, discount)
                VALUES ('".$idOrder->getId()."', '".$idProduct."', '".$amount."', '".$price_unity."', '".$discount."')");
                return false;
            }
        }

        public static function getAmountBought($idProduct, $idUser){
            $db = Conectar::conexion();
            $pedidos = orderRepository::getOrders($idUser);
            $cantidadComprado = 0; 
            foreach($pedidos as $pedido){
                $result = $db->query("SELECT * FROM line_product WHERE id_order_product = '".$pedido->getId()."' && id_product = '".$idProduct."'");
                if($row=$result->fetch_assoc()){
                    $cantidadComprado+= $row['amount'];
                }
            }
            return $cantidadComprado;
        }

        public static function getProductoMasVendido (){
            $db = Conectar::conexion();
            $result = $db->query("SELECT p.name, SUM(ol.amount) AS total_sold FROM line_product ol JOIN order_product o ON ol.id_order_product = o.id JOIN product p ON ol.id_product = p.id WHERE o.state = 1 GROUP BY p.id, p.name ORDER BY total_sold DESC LIMIT 1;");
            if($row=$result->fetch_assoc()){
                return [$row['name'], $row['total_sold']];
            }
        }

        public static function getUsuarioMasGastado(){
            $db = Conectar::conexion();
            $result = $db->query("SELECT u.username, SUM(op.total) AS total_gastado FROM order_product op JOIN user u ON u.id = op.id_user WHERE op.state = 1 GROUP BY u.id ORDER BY total_gastado DESC LIMIT 1;");
            if($row=$result->fetch_assoc()){
                return [$row['username'], $row['total_gastado']];
            }
        }
    }
?>