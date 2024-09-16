<?php
$current_page='cart_list';
$title='Liste paniers';
require_once ('../assets/inc/head.php');
require_once ('../assets/inc/navbar.php');
require_once ('../assets/functions/carts.php');


?>
<section class="d-flex flex-column justify-content-center my-5">
  <a class="alert alert-secondary m-auto mt-3 text-decoration-none text-danger position-relative <?= ((isset($_SESSION['info']['not_found'])) && $_SESSION['info']['not_found']!=NULL) ? '' : 'd-none' ?>" href="../assets/functions/cleaningSession.php" role="alert">
    <div class="me-2"><?=(isset($_SESSION['info']['not_found']) ? $_SESSION['info']['not_found'] : "") ?>
      <i class="bi bi-x-circle position-absolute top-0 ms-1"></i>
    </div>
  </a>

  <?php if (isset($carts) && (is_array($carts))) :?>
    <table class="table table-striped container-fluid mt-5" style="width: 35rem;">
      <thead>
        <tr>
          <th scope="colt text-center">Numéro</th>
          <th scope="col text-center">utilisateur</th>
          <th scope="col text-center">Prix</th>
          <th scope="col text-center">Payé</th>
          <th class="text-center" scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($carts as $cart) :?>
          <tr>
            <div>
              <th><?=$cart['cart_id']?></th>
              <th><?=$cart['user_name']?></th>
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

</section>
<?php require_once('../assets/inc/foot.php');?>