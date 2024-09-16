<?php 

try {
    $db = new PDO ("mysql:host=localhost;dbname=admininterface;charset=UTF8","root","root");
}
    
catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

?>