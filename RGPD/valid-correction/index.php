<?php
session_start();
$current_page = 'dashboard';
$title = 'Dashboard';
require_once('assets/inc/head.php');
require_once('assets/inc/navbar.php');
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <h1 class="display-4">Dashboard</h1>
            <div class="ms-2">
                Connecté en tant que : 
                <span class= fw-bold>
                    <?= ucfirst(htmlspecialchars($_SESSION['user']['pseudo'])) ?>
                </span>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <h3>Exercice</h3>
            <p class="text-muted mt-5 fw-bold">Vos tâches :</p>
            <ul class="list-group">
                <li class="list-group-item">Contrôler le contenu du formulaire de création d'un utilisateur</li>
                <li class="list-group-item">Bloquer l'accès et la visibilité d'un panier et d'un profil utilisateur à tous sauf au super admin.</li>
                <li class="list-group-item">Créer une fonction pour anonymiser les données personnelles des utilisateurs.</li>
                <li class="list-group-item">Choisir soi-même la méthode à appliquer en fonction des données (intérêt à garder des données? statistiques? factures?).</li>
                <li class="list-group-item">Maintiens de la cohérence des statistiques même si des utilisateurs sont anonymisés.</li>
                <li class="list-group-item">Créer un bouton pour anonymiser juste un profil uniquement accessible au super admin.</li>
                <li class="list-group-item">Créer un bouton pour anonymiser tout le monde en une fois ou juste un profil, uniquement accessible au super admin.</li>
                <li class="list-group-item">Créer un bouton permettant d'afficher une facture désanonymisée.</li>
                <li class="list-group-item">Garder la trace de qui a anonymisé qui.</li>
            </ul>

            <p class="text-muted mt-5 fw-bold">Bonus :</p>
            <ul class="list-group mb-5">
                <li class="list-group-item">Faire fonctionner le diagramme JS commenté dans la page statistiques</li>
                <li class="list-group-item">Améliorer les paniers en rajoutant des produits liés au panier.</li>
                <li class="list-group-item">Le panier pouvant avoir un ou plusieurs produits.</li>
                <li class="list-group-item">Inclure cela dans la génération de paniers</li>
            </ul>
        </div>
    </div>
</div>

<?php require_once('assets/inc/foot.php'); ?>
