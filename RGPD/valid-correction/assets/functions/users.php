<?php
if (stristr($_SERVER['PHP_SELF'],'view'))
{
    require_once('../assets/inc/mysql-db-connexion.php');
}else{
    require_once('../inc/mysql-db-connexion.php');
}
if (stristr($_SERVER['HTTP_REFERER'],'login.php')){
}else{
require_once('has_access.php');
}
require_once('helpers/tools.php');
require_once('constant.php');
require_once('carts.php');


function verify_user_form(array $form): bool{

    if (verify_isset_non_empty($form['login_pseudo'],
    $form['plain_password'],
    $form['user_email'],
    $form['user_address'],
    $form['user_postal_code'],
    $form['user_city'],
    $form['user_firstname'],
    $form['user_lastname'],
    $form['user_birthdate'],
    $form['user_eyes_color'],
    $form['user_size'],
    $form['user_weight'],
    $form['user_animal_name']))
    {
        if (verify_is_numeric($form['user_postal_code'],
        $form['user_size'],
        $form['user_weight'])){
            
            if(is_valid_string($form['login_pseudo'],MIN_LENGTH_PSEUDO,MAX_LENGTH_PSEUDO) &&
            is_valid_string($form['plain_password'],MIN_LENGTH_PASSWORD,MAX_LENGTH_PASSWORD) &&
            is_valid_string($form['user_email']) && 
            is_valid_string($form['user_address']) && 
            is_valid_string($form['user_city']) && 
            is_valid_string($form['user_firstname']) && 
            is_valid_string($form['user_lastname']) && 
            is_valid_string($form['user_eyes_color']) && 
            is_valid_string($form['user_animal_name'])){

                if((strlen($form['user_postal_code'])==5) && in_array($form['user_eyes_color'],EYES_COLOR) && is_valid_email($form['user_email']) && validateDate($form['user_birthdate'])){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }

        }else{
            return false;
        }
    }else{
        return false;
    }
}

function create_user(array $form,PDO $db): bool{

    if (($_SERVER["REQUEST_METHOD"] == "POST") && verify_user_form($_POST)) {

        $user_pseudo = valid_donnees($form['login_pseudo']);
        $user_pwd = password_hash($form['plain_password'],PASSWORD_BCRYPT); // $user_pwd  = $form['plain_password'];
        $user_email = valid_donnees($form['user_email']);
        $user_address = valid_donnees($form['user_address']);
        $user_postal_code = valid_donnees($form['user_postal_code']);
        $user_city = valid_donnees($form['user_city']);
        $user_firstname = valid_donnees($form['user_firstname']);
        $user_lastname = valid_donnees($form['user_lastname']);
        $user_birthday =  $form['user_birthdate'];
        $user_eyes_color = valid_donnees($form['user_eyes_color']);
        $user_size = valid_donnees($form['user_size']);
        $user_weight = valid_donnees($form['user_weight']);
        $user_animal_name = valid_donnees($form['user_animal_name']);
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

function gettingAnonymizedBirthdate(string $birthdate): string{

    if (is_string($birthdate)) {
        $birthdate = new \DateTime($birthdate);
    }

    $year = $birthdate->format('Y');

    return $year.'-01-01';
}

function updateUser(PDO $db,array $user,int $userId): void{

    $sqlQuery = '
    UPDATE users 
    SET 
        pseudo = ?, 
        email = ?, 
        address = ?, 
        firstname = ?, 
        lastname = ?, 
        birthday = ?, 
        size = ?, 
        weight = ?, 
        anonymized = 1
    WHERE 
        users.id = ?';

    $anonymizing_user = $db->prepare($sqlQuery);
    try {
        $anonymizing_user->execute([
            $user['pseudo'],
            $user['email'],
            $user['address'],
            $user['firstname'],
            $user['lastname'],
            $user['birthday'],
            $user['size'],
            $user['weight'],
            $userId
        ]);
    }catch(Exception $e){
        die('Erreur : ' . $e->getMessage());
    }
}

function savingDataUser(PDO $db,array $user): bool{

    $user_id=$user['user_id'];
    $user_email = $user['email'];
    $user_address = $user['address'];
    $user_postal_code = $user['postal_code'];
    $user_city = $user['city'];
    $user_firstname = $user['firstname'];
    $user_lastname = $user['lastname'];
    $user_last_login = $user['last_login'];

    $sqlQuery ='INSERT INTO user_archive (email, address, postal_code, city, firstname, lastname, last_login, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';

    $insert_user= $db->prepare($sqlQuery);
    try {
        $insert_user->execute([$user_email, $user_address, $user_postal_code, $user_city, $user_firstname, $user_lastname, $user_last_login, $user_id]);
    }catch(Exception $e){
        die('Erreur : ' . $e->getMessage());
    }
    return true;
}

function getAllUsersToAnonymized(PDO $db,string $date): array{

    try {
        $sqlQuery ='SELECT users.id as user_id FROM users WHERE users.last_login < ? AND users.anonymized != 1';

        $result = $db->prepare($sqlQuery);
        $result->execute([$date]);

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }catch(Exception $e){
        die('Erreur : ' . $e->getMessage());
    }
}

function randomizingUserData(array $user): array{

    $user['pseudo']=gettingRandomBytes();
    $user['email']=gettingRandomBytes().MAIL_ANONYMIZED_DOMAIN;
    $user['address']=gettingRandomBytes();
    $user['firstname']=gettingRandomBytes();
    $user['lastname']=gettingRandomBytes();
    $user['birthday']=gettingAnonymizedBirthdate($user['birthday']);
    $user['size']=round($user['size']);
    $user['weight']=round($user['weight']);

    return $user;
}
function anonymizingUser(PDO $db, int $userId): string{

    $user = getOneUser($db, $userId);

    if ($user != null) {

        $result = savingDataUser($db,$user);

        if (!empty($result) && $result != true) {
            return $result;
        }else{
            $user = randomizingUserData($user);

            updateUser($db,$user,$userId);

            return "Utilisateur anonymisé";
        }
    }else{
        return "Utilisateur non trouvé";
    }
}

if ((isset($_SERVER['PHP_SELF'])) && (stristr($_SERVER['PHP_SELF'],'user_list.php'))){

    if (isLogged()){
        $users = getAllUsers($db);
        queryResultNull($users);
    }else{
        header('Location: '.$_SERVER['HTTP_REFERER']);
        exit;
    }
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
        if (hasAdminAccess() && isset($_POST['anonymized']) || isset($_POST['addCart'])) {
            if ($_POST['anonymized'] == 1) {
                $result = anonymizingUser($db, $userId);
                $_SESSION['info']['anonymized'] = $result;
                header('Location: ../../views/user_profil.php?id='.$userId);
                exit;
            } elseif ($_POST['addCart'] == 1) {
                if (addNewCart($db, $userId)) {
                    $_SESSION['info']['cartAdd'] = "Panier ajouté avec succès";
                } else {
                    $_SESSION['info']['cartAdd'] = "Erreur lors de l'ajout";
                }

                header('Location: ../../views/user_profil.php?id='.$userId);
                exit;
            }
        } elseif (isLogged()) {
            $user = getOneUser($db, $userId);
            queryResultNull($user);
            if (is_array(getUserCart($db, $userId)))
            {
                $user['carts'] = getUserCart($db, $userId);
            }
            return $user;
        }
    } else {
        header('Location: '.$_SERVER['HTTP_REFERER']);
        exit;
    }
}

if (isset($_SERVER['HTTP_REFERER']) && (stristr($_SERVER['HTTP_REFERER'],'user_list.php')) && isset($_POST['anonymizedAll'])){

    if(hasAdminAccess() && $_POST['anonymizedAll']==1){
        $result_anonymized_users = [];

        $date = new DateTime();
        $date->modify('-3 years');
        $newDate = $date->format('Y-m-d H:i:s');

        $user_to_anonymized = getAllUsersToAnonymized($db,$newDate);

        foreach ($user_to_anonymized as $user){
            $userId = $user['user_id'];
            $result_anonymized_users[] = anonymizingUser($db, $userId).' '.$userId;
        }
        
        header('Location: ../../views/user_list.php');
        exit;
    }else{
        header('Location: '.$_SERVER['HTTP_REFERER']);
        exit;
    }
}
?>