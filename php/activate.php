<!doctype html>
<?php require 'header.php';
    require_once 'inc/user.php';
    require_once 'inc/config.php';
    ?>
    <title></title>
</head>

<?php 
$loggedIn = false;
$admin = false;
if (isset($_SESSION['user']['username'])) {
    $loggedIn = true;
    if ($_SESSION['user']['user_role'] == 1) { $admin = true;}
}?>

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
                        <li class="nav-item" id="loginButton" <?php if($loggedIn == true){echo 'hidden="true"';} ?>><a href="login.php" class="nav-link ">Bejelentkezés</a></li>
                        <li class="nav-item" <?php if($loggedIn == false){echo ' hidden="true"';} ?>><div class="btn-group">
                            <a href="userpage.php" class="nav-link">Profil (<?php echo $_SESSION['user']['username'];  if($admin == false) {echo ' <i class="fas fa-user-alt"></i>';} else {echo ' <i class="fas fa-user-tie"></i>';}?>)</a>
                            <button type="button" class="btn dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false"></button>
                            <ul class="dropdown-menu">
                                <li class="dropdown-item d-none d-lg-block" <?php if($loggedIn == false){echo 'hidden="true"';} ?>><a href="userpage.php" class="nav-link">Beállítások</a></li>
                                <li class="dropdown-item" <?php if($loggedIn == false){echo 'hidden="true"';} ?> id="logoutButton"><a href="inc/logout_inc.php" class="nav-link ">Kijelentkezés</a></li>
                            </ul>
                            
                        </div></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container content py-5 mt-5">
    <?php
        require_once 'inc/user.php';
        require_once 'inc/config.php';

        if (isset($_GET['email'], $_GET['code'])) {
            if ($stmt = $con->prepare('SELECT * FROM users WHERE email = ? AND confirm_code = ?')) {
                //$stmt->bind_param('ss', $_GET['email'], $_GET['code']);
                $stmt->execute([$_GET['email'], $_GET['code']]);
                // Store the result so we can check if the account exists in the database.
                if ($stmt->rowcount() > 0) {
                    // Account exists with the requested email and code.
                    if ($stmt = $con->prepare('UPDATE users SET confirm_code = ? WHERE email = ? AND confirm_code = ?')) {
                        // Set the new activation code to 'activated', this is how we can check if the user has activated their account.
                        $newcode = '1';
                        //$stmt->bind_param('sss', $newcode, $_GET['email'], $_GET['code']);
                        $stmt->execute([$newcode, $_GET['email'], $_GET['code']]);
                        echo '<p>Fiók sikeresen aktiválva, mostmár <a href="login.php">beléphetsz</a>!</p>';
                    }
                } else {
                    echo '<p>A fiók már aktiválva van, vagy nem létezik</p>';
                }
            }
        }
    ?>
    </div>

<?php require 'footer.php'; ?>