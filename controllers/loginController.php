<?php
require_once("models/UserModel.php");
require_once("models/UserRepository.php");

$info = " ";
$users = UserRepository::getUsers();

//registrarse
if(isset($_POST['regSubmit']) && isset($_POST['regUsername']) && isset($_POST['regPassword'])){
    if(UserRepository::setUser($_POST['regUsername'], $_POST["regPassword"], 0)){
        $info =  "Usuario registrado correctamente";
    }else{
        $info = "el usuario ya se ha registrado";
    }
    require_once("views/sessionView.phtml");
    die();
}

//inicio de sesion
if(isset($_POST['submit'])){
    if(isset($_POST['username']) && isset($_POST['password'])){
        $user = UserRepository::getUser($_POST['username'], $_POST['password']);
        if($user){
            $_SESSION['user'] = $user;
            require_once("controllers/productController.php");
            require_once("views/shopView.phtml");
            header("Location: index.php");
            die();
        }else{
            echo  "Usuario o contraseña incorrecto";
            require_once("views/sessionView.phtml");
            die();
        }
    }
}

if(isset($_GET['register'])){
    require_once("views/sessionView.phtml");
    die();
}




//nuevo usuario 
if(isset($_POST['newUsername']) && isset($_POST['newPassword'])){
    $admin = isset($_POST['isAdmin']) ? 1 : 0;
    if(UserRepository::setUser($_POST['newUsername'], $_POST["newPassword"], $admin)){
        $info =  "Usuario creado correctamente";
    }else{
        $info =  "el usuario ya esta creado";
    }
    require_once("views/addUserView.phtml");
    die();
}

//cambiar admin
if(isset($_GET['noAdmin'])){
    UserRepository::cambiarAdmin($_GET['noAdmin'], 0);
    $info =  "Cambio de admin a no admin realizado";
    require_once("views/addUserView.phtml");
    die();
}elseif(isset($_GET['siAdmin'])){
    UserRepository::cambiarAdmin($_GET['siAdmin'], 1);
    $info = "Cambio de no admin a admin realizado";
    require_once("views/addUserView.phtml");
    die();
}

//borrar usuario

if(isset($_GET['borrar'])){
    if(UserRepository::deleteUser($_GET['borrar'])){
        $info = "usuario borrado con exito";
        require_once("views/addUserView.phtml");
        die();
    }else{
        $info =  "no se pudo borrar el usuario";
        require_once("views/addUserView.phtml");
        die();
    }
}

if(isset($_GET['volver'])){
    header("Location: index.php");
    die();
}

?>