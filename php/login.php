<!doctype html>

<?php include_once 'header.php' ?>
    
    <title>Bejelentkezés</title>
    <link rel="stylesheet" type="text/css" href="../css/login.css">
    
</head>

<?php
    require_once 'inc/user.php';
    require_once 'inc/config.php';

if (isset($_SESSION['user']['username'])) {
    header('location: forum.php');
}
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
                    <li class="nav-item"><a href="../index.php" class="nav-link ">Kezdőlap</span></a></li>
                    <li class="nav-item"><a href="forum.php" class="nav-link ">Fórum</a></li>
                    <li class="nav-item active"><a href="#" class="nav-link">Bejelentkezés</a></li>
                 </ul>
            </div>
        </div>
    </nav>
</header>

<div class="container content">
    <div class="login-dark pb-5 col-md-6 col-xl-4 align-self-center">
        <!--<form method="post">-->
            <h2 class="sr-only">Bejelentkezés</h2>
            <div class="illustration"><i class="fas fa-key"></i></div>
            <p class="wrong" id="loginErr"></p>
            <div class="form-floating mb-3">
                <input class="form-control" type="email" name="email" id="email" placeholder="E-mail cím">
                <label for="email">E-mail cím</label>
                <p class="wrong" id="emailErr"></p>
            </div>
            <div class="form-floating mb-3">
                <input class="form-control" type="password" name="password" id="password" placeholder="Jelszó">
                <label for="password">Jelszó</label>
                <p class="wrong" id="passErr"></p>
            </div>
            <div class="form-row text-center"><input class="btn btn-block btn-primary" id="login-submit" type="button" value="Bejelentkezés"></div>
            <a href="signup.php" class="forgot my-1">Még nincs fiókod?</a>
        <!--</form>-->
    </div>
    <script defer src="../js/validateMail.js"></script>
    <script defer src="../js/login.js"></script>
</div>
<?php include_once 'footer.php' ?>
