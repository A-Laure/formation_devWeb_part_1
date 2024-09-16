<?php

    $plain_password = readline("Enter plain password: ");


    $user_pwd = password_hash($plain_password,PASSWORD_BCRYPT);

    echo $user_pwd;

?>