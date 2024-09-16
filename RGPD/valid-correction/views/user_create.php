<?php
session_start();
$title='Profil utilisateur';
require_once ('../assets/inc/head.php');
require_once ('../assets/functions/constant.php');
?>

<div>
    <a class="btn btn-primary mx-auto mt-3 ms-3" href="login.php">
      Se logger
    </a>
</div>

<section class="d-flex justify-content-center my-5 flex-column">
    <div class="card mx-auto" style="width: 22rem;">
        <div class="card-body d-flex flex-column justify-content-center">

            <a class="alert alert-secondary m-auto mt-3 text-decoration-none text-danger position-relative <?= ((isset($_SESSION['info']['error_creating_user'])) && $_SESSION['info']['error_creating_user']!=NULL) ? '' : 'd-none' ?>" href="../assets/functions/cleaningSession.php" role="alert">
                <div class="me-2"><?=(isset($_SESSION['info']['error_creating_user']) ? $_SESSION['info']['error_creating_user'] : "") ?>
                <i class="bi bi-x-circle position-absolute top-0 ms-1"></i></div>
            </a>
            
            <a class="alert alert-success m-auto mt-3 text-decoration-none text-success position-relative <?= ((isset($_SESSION['info']['success_creating_user'])) && $_SESSION['info']['success_creating_user']!=NULL) ? '' : 'd-none' ?>" href="../assets/functions/cleaningSession.php" role="alert">
                <div class="me-2"><?=(isset($_SESSION['info']['success_creating_user']) ? $_SESSION['info']['success_creating_user'] : "") ?> 
                <i class="bi bi-x-circle position-absolute top-0 ms-1"></i></div>
            </a>

            <h5 class="card-title mx-auto">Création utilisateur</h5>
            
            <form class="d-flex flex-column" action="../assets/functions/users.php" method="post">
            
                <label class="mx-auto" for="login-pseudo">Pseudo</label>
                <input class="w-75 mx-auto text-center" type="text" name="login_pseudo" min=<?=MIN_LENGTH_PSEUDO?> maxlength=<?=MAX_LENGTH_PSEUDO?> data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Uniquement des lettres et des chiffres"> 

                <label class="mx-auto mt-2"  for="login-password">Mot de passe</label>
                <input class="w-75 mx-auto text-center" type="password" name="plain_password" min=<?=MIN_LENGTH_PASSWORD?> maxlength=<?=MAX_LENGTH_PASSWORD?> data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Uniquement des lettres et des chiffres">
                
                <label class="mx-auto mt-2"  for="user_email">email</label>
                <input class="w-75 mx-auto text-center" type="email" name="user_email">
        
                <label class="mx-auto mt-2"  for="user_address">adresse</label>
                <input class="w-75 mx-auto text-center" type="text" name="user_address">
                
                <label class="mx-auto mt-2"  for="user_postal_code">Code Postal</label>
                <input class="w-75 mx-auto text-center" type="number" name="user_postal_code" minlenght=<?=LENGTH_POSTAL_CODE?> maxlength=<?=LENGTH_POSTAL_CODE?> data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Uniquement 5 chiffres">
                
                <label class="mx-auto mt-2"  for="user_city">Ville</label>
                <input class="w-75 mx-auto text-center" type="text" name="user_city">
                
                <label class="mx-auto mt-2"  for="user_firstname">Prénom</label>
                <input class="w-75 mx-auto text-center" type="text" name="user_firstname">

                <label class="mx-auto mt-2"  for="user_lastname">Nom</label>
                <input class="w-75 mx-auto text-center" type="text" name="user_lastname">

                <label class="mx-auto mt-2"  for="user_birthdate">Date de Naissance</label>
                <input class="w-75 mx-auto text-center" type="date" name="user_birthdate">

                <label class="mx-auto mt-2"  for="user_eyes_color">Couleur des yeux</label>
                <select name="user_eyes_color" id="user_eyes_color">
                    <option value="">Choisissez une couleur</option>
                    <?php foreach(EYES_COLOR as $color) :?>
                        <option value=<?=$color?>><?=ucfirst($color)?></option>
                    <?php endforeach;?>
                </select>

                <label class="mx-auto mt-2"  for="user_size">Taille (en cm)</label>
                <input class="w-75 mx-auto text-center" type="number" name="user_size" min=<?=MIN_SIZE?> max=<?=MAX_SIZE?>>

                <label class="mx-auto mt-2"  for="user_weight">Poids (en kg)</label>
                <input class="w-75 mx-auto text-center" type="number" name="user_weight" step="0.1" min=<?=MIN_WEIGTH?> max=<?=MAX_WEIGTH?>>

                <label class="mx-auto mt-2"  for="user_animal_name">Nom de votre animal de compagnie</label>
                <input class="w-75 mx-auto text-center" type="text" name="user_animal_name">

                <button type="submit" class="btn btn-primary mx-auto mt-3">Enregistrer</button>

            </form>

        </div>
    </div>
</section>

<?php require_once ('../assets/inc/foot.php');?>