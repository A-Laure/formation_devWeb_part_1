<nav class="navbar navbar-expand-sm bg-dark border-bottom border-bottom-dark" data-bs-theme="dark">
  <div class="container-fluid me-5 ms-5">
    <a class="navbar-brand" href="http://localhost/valid-obj3W/valid/index.php">
      <i class="bi bi-house-door-fill"></i>
    </a>
        
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
      <ul class="navbar-nav mb-2 mb-sm-0 align-items-end">
        <li class="nav-item">
          <a class="nav-link <?= $current_page === 'user_list' ? 'active' : '' ?>" href="http://localhost/valid-obj3W/valid/views/user_list.php">Liste des membres</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $current_page === 'cart_list' ? 'active' : '' ?>" href="http://localhost/valid-obj3W/valid/views/cart_list.php">Liste des paniers</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= $current_page === 'statistics' ? 'active' : '' ?>" href="http://localhost/valid-obj3W/valid/views/statistic.php">Statistiques</a>
        </li>
        <li class="nav-item">
          <a class="nav-link bg-danger" href="http://localhost/valid-obj3W/valid/assets/functions/logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<main>