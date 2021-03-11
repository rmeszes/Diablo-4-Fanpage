<!doctype html>
<?php require_once 'header.php';
     require_once 'inc/user.php';
     require_once 'inc/config.php';
?>
    <title>Regisztráció</title>
    <meta name="description" content="Regisztrálj az oldalunkra, hogy beszélgethess a fórumonkon!">
    <link rel="stylesheet" type="text/css" href="../css/login.css">

</head>
<?php
   
    if (isset($_SESSION['user']['username'])) { header('location: forum.php');}
    $loggedIn = false;
    $admin = false;
?>
<body>
<div id="page-container">

<header class="header">
    <nav class="navbar navbar-expand-lg fixed-top py-3">
        <div class="container"><a href="../index.php" class="navbar-brand semi-bold heavy">Diablo IV</a>
            <button type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler navbar-toggler-right"><i class="fas fa-bars"></i><i class="fas fa-arrow-down"></i></button>
                
            <div id="navbarSupportedContent" class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a href="../index.php" class="nav-link ">Kezdőlap</a></li>
                    <li class="nav-item"><a href="forum.php" class="nav-link ">Fórum</a></li>
                    <li class="nav-item"><a href="login.php" class="nav-link  current">Bejelentkezés</a></li>
                 </ul>
            </div>
        </div>
    </nav>
</header>
<div class="container content" id="signup-form">
    <div class="login-dark col-md-6 col-xl-4 align-self-center">
        <!--<form method="post" autocomplete="off">-->
            <h2 class="sr-only">Regisztráció</h2>
            <div class="illustration"><i class="far fa-address-card"></i></div>
            <p class="wrong" id="regErr"></p>
            <div class="form-floating mb-3">
                <input class="form-control" type="text" name="username" id="username" placeholder="Felhasználónév">
                <label for="username">Felhasználónév</label>
                <p class="wrong" id="userErr"></p>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" type="text" name="email" id="email" placeholder="E-mail cím">
                <label for="email">E-mail cím</label>
                <p class="wrong" id="emailErr"></p>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" type="password" name="password" id="password" placeholder="Jelszó">
                <label for="password">Jelszó</label>
                <div id="pass_meter"></div>
                <p class="wrong" id="passErr"></p>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" type="password" name="confirm-password" id="confirm-password" placeholder="Jelszó mégegyszer">
                <label for="confirm-password">Jelszó mégegyszer</label>
                <p class="wrong" id="confErr"></p>
            </div>
            <div><input type="button" name="register-submit" id="register-submit" class="btn btn-primary btn-block" value="Regisztráció"></div>
            <a href="login.php" class="forgot my-1">Van már fiókod?</a>
        <!--</form>-->
    </div>
</div>
    <script defer type="text/javascript" src="../js/zxcvbn.js"></script>
    <script defer type="text/javascript" src="../js/jquery.password.strength.js"></script>
    <script defer src="../js/validateMail.js"></script>
    <script defer src="../js/signupEnd.js"></script>
<?php require_once 'footer.php' ?>

