<?php

require_once('helpers/tools.php');
require_once('../assets/inc/mysql-db-connexion.php');
require_once('carts.php');

function returningCartData(PDO $db,int $cartId): array{

    $cart = getOneCart($db, $cartId);

    if ($cart['user_anonymized'] == 1){

       $cart = getOneCartUnanonymized($db, $cartId);
    }
    return $cart;
}

if ((isset($_SERVER['PHP_SELF'])) && (stristr($_SERVER['PHP_SELF'],'invoice.php'))){

    if (verify_isset_non_empty($_GET['id'])){

        $cartId = $_GET['id'];

        $cart = returningCartData($db, $cartId);

        return $cart;
    }
}
?>