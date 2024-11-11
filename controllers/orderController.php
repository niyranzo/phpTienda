<?php
    require_once("models/orderRepository.php");
    $lineas = lineProduct::getLinesProducts($_SESSION['user']->getId());
    $orders = orderRepository::getOrders($_SESSION['user']->getId());
    $ordersStates = orderRepository::getOrderStates();

    if(isset($_GET['hacerPedido'])){
        require_once("views/paymentView.phtml");
        die(); 
    }

    if(isset($_GET['pagado'])){
        if(orderRepository::changeState($_GET['pagado'], 1)){
            echo "Pedido pagado";
            require_once("views/stateView.phtml");
            die();
        }
    }

    if(isset($_GET['enviar'])){
        if(orderRepository::changeState($_GET['enviar'], 2)){
            echo "Pedido enviado";
            require_once("views/stateView.phtml");
            die();
        }
    }
    

    if(isset($_GET['volver'])){
        header("Location: index.php");
        die();
    }
?>