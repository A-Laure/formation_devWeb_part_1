<?php 

session_start();

function cleaning_session(): void{

    unset($_SESSION['info']);

    header('Location: '.$_SERVER['HTTP_REFERER']);
    exit;
}


cleaning_session();