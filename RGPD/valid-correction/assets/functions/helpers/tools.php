<?php

function valid_donnees(string $donnees): string {

    $special_remplacement=["&amp","&quot","&#039","&lt","&gt","&apos"];
    $spe_char_symbol=["$","=","#","/","²","§","%","*","µ","£","¤","€","_","?","!",";",",",":","{","}","(",")","^","¨","+","~","|","Ø","³","¡","«","»","¦","©","ª","¬","±","°","¹","º","¿","¼","½","¾","¶"];

    $donnees = trim($donnees);
    $donnees = stripslashes($donnees);
    $donnees = htmlentities($donnees);
    $donnees = htmlspecialchars($donnees);
    $donnees = str_ireplace($special_remplacement, "", $donnees);
    $donnees = str_ireplace($spe_char_symbol, "", $donnees);
    $donnees = strtolower($donnees);

    return $donnees;
}

function verify_isset_non_empty(array|string|null ...$elements): bool {
    foreach ($elements as $element) {
        if (!isset($element) || empty($element)) {
            return false;
        }
    }
    return true;
}

function verify_is_numeric(array|int ...$elements): bool {

    foreach ($elements as $element) {
        if (!is_numeric($element)) {
            return false;
        }
    }
    return true;

}


function is_valid_string(string $variable,int $minLength = null,int $maxLength = null): bool {

    if (!is_string($variable)) {
        return false;
    }

    $length = strlen($variable);

    if (($minLength !== null && $length < $minLength) || ($maxLength !== null && $length > $maxLength)) {
        return false;
    }

    return true;
}

function is_valid_email(string $email) : bool {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function validateDate(string $date, $format = 'Y-m-d'): bool {
    $d = DateTime::createFromFormat($format, $date);
    if ($d && $d->format($format) === $date) {

        $now = new DateTime();
        return $d < $now; 
    }
    return false;
}

function queryResultNull(string|array $result): void{
    if (($result === null) || (!is_array($result))) {
    
        $_SESSION['info']['not_found'] = 'Elément non trouvé';
        header('Location: '.$_SERVER['HTTP_REFERER']);
        exit;

    }
}

function gettingRandomBytes(): string{
    $randomBytes = random_bytes(NUMBER_OF_BYTES_FOR_RANDOM);
    return bin2hex($randomBytes);
}

function dump($element) {
    echo "<div style='border:1px solid #ccc; padding:10px; margin:10px;'>";
    echo "<strong>Type:</strong> " . gettype($element) . "<br>";
    echo "<strong>Content:</strong> <pre>";
    
    if (is_array($element) || is_object($element)) {
        echo htmlspecialchars(print_r($element, true));
    } else {
        echo htmlspecialchars(var_export($element, true));
    }
    
    echo "</pre></div>";
}



?>