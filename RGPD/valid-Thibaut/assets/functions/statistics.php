<?php
if (stristr($_SERVER['PHP_SELF'],'view'))
{
    require_once('../assets/inc/mysql-db-connexion.php');
}else{
    require_once('../inc/mysql-db-connexion.php');
}
require_once('helpers/tools.php');

require_once('constant.php');


function getGlobalStats(PDO $db): array{

    try {
        $sqlQuery ='SELECT 
    (SELECT AVG(TIMESTAMPDIFF(YEAR, birthday, CURDATE())) FROM admininterface.users) AS average_age,
    (SELECT AVG(price) FROM admininterface.carts) AS average_cart_price,
    (SELECT COUNT(*) FROM admininterface.users WHERE anonymized = 1) AS anonymized_users,
    (SELECT COUNT(*) FROM admininterface.users) AS total_users,
    (SELECT AVG(size) FROM admininterface.users) AS average_size,
    (SELECT AVG(weight) FROM admininterface.users) AS average_weight,
    (SELECT SUM(price) FROM admininterface.carts) AS total_cart_price;';

        $result = $db->prepare($sqlQuery);
        $result->execute();

        return $result->fetch(PDO::FETCH_ASSOC);
    }catch(Exception $e){
        die('Erreur : ' . $e->getMessage());
    }
}

function getCityDistribution(PDO $db): array{

    try {
        $sqlQuery ='SELECT city, 
       (COUNT(*) * 100.0 / (SELECT COUNT(*) FROM admininterface.users)) AS percent_by_city
        FROM admininterface.users
        GROUP BY city;';

        $result = $db->prepare($sqlQuery);
        $result->execute();

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }catch(Exception $e){
        die('Erreur : ' . $e->getMessage());
    }
}

function getEyesColorDistribution(PDO $db): array{

    try {
        $sqlQuery ='SELECT eyes_color, 
       (COUNT(*) * 100.0 / (SELECT COUNT(*) FROM admininterface.users)) AS percent_by_eyes_color
        FROM admininterface.users
        GROUP BY eyes_color;';

        $result = $db->prepare($sqlQuery);
        $result->execute();

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }catch(Exception $e){
        die('Erreur : ' . $e->getMessage());
    }
}


    $stats = getGlobalStats($db);
    $stats['percent_by_city']=getCityDistribution($db);
    $stats['percent_by_eye_color']=getEyesColorDistribution($db);


?>