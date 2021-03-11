<?php
    require_once 'user.php';
    require_once 'config.php';

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $pass = filter_input(INPUT_POST, 'password', FILTER_DEFAULT);

    if($user->registration($email, $username, $pass)) {
        print 'Kérlek nézd meg az emailed a folytatáshoz';
        die;
    } else {
        $user->printMsg();
        die;
    }