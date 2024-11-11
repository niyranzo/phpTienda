<?php
require_once("models/productModel.php");
require_once("models/productRepository.php");
require_once("models/UserModel.php");
require_once("models/UserRepository.php");
require_once("models/orderModel.php");
require_once("models/lineProductModel.php");
require_once("models/orderRepository.php");
require_once("models/lineProductRepository.php");

require_once("helpers/fileHelper.php");

$info = " ";
//productos
$products = productRepository::getProducts();
//cerrar sesion
if(isset($_GET['logout'])){
    session_destroy();
    header("Location: index.php");
}
//iniciar sesion
if(isset($_GET["login"])){
    require_once("controllers/loginController.php");
    require_once("views/sessionView.phtml");
    die();
}

if(isset($_GET['addUser'])){
    require_once("controllers/loginController.php");
    require_once("views/addUserView.phtml");
    die();
}
//añadir nuevo producto
if(isset($_GET['add'])){
    require_once("views/addProduct.phtml");
    die();
}

if(isset($_POST['nameProduct']) && isset($_POST['stock']) && isset($_POST['price']) && isset($_POST['description'])){
    $img = isset($_FILES['image']['name']) && $_FILES['image']['name'] != "" ? $_FILES['image']['name'] : "defecto.png";
    if ($img != "defecto.png") {
        fileHelper::fileHandler($_FILES['image']['tmp_name'], 'public/img/' . $img);
    }
    if(productRepository::setProduct($_POST['nameProduct'],$_POST['stock'],$img,$_POST['price'],$_POST['description'],$_SESSION["user"]->getId())){
        $info = "Producto creado correctamente";
        header("Location: index.php");
    }else{
        $info =  "no se pudo crear el producto";
    }
}

//borrar producto
if(isset($_GET['borrar'])){
    $info =  productRepository::deleteProduct($_GET['borrar'])  ? "Producto borrado" : "No se pudo borrar el producto" ; 
}
//añadir producto al carrito
if(isset($_POST['añadir'])){
    if(lineProduct::setLineProduct(orderRepository::getOrder($_SESSION['user']->getId()), $_GET['idProducto'], 
    $_POST['amount'], $_GET['precioProd'], NULL)){
        $info =  "<br><br>El producto ya estaba añadido, se actualizo la cantidad de la misma";
    }else{
        $info =  "<br><br>Se añadio el producto al carrito";
    }
}

//carrito
if(isset($_GET['idUserCarr'])){
    require_once("controllers/orderController.php");
    require_once("views/carritoView.phtml");
    die();
}

//ver estado de todos los pedidos

if(isset($_GET['state'])){
    require_once("controllers/orderController.php");
    require_once("views/stateView.phtml");
    die();
}

//ver los pedidos enviados

if(isset($_GET['idUserOrder'])){
    require_once("controllers/orderController.php");
    require_once("views/ordersView.phtml");
    die();
}

if(isset($_GET['volver'])){
    header("Location: index.php");
    die();
}

?>