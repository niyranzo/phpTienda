<?php
    class productRepository{

        public static function getProducts(){
            $db=Conectar::conexion();
            $products= array();
            $result= $db->query("SELECT * FROM product");
            while($row=$result->fetch_assoc()){
                $products[] = new productModel($row);
            }
            return $products;
        }

        public static function getProduct($idProduct){
            $db=Conectar::conexion();
            $result = $db->query("SELECT * FROM product WHERE id = '".$idProduct."'");
            if($row=$result->fetch_assoc()){
                return new productModel($row);
            }else{
                return false;
            }
            //return $db->insert_id;
        }

        public static function deleteProduct($idProduct){
            $db= Conectar::conexion();
            $result = $db->query("DELETE FROM product WHERE id = '".$idProduct."'");
            return $result ? true : false;
        }

        public static function setProduct($name, $stock, $img, $price, $description, $id_user) {
            $db = Conectar::conexion();
            $result = $db->query("SELECT * FROM product WHERE name = '" . $name . "'");
            if ($result->fetch_assoc()) {
                return false;
            } else {
                $db->query("INSERT INTO product (id, name, stock, img, price, description, id_user) 
                            VALUES (NULL, '" . $name . "', " . $stock . ", '" . $img . "', " . $price . ", '" . $description . "', " . $id_user . ")");
                return true;
            }
        }
        
        
    }
?>