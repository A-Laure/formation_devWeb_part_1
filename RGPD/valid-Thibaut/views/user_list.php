<?php
$current_page='user_list';
$title='Liste utilisateurs';
require_once ('../assets/inc/head.php');
require_once ('../assets/inc/navbar.php');
require_once ('../assets/functions/users.php');

?>
<section class="d-flex flex-column justify-content-center my-5">
  <a class="alert alert-secondary m-auto mt-3 text-decoration-none text-danger position-relative <?= ((isset($_SESSION['info']['not_found'])) && $_SESSION['info']['not_found']!=NULL) ? '' : 'd-none' ?>" href="../assets/functions/cleaningSession.php" role="alert">
    <div class="me-2"><?=(isset($_SESSION['info']['not_found']) ? $_SESSION['info']['not_found'] : "") ?>
      <i class="bi bi-x-circle position-absolute top-0 ms-1"></i>
    </div>
  </a>

  <div class="d-flex justify-content-around mb-3 mx-2">
    <a class="btn btn-primary mx-auto mt-3" href="../assets/functions/helpers/generate_data.php">Générer des utilisateurs</a>
  </div>

  <?php if (is_array($users)) :?>
    <table class="table table-striped container-fluid mt-5" style="width: 35rem;">
      <thead>
        <tr>
          <th scope="col">Pseudo</th>
          <th class="text-center" scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $user) :?>
          <tr>
            <div>
              <th><?=$user['pseudo']?></th>
              <td class="d-flex justify-content-around mw-25">
                  <a class="btn btn-primary" href="user_profil.php?id=<?=$user['user_id']?>"><i class="bi bi-eye-fill"></i></a>
              </td>
            </div>
          </tr>
        <?php endforeach ;?>
      </tbody>
    </table>
  <?php else :?>
    <div class="text-center fw-bold">Aucun utilisateur</div>
  <?php endif ?>
</section>

<?php require_once ('../assets/inc/foot.php');?>