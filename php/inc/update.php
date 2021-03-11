<?php
    require_once 'user.php';
    require_once 'config.php';

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $oldpass = filter_input(INPUT_POST, 'oldPass', FILTER_DEFAULT);
    $newpass = "";
    $newpass = filter_input(INPUT_POST, 'password', FILTER_DEFAULT);

    if($user->update($email, $username, $oldpass, $newpass)) {
        print 'Sikeres változtatás';
        die;
    } else {
        $user->PrintMsg();
        die;
    }