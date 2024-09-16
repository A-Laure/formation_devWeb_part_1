<?php
    session_start();
    require_once('helpers/tools.php');
    require_once('users.php');
    if (stristr($_SERVER['PHP_SELF'],'view'))
    {
        require_once('../assets/inc/mysql-db-connexion.php');
    }else{
        require_once('../inc/mysql-db-connexion.php');
    }

    if ((isset($_SERVER['HTTP_REFERER'])) && (stristr($_SERVER['HTTP_REFERER'],'login.php')) && (verify_isset_non_empty($_POST['login_pseudo'])) && (verify_isset_non_empty($_POST['login_password']))) {

        unset($_SESSION['info']['error_login']);

        $user_checking = getUserMinimumInfo($db, $_POST['login_pseudo']);

        if (!is_array($user_checking)){
            $_SESSION['info']['error_login']="Identifiant et/ou mot de passe incorrects";

            header('Location: ../../views/login.php');
            exit;
        }

        $user_pwd=$user_checking["pwd"];

        if (password_verify($_POST['login_password'],$user_pwd)) {

        // if($user_pwd == $_POST['login_password']){
        
            unset($_SESSION['info']['error_login']);

            $user_info = getUserInfoForSession($db, $user_checking['user_id']);

            $_SESSION['user']['id']=$user_info['user_id'];
            $_SESSION['user']['pseudo']=$user_info['pseudo'];
            $_SESSION['user']['power']=$user_info['power'];
            $_SESSION['user']['role']=$user_info['role_name'];
            $_SESSION['user']['id']=$user_info['user_id'];

            updateLastLoginUser($user_info['user_id'],$db);

            header('Location: ../../index.php');
            exit;
        }else {

            $_SESSION['info']['error_login']="Identifiant et/ou mot de passe incorrects";

            header('Location: ../../views/login.php');
            exit;
        }
    }else{
        $_SESSION['info']['error_login']="Identifiant et/ou mot de passe incorrects";

        header('Location: ../../views/login.php');
        exit;
    }



?>