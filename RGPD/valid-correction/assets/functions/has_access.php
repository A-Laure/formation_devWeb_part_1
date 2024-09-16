<?php
session_start();
require_once('helpers/tools.php');
require_once('constant.php');

function isLogged(): bool{
    if (isset($_SESSION['user']) && (verify_isset_non_empty($_SESSION['user'])))
    {
        return true;
    }else{
        return false;
    }
}

function hasAdminAccess(): bool{
    
    if (isLogged() && $_SESSION['user']['power'] >= ADMIN_POWER){
       return true;
    }else{
        header('Location: ../index.php');
        exit;
    }
}

if (stristr($_SERVER['HTTP_REFERER'],'user_create.php'))
{

}else{
    if (isLogged()){}else{header('Location: login.php'); exit;}
}

?>