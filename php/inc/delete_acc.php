<?php
require_once 'user.php';
require_once 'config.php';

$pass = filter_input(INPUT_POST, 'passDelete', FILTER_SANITIZE_STRING);
$email = $_SESSION['user']['email'];

if($pass != ""){
    $stmt = $con->prepare('SELECT pass, wrong_logins FROM users WHERE email = ? AND confirm_code = 1 LIMIT 1');
    $stmt->execute([$email]);
    $data = $stmt->fetch();

    if($data['wrong_logins'] >= 5) {
        $user->logout();
        echo 'index';
    }

    if(password_verify($pass,$data['pass'])){
        $con->query('DELETE FROM users WHERE email = "' . $email . '"');
        $user->logout();
        echo 'index';
    } else {
        $stmt = $con->prepare('UPDATE users SET wrong_logins = wrong_logins + 1 WHERE email = ?');
        $stmt->execute([$email]);
        echo 'Hibás jelszó';
    }

} else {
    echo 'Adj meg jelszót';
}

die;

