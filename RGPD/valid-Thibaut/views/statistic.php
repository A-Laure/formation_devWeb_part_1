<?php
$current_page='statistics';
$title='Statistiques';
require_once ('../assets/inc/head.php');
require_once ('../assets/inc/navbar.php');
require_once ('../assets/functions/constant.php');
require_once ('../assets/functions/statistics.php');

?>

<div class="container my-5">
        <h1 class="mb-4 text-center">Statistiques</h1>
        <div class="stats-container">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Âge moyen</h5>
                    <p class="card-text"><?= round($stats['average_age'], 2) ?> ans</p>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Panier Moyen</h5>
                    <p class="card-text"><?= round($stats['average_cart_price'], 2)." ".CURRENCY ?></p>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Répartition des utilisateurs par ville</h5>
                    <?php foreach ($stats['percent_by_city'] as $city) : ?>
                        <div class="mb-2">
                            <strong><?= htmlspecialchars($city['city']) ?>:</strong>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: <?= round($city['percent_by_city'], 2) ?>%;" aria-valuenow="<?= round($city['percent_by_city'], 2) ?>" aria-valuemin="0" aria-valuemax="100"><?= round($city['percent_by_city'], 2) ?>%</div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Répartition couleur des yeux</h5>
                    <?php foreach ($stats['percent_by_eye_color'] as $color) : ?>
                        <div class="mb-2">
                            <strong><?= ucfirst(htmlspecialchars($color['eyes_color'])) ?>:</strong>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: <?= round($color['percent_by_eyes_color'], 2) ?>%;" aria-valuenow="<?= round($color['percent_by_eyes_color'], 2) ?>" aria-valuemin="0" aria-valuemax="100"><?= round($color['percent_by_eyes_color'], 2) ?>%</div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total paniers</h5>
                    <p class="card-text"><?= round($stats['total_cart_price'], 2)." ".CURRENCY  ?></p>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Nombre d'utilisateurs Anonymisés/Actifs</h5>
                    <p class="card-text"><?= $stats['anonymized_users']." / ".$stats['total_users'] ?></p>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Taille moyenne des utilisateurs</h5>
                    <p class="card-text"><?= round($stats['average_size'], 2) ?> cm</p>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Poids moyen des utilisateurs</h5>
                    <p class="card-text"><?= round($stats['average_weight'], 2) ?> kg</p>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/inc/style/JavaScript/charts.js"></script>

<?php require_once ('../assets/inc/foot.php');?>