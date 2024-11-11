<?php
    class UserRepository{
        public static function getUser($user, $password){
            $db=Conectar::conexion();
            $result= $db->query("SELECT * FROM user WHERE username = '".$user."' && password = '".$password."'");
            if ($row = $result->fetch_assoc()){
                return new UserModel($row);
            }else return false;
        }

        public static function getUsers(){
            $db=Conectar::conexion();
            $result= $db->query("SELECT * FROM user ");
            $users = array();
            while ($row = $result->fetch_assoc()){
                $users[] = new UserModel($row);
            }
            return $users;
        }

        public static function deleteUser($idUser){
            $db=Conectar::conexion();
            $result = $db->query("DELETE FROM user WHERE id = '". $idUser ."'");
            return $result ? true : false; 
        }

        public static function cambiarAdmin($idUser, $value){
            $db=Conectar::conexion();
            $admin = $value == 1 ? 1 : 0;
            $db->query("UPDATE user SET isAdmin = '".$admin."' WHERE id='".$idUser."'");
        }
        public static function setUser($user, $password, $isAdmin){
            $db= Conectar::conexion();
            $result= $db->query("SELECT * FROM user WHERE username = '".$user."'");
            if ($result->fetch_assoc()){
                return false;
            }else{
                $db->query("INSERT INTO user (username, password, isAdmin) VALUES ('".$user."', '".$password."', ".$isAdmin.")");
                return true;
            }
        }
    }
