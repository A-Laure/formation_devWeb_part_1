<?php

if (stristr($_SERVER['PHP_SELF'],'view'))
{
    require_once('../assets/inc/mysql-db-connexion.php');
}else{
    require_once('../inc/mysql-db-connexion.php');
}
require_once('helpers/tools.php');


function getAllCarts(PDO $db): array{

    try {
        $sqlQuery ='SELECT carts.id as cart_id, carts.price, carts.paid, CONCAT(users.firstname, " ", users.lastname) as user_name FROM carts LEFT JOIN users ON carts.user_id = users.id';

        $result= $db->prepare($sqlQuery);
        $result->execute();

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }catch(Exception $e){
        die('Erreur : ' . $e->getMessage());
    } 
}

function getOneCart(PDO $db,int $cartId): array{

    try {
        $sqlQuery ='SELECT carts.id as cart_id, carts.price, carts.paid, carts.user_id, users.firstname, users.lastname, users.address, users.postal_code, users.city, users.anonymized as user_anonymized FROM carts LEFT JOIN users ON carts.user_id = users.id where carts.id = ?';

        $result= $db->prepare($sqlQuery);
        $result->execute([$cartId]);

        return $result->fetch(PDO::FETCH_ASSOC);
    }catch(Exception $e){
        die('Erreur : ' . $e->getMessage());
    }
}

function getUserCart(PDO $db,int $userId): array|bool{

    try {
        $sqlQuery ='SELECT carts.id as cart_id, carts.price, carts.paid, carts.user_id, users.firstname, users.lastname, users.address, users.postal_code, users.city, users.anonymized as user_anonymized FROM carts LEFT JOIN users ON carts.user_id = users.id where users.id = ?';

        $result= $db->prepare($sqlQuery);
        $result->execute([$userId]);

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }catch(Exception $e){
        die('Erreur : ' . $e->getMessage());
    }
}

function createRandomPrice(): string{

    return rand(0,9999).'.'.rand(0,99);
}

function addNewCart(PDO $db,int $userId): bool{
    
    $price = createRandomPrice();
    $paid = rand(0,1);

    try {
        $sqlQuery ='INSERT INTO carts (price, paid, creation_date, user_id) VALUES (?, ?, ?, ?)';

        $insert_cart= $db->prepare($sqlQuery);
        $insert_cart->execute([$price, $paid, date("Y-m-d H:i:s"), $userId]);
    }catch(Exception $e){
        die('Erreur : ' . $e->getMessage());
    }

    return true;
}

function getOneCartUnanonymized(PDO $db,int $cartId): array{

    try {
        $sqlQuery ='SELECT carts.id as cart_id, carts.price, carts.paid, carts.user_id, user_archive.firstname, user_archive.lastname, user_archive.address, user_archive.postal_code, user_archive.city FROM carts LEFT JOIN user_archive ON carts.user_id = user_archive.user_id where carts.id = ?';

        $result= $db->prepare($sqlQuery);
        $result->execute([$cartId]);

        return $result->fetch(PDO::FETCH_ASSOC);
    }catch(Exception $e){
        die('Erreur : ' . $e->getMessage());
    }

}

if ((isset($_SERVER['PHP_SELF'])) && (stristr($_SERVER['PHP_SELF'],'cart_list.php'))){
    
    $carts = getAllCarts($db);
    queryResultNull($carts);

    return $carts;

}

if ((isset($_SERVER['PHP_SELF'])) && (stristr($_SERVER['PHP_SELF'],'cart.php')) && (verify_isset_non_empty($_GET['id']))){

    $cartId = $_GET['id'];
    
    $cart = getOneCart($db, $cartId);
    queryResultNull($cart);

    return $cart;

}

?>