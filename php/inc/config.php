<?php
    session_start();
    define('conString', 'mysql:host=localhost;dbname=diablo');
    define('dbUser', 'root');
    define('dbPass', '');

    define('userfile', 'user.php');
    define('loginfile', 'inc/login_inc.php');
    define('activatefile', 'activate.php');
    define('registerfile', 'inc/register.php');
    define('updatefile', 'inc/update.php');

    ini_set('default_charset', 'UTF-8');
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $user = new User();
    $user->dbConnect(conString, dbUser, dbPass);
    if(session_status() === PHP_SESSION_ACTIVE){
        try {
            $con = new PDO(conString, dbUser, dbPass);
        }catch(PDOException $e) { 

        }
    }else{
        $this->msg = 'Session did not start.';
        return false;
    }
?>