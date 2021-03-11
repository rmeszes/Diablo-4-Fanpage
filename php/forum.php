<!doctype html>
<?php require 'header.php';
    require_once 'inc/user.php';
    require_once 'inc/config.php';
    ?>
    <title>Diablo IV Fórum</title>
    <link rel="stylesheet" type="text/css" href="../css/user-settings.css">

    <style>
        :root {
            scroll-behavior: auto;
        }
    </style>
</head>

<?php 
$loggedIn = false;
$admin = false;
$submitted = false;
if (isset($_SESSION['user']['username'])) {
    $loggedIn = true;
    if ($_SESSION['user']['user_role'] == 1) { $admin = true; }
}


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
                        <li class="nav-item active"><a href="forum.php" class="nav-link ">Fórum</a></li>
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

    <div class="container content">

        <div class="row heading">
            <h1>Fórum</h1>
        </div>

        <div class="row py-4">
            <div class="col-md-12 mx-auto">
                <?php 
                    if(isset($_GET['category']) && isset($_GET['topic'])){
                        $stmt = $con->prepare('SELECT topic_name FROM topics WHERE cat_id = ? AND topic_id = ?');
                        $stmt->execute([$_GET['category'],$_GET['topic']]);
                        if($stmt->rowCount()>0) { $category = true; } else { $category = false; }
                        if($category == true) { include 'inc/forum_posts.php'; } else { echo 'Az oldal nem található! <a href="?">Vissza a fórumba</a>'; }
                    } elseif(isset($_GET['category'])){
                        $stmt = $con->prepare('SELECT cat_name FROM categories WHERE cat_id = ?');
                        $stmt->execute([$_GET['category']]);
                        if($stmt->rowCount()>0) { $category = true; } else { $category = false; }
                        if($category == true) { include 'inc/forum_topics.php'; } else { echo 'Az oldal nem található! <a href="?">Vissza a fórumba</a>'; }
                    } else { include 'inc/forum_categories.php'; }
                ?>
            </div>
        </div>

        </div>
    

<?php require 'footer.php'; ?>