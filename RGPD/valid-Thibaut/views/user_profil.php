<?php
$current_page='user_profil';
$title='Profil utilisateur';
require_once ('../assets/inc/head.php');
require_once ('../assets/inc/navbar.php');
require_once ('../assets/functions/users.php');
?>

<section class="d-flex flex-column justify-content-center my-5">

    <a class="alert alert-secondary m-auto mt-3 text-decoration-none position-relative <?= ((isset($_SESSION['info']['not_found'])) && $_SESSION['info']['not_found']!=NULL) ? '' : 'd-none' ?>" href="../assets/functions/cleaningSession.php" role="alert">
        <div class="me-2"><?=(isset($_SESSION['info']['not_found']) ? $_SESSION['info']['not_found'] : "") ?>
            <i class="bi bi-x-circle position-absolute top-0 ms-1"></i>
        </div>
    </a>

    <h2 class="text-center mb-4"> Profil de <?=ucfirst($user['pseudo'])?></h2>

    <div class="card mx-auto" style="width: 35rem;">

        <div class="card-body d-flex flex-column justify-content-center">

            <a class="alert alert-secondary m-auto mt-3 text-decoration-none position-relative <?= ((isset($_SESSION['info']['anonymized'])) && $_SESSION['info']['anonymized']!=NULL) ? '' : 'd-none' ?>" href="../assets/functions/cleaningSession.php" role="alert">
                <div class="me-2"><?=(isset($_SESSION['info']['anonymized']) ? $_SESSION['info']['anonymized'] : "") ?>
                <i class="bi bi-x-circle position-absolute top-0 ms-1"></i></div>
            </a>
        
            <h5 class="card-title mx-auto">Informations</h5>

            <div class="card-body">
                <p class="card-text">Nom : <strong><?= ucfirst($user['firstname'])?></strong><p>
                <p class="card-text">Prénom : <strong><?= ucfirst($user['lastname'])?></strong></p>
                <p class="card-text">Adresse : 
                    <strong><?= ucfirst($user['address'])?></strong> 
                    <strong><?= ucfirst($user['postal_code'])?></strong> 
                    <strong><?= ucfirst($user['city'])?></strong>
                </p>
                <p class="card-text">Date de naissance : <strong><?= ucfirst($user['birthday'])?></strong><p>
                <p class="card-text">Couleur des yeux : <strong><?= ucfirst($user['eyes_color'])?></strong></p>
                <p class="card-text">Taille : <strong><?= ucfirst($user['size'])?></strong><p>
                <p class="card-text">Poids : <strong><?= ucfirst($user['weight'])?></strong></p>
                <p class="card-text">Nom animal de compagnie : <strong><?= ucfirst($user['animal_name'])?></strong></p>
            </div>
        </div>

        <div class="card-body d-flex flex-column justify-content-center">

            <a class="alert m-auto mt-3 text-decoration-none position-relative <?= ((isset($_SESSION['info']['cartAdd'])) && $_SESSION['info']['cartAdd']!=NULL) ? '' : 'd-none' ?>" href="../assets/functions/cleaningSession.php" role="alert">
                <div class="me-2"><?=(isset($_SESSION['info']['cartAdd']) ? $_SESSION['info']['cartAdd'] : "") ?>
                <i class="bi bi-x-circle position-absolute top-0 ms-1"></i></div>
            </a>

            <form class="d-flex justify-content-center mb-3" action="../assets/functions/users.php" method="POST">
                <input type="hidden" name="addCart" value="1">
                <input type="hidden" name="user_id" value=<?=$user['user_id']?>>
                <button type="submit" class="btn btn-primary mx-auto mt-3">Ajouter un panier</button>
            </form>

            <h5 class="card-title mx-auto">Paniers</h5>
            <div class="card-body">
                <?php if ((isset($user['carts'])) && (!empty($user['carts']))) :?>
                    <table class="table table-striped container-fluid mt-5" style="width: 35rem;">
                        <thead>
                        <tr>
                            <th scope="col">Numéro</th>
                            <th scope="col">Prix</th>
                            <th scope="col">Payé</th>
                            <th class="text-center" scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($user['carts'] as $cart) :?>
                            <tr>
                            <div>
                                <th><?=$cart['cart_id']?></th>
                                <th><?=$cart['price']?></th>
                                <th><?= ($cart['paid'] == 1) ? "Oui" : "Non"?></th>
                                <td class="d-flex justify-content-around mw-25">
                                <a class="btn btn-primary" href="cart.php?id=<?=$cart['cart_id']?>"><i class="bi bi-eye-fill"></i></a>
                                </td>
                            </div>
                            </tr>
                        <?php endforeach ;?>
                        </tbody>
                    </table>
                <?php else :?>
                    <div class="text-center fw-bold">Aucun panier</div>
                <?php endif ?>
            </div>
        </div>
        
    </div>
</section>

<?php require_once ('../assets/inc/foot.php');?>