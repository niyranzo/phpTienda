<?php
require_once("models/UserModel.php");
require_once("models/UserRepository.php");
session_start();

require_once("controllers/productController.php");


  

    if(isset($_GET['c'])){
        require_once("controllers/".$_GET['c']."Controller.php");
    }

  
    require_once("views/shopView.phtml");

?>

 