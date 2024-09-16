<?php 
require_once('../../inc/mysql-db-connexion.php');
require_once('tools.php');
require_once('../constant.php');

function mixStrings(string $string1,string $string2): string {

    $combined = $string1 . $string2;
    $array = str_split($combined);
    shuffle($array);
    return implode('', $array);
}

function generation_pseudo(string $firstname,string $lastname): string {

    return mixStrings($firstname,$lastname);
}

function generating_email(string $firstname,string $lastname): string{

    return $firstname.$lastname."@nomailObjectif3W.com";
}

function generating_password(): string{
    
    return password_hash(USERPWD,PASSWORD_BCRYPT);
}

function generating_address(): string{

    return mt_rand(1, 999)." "."rue"." ".mixStrings(ADDRESSFIRSTPART,ADDRESSLASTPART);
}

function generating_postal_code(): string{

    return mt_rand(0,9).mt_rand(0,9).mt_rand(0,9).mt_rand(0,9).mt_rand(0,9);
}

function generating_city(): string{

    return CITIES[mt_rand(0, count(CITIES)-1)];
}

function generating_firstname(): string{

    return USERSFIRSTNAME[mt_rand(0, count(USERSFIRSTNAME)-1)];
}

function generating_lastname(): string{

    return USERSLASTNAME[mt_rand(0, count(USERSLASTNAME)-1)];
}

function generating_random_date(DateTime $start, DateTime $end): string{

    $randomTimestamp = mt_rand($start->getTimestamp(), $end->getTimestamp());
    $randomDate = new DateTime();
    $randomDate->setTimestamp($randomTimestamp);
    return $randomDate->format('Y-m-d H:i:s');
}

function generating_eyes_color(): string{

    return EYES_COLOR[mt_rand(0, count(EYES_COLOR)-1)];
}

function generating_size(): string{

    return mt_rand(20,250).".".mt_rand(0,9).mt_rand(0,9);
}

function generating_weight(): string{

    return mt_rand(20,999).".".mt_rand(0,9).mt_rand(0,9);
}

function generating_animal_name(): string{

    return PET_NAMES[mt_rand(0, count(PET_NAMES)-1)];
}

function create_users(PDO $db,array $user): void{

    $sqlQuery ='INSERT INTO users (pseudo, email, pwd, address, postal_code, city, firstname, lastname, birthday, eyes_color, size, weight, animal_name, last_login, role_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

    $insert_user= $db->prepare($sqlQuery);
    try {
        $insert_user->execute([$user['pseudo'], $user['email'],$user['pwd'], $user['address'], $user['postal_code'],  $user['city'], $user['firstname'], $user['lastname'],  $user['birthday'], $user['eyes_color'], $user['size'], $user['weight'], $user['animal_name'],  $user['last_login'], MEMBER_ID]);
    }catch(Exception $e){
        die('Erreur : ' . $e->getMessage());
    }
}

function purging_doubles($db, $firstname, $lastname): void{
    try {
        $sqlQuery = "
        DELETE u1 
        FROM users u1
        JOIN users u2 ON u1.firstname = u2.firstname AND u1.lastname = u2.lastname AND u1.id > u2.id
        LEFT JOIN carts c ON c.user_id = u1.id
        WHERE u1.anonymized = 0 AND u2.anonymized = 0 AND c.id IS NULL
    ";

        $query = $db->prepare($sqlQuery);
        $query->execute();
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

function generating_fake_data($db){

    for ($i=0;$i <USERNBR;$i++){

        $user=[];
        $user['firstname'] = generating_firstname();
        $user['lastname'] = generating_lastname();
        $user['pseudo'] = generation_pseudo($user['firstname'],$user['lastname']);
        $user['email'] = generating_email($user['firstname'],$user['lastname']);
        $user['pwd'] = generating_password();
        $user['address'] = generating_address();
        $user['postal_code'] = generating_postal_code();
        $user['city'] = generating_city();
        $user['birthday'] = generating_random_date(new DateTime(START_DATE),new DateTime(END_DATE));
        $user['eyes_color'] = generating_eyes_color();
        $user['size'] = generating_size();
        $user['weight'] = generating_weight();
        $user['animal_name'] = generating_animal_name();
        $user['last_login'] = generating_random_date(new DateTime(START_DATE),new DateTime(END_DATE));
    
        create_users($db, $user);

        purging_doubles($db, $user['firstname'], $user['lastname']);
    }

    header('Location: ../../../views/user_list.php');
    exit;
}

if (isset($_SERVER['HTTP_REFERER']) && (stristr($_SERVER['HTTP_REFERER'],'user_list.php'))){

    generating_fake_data($db);

    header('Location: ../../../views/user_list.php');
    exit;

}



?>
