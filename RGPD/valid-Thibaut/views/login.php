<?php
$title='Login';
require_once ('../assets/inc/head.php');
session_start();
?>

<section class="d-flex justify-content-center my-5 flex-column">

    <a class="alert alert-danger m-auto mt-3 text-decoration-none text-danger position-relative mx-auto <?= ((isset($_SESSION['info']['error_login'])) && $_SESSION['info']['error_login']!=NULL) ? '' : 'd-none' ?>" href="../assets/functions/cleaningSession.php" role="alert">
        <div class="me-2"><?=(isset($_SESSION['info']['error_login']) ? $_SESSION['info']['error_login'] : "") ?> 
            <i class="bi bi-x-circle position-absolute top-0 ms-1"></i>
        </div>
    </a>

    <a class="alert alert-danger m-auto mt-3 text-decoration-none text-danger position-relative mx-auto <?= ((isset($_SESSION['info']['not_found'])) && $_SESSION['info']['not_found']!=NULL) ? '' : 'd-none' ?>" href="../assets/functions/cleaningSession.php" role="alert">
        <div class="me-2"><?=(isset($_SESSION['info']['not_found']) ? $_SESSION['info']['not_found'] : "") ?>
            <i class="bi bi-x-circle position-absolute top-0 ms-1"></i>
        </div>
    </a>

    <div class="card mx-auto" style="width: 18rem;">

        <div class="card-body d-flex flex-column justify-content-center">

            <h5 class="card-title mx-auto">Login</h5>
            
            <form class="d-flex flex-column" action="../assets/functions/login.php" method="post">
            
                <label class="mx-auto" for="login-pseudo">Pseudo</label>

                <input class="w-75 mx-auto text-center" type="text" name="login_pseudo" min="1" maxlength="20" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Uniquement des lettres et des chiffres"> 

                <label class="mx-auto mt-2"  for="login-password">Mot de passe</label>

                <input class="w-75 mx-auto text-center" type="password" name="login_password" min="1" maxlength="20" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Uniquement des lettres et des chiffres">

                <button type="submit" class="btn btn-primary mx-auto mt-3">Login</button>

            </form>
            
            <div class ="d-flex justify-content-center">
                <a href="user_create.php" class="font-italic">Pas encore de compte? C'est ici</a>
            </div>
        </div>
    </div>
</section>

<?php require_once ('../assets/inc/foot.php');?>