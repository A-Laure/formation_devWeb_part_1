<?php
$current_page='invoice';
$title='Facture';
require_once ('../assets/inc/head.php');
require_once ('../assets/inc/navbar.php');
require_once ('../assets/functions/invoices.php');
?>

<section class="d-flex flex-column justify-content-center my-5">

    <h2 class="text-center mb-4"> Panier n°<?=$cart['cart_id']?></h2>

    <div class="card mx-auto" style="width: 35rem;">

        <div class="card-body d-flex flex-column justify-content-center">
        
            <h5 class="card-title mx-auto">Informations</h5>

            <div class="card-body">
                <p class="card-text">Nom : <strong><?= ucfirst($cart['firstname'])?></strong><p>
                <p class="card-text">Prénom : <strong><?= ucfirst($cart['lastname'])?></strong></p>
                <p class="card-text">Adresse :
                    <strong><?= ucfirst($cart['address'])?></strong> 
                    <strong><?= ucfirst($cart['postal_code'])?></strong> 
                    <strong><?= ucfirst($cart['city'])?></strong>
                </p>
            </div>
        </div>

        <div class="card-body d-flex flex-column justify-content-center">

            <h5 class="card-title mx-auto">Paniers</h5>
            <div class="card-body">
                <table class="table table-striped container-fluid mt-5" style="width: 35rem;">
                    <thead>
                    <tr>
                        <th scope="col">Numéro</th>
                        <th scope="col">Prix</th>
                        <th scope="col">Payé</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <div>
                            <th><?=$cart['cart_id']?></th>
                            <th><?=$cart['price']?></th>
                            <th><?= ($cart['paid'] == 1) ? "Oui" : "Non"?></th>
                            <td class="d-flex justify-content-around mw-25">
                            </td>
                        </div>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>




<?php require_once ('../assets/inc/foot.php');?>