<?php
    require_once("views/paymentView.phtml");
    require_once("models/orderRepository.php");
    $info = " ";

    if(isset($_POST['submitTarj'])){
        if(orderRepository::makeOrder($_SESSION['user']->getId(), 2)){
            $info = "Pagado con tarjeta";
        }

    }elseif(isset($_POST['submitTrans'])){
        if(orderRepository::makeOrder($_SESSION['user']->getId(), 1)){
            $info = "Pagado con transferencia";
        }
    }
    
    if(isset($_GET['volver'])){
        header("Location: index.php");
        die();
    }

    die();

?>