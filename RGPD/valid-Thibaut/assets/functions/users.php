<?php
if (stristr($_SERVER['PHP_SELF'],'view'))
{
    require_once('../assets/inc/mysql-db-connexion.php');
}else{
    require_once('../inc/mysql-db-connexion.php');
}
require_once('helpers/tools.php');
require_once('constant.php');
require_once('carts.php');

function create_user(array $form,PDO $db): bool{

    if (($_SERVER["REQUEST_METHOD"] == "POST")) {

        $user_pseudo = $form['login_pseudo'];
        $user_pwd = password_hash($form['plain_password'],PASSWORD_BCRYPT);
        $user_email = $form['user_email'];
        $user_address = $form['user_address'];
        $user_postal_code = $form['user_postal_code'];
        $user_city = $form['user_city'];
        $user_firstname = $form['user_firstname'];
        $user_lastname = $form['user_lastname'];
        $user_birthday =  $form['user_birthdate'];
        $user_eyes_color = $form['user_eyes_color'];
        $user_size = $form['user_size'];
        $user_weight = $form['user_weight'];
        $user_animal_name = $form['user_animal_name'];
        $user_role = MEMBER_ID;

        $sqlQuery ='INSERT INTO users (pseudo, email, pwd, address, postal_code, city, firstname, lastname, birthday, eyes_color, size, weight, animal_name, last_login, role_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';

        $insert_user= $db->prepare($sqlQuery);
        try {
            $insert_user->execute([$user_pseudo,$user_email,$user_pwd, $user_address, $user_postal_code, $user_city, $user_firstname, $user_lastname, $user_birthday, $user_eyes_color, $user_size, $user_weight, $user_animal_name, date("Y-m-d h:i:sa"), $user_role]);
        }catch(Exception $e){
            die('Erreur : ' . $e->getMessage());
        }
        return true;
    }else{
        return false;
    }
}

function getAllUsers(PDO $db): array{

    try {
        $sqlQuery ='SELECT users.id as user_id, users.pseudo, users.city, CONCAT(users.firstname, " ", users.lastname) as user_name, DATEDIFF(NOW(), users.birthday) as user_age FROM users WHERE users.anonymized != 1';

        $result = $db->prepare($sqlQuery);
        $result->execute();

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }catch(Exception $e){
        die('Erreur : ' . $e->getMessage());
    }
}

function getOneUser(PDO $db,int $userId): array{

    try {
        $sqlQuery ='SELECT users.id as user_id, users.pseudo, users.email, users.address, users.postal_code, users.city, users.firstname, users.lastname, users.birthday, users.eyes_color, users.size, users.weight, users.animal_name, users.last_login FROM users WHERE users.id = ?';

        $result= $db->prepare($sqlQuery);
        $result->execute([$userId]);

        return $result->fetch(PDO::FETCH_ASSOC);
    }catch(Exception $e){
        die('Erreur : ' . $e->getMessage());
    }
}

function updateLastLoginUser(int $userId,PDO $db): void{

    $sqlQuery ='UPDATE users SET last_login = :last_login WHERE users.id = :user_id';

    $update_user= $db->prepare($sqlQuery);
    try {
        $update_user->execute([
            ':last_login' => date("Y-m-d H:i:s"),
            ':user_id' => $userId
        ]);
    }catch(Exception $e){
        die('Erreur : ' . $e->getMessage());
    }

}

function getUserMinimumInfo(PDO $db,string $username): array|bool{
    try {
        $request_profil_user = $db->prepare('SELECT users.id as user_id, users.pseudo, users.pwd
        FROM users
        where pseudo = ?');

        $request_profil_user->execute([$username]);
        return $request_profil_user->fetch(PDO::FETCH_ASSOC);
    }
    catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

function getUserInfoForSession(PDO $db,int $user_id): array{
    try {
        $request_profil_user = $db->prepare('SELECT users.id as user_id, users.pseudo, roles.power, roles.name as role_name
        FROM users
        LEFT JOIN roles ON roles.id = users.role_id
        where users.id = ?');

        $request_profil_user->execute([$user_id]);

        return $request_profil_user->fetch(PDO::FETCH_ASSOC);
    }
    catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}

if ((isset($_SERVER['PHP_SELF'])) && (stristr($_SERVER['PHP_SELF'],'user_list.php'))){

    $users = getAllUsers($db);
    queryResultNull($users);
}

if ((isset($_SERVER['PHP_SELF'])) && (stristr($_SERVER['HTTP_REFERER'],'user_create.php')) && (verify_isset_non_empty($_POST['login_pseudo'])) && (verify_isset_non_empty($_POST['plain_password']))) {

    $form = $_POST;
    $result=create_user($form,$db);
    if ($result=="true") {
        $_SESSION['info']['success_creating_user'] = "Utilisateur créé";
        header('Location: ../../views/user_create.php');
        exit;

    }elseif ($result=="false"){
        $_SESSION['info']['error_creating_user'] = "Bug création utilisateur";
        header('Location: ../../views/user_create.php');

    }else{
        $_SESSION['info']['error_creating_user'] = "Something wen't wrong";
        header('Location: ../../views/login.php');
    }

}

if ((isset($_SERVER['PHP_SELF'])) && ((stristr($_SERVER['PHP_SELF'], 'user_profil.php')) || (stristr($_SERVER['HTTP_REFERER'],'user_profil.php')))) {
    $userId = null;

    if (verify_isset_non_empty($_GET['id'])) {
        $userId = $_GET['id'];
    } elseif (verify_isset_non_empty($_POST['user_id'])) {
        $userId = $_POST['user_id'];
    }

    if ($userId !== null) {
        if (isset($_POST['addCart']) && ($_POST['addCart'] == 1)) {
            if (addNewCart($db, $userId)) {
                $_SESSION['info']['cartAdd'] = "Panier ajouté avec succès";
            } else {
                $_SESSION['info']['cartAdd'] = "Erreur lors de l'ajout";
            }
            header('Location: ../../views/user_profil.php?id='.$userId);
            exit;
        }else{
            $user = getOneUser($db, $userId);
            queryResultNull($user);
            if (is_array(getUserCart($db, $userId)))
            {
                $user['carts'] = getUserCart($db, $userId);
            }
            return $user;
        }
    }else{
        header('Location: '.$_SERVER['HTTP_REFERER']);
        exit;
    }
}

?>