<!doctype html>
<html lang="hu">
<head>
<meta charset="utf-8">
<link rel="dns-prefetch" href="https://kit.fontawesome.com">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
<script async src="https://kit.fontawesome.com/79578fae4a.js" crossorigin="anonymous" ></script>
<script defer src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<meta name="description" content="Diablo IV Hub és Fórum. Minden hír amire szükséged van a játékról plusz a közösség összegyűjtve!">
<?php 
    require_once 'php/inc/user.php';
    require_once 'php/inc/config.php';
?>
<title>Diablo IV fanpage</title>
<link rel="stylesheet" type="text/css" href="css/navbar.css" media="all">
<link rel="stylesheet" type="text/css" href="css/style.css" media="all">
<link rel="preconnect" href="https://fonts.gstatic.com">
<link rel="preconnect" href="https://platform.twitter.com">
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500&family=Forum&display=swap" rel="stylesheet" media="all">
<link rel="stylesheet" type="text/css" href="css/loading.css" media="all">
<link rel="shortcut icon" href="img/favicon.png" />
<?php 
$loggedIn = false;
$admin = false;
if (isset($_SESSION['user']['username'])) {
    $loggedIn = true;
    if ($_SESSION['user']['user_role'] == 1) { $admin = true;
    echo<<<END
        <style>
            
        </style>
    END;
    }
}?>
</head>



<body>
<div id="page-container">
    <header class="header">
        <nav class="navbar navbar-expand-lg fixed-top py-3">
            <div class="container"><a href="#" class="navbar-brand heavy">Diablo IV</a>
                <button type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler navbar-toggler-right"><i class="fas fa-bars"></i><i class="fas fa-arrow-down"></i></button>
                
                <div id="navbarSupportedContent" class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item active"><a href="#" class="nav-link ">Kezdőlap</span></a></li>
                        <li class="nav-item"><a href="php/forum.php" class="nav-link ">Fórum</a></li>
                        <li class="nav-item" id="loginButton" <?php if($loggedIn == true){echo 'hidden="true"';} ?>><a href="php/login.php" class="nav-link ">Bejelentkezés</a></li>
                        <li class="nav-item" <?php if($loggedIn == false){echo ' hidden="true"';} ?>><div class="btn-group">
                            <a href="php/userpage.php" class="nav-link">Profil (<?php echo $_SESSION['user']['username']; if($admin == false) {echo ' <i class="fas fa-user-alt"></i>';} else {echo ' <i class="fas fa-user-tie"></i>';}?>)</a>
                            <button type="button" class="btn dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false"></button>
                            <ul class="dropdown-menu">
                                <li class="dropdown-item d-none d-lg-block" <?php if($loggedIn == false){echo 'hidden="true"';} ?>><a href="php/userpage.php" class="nav-link">Beállítások</a></li>
                                <li class="dropdown-item" <?php if($loggedIn == false){echo 'hidden="true"';} ?> id="logoutButton"><a href="php/inc/logout_inc.php" class="nav-link ">Kijelentkezés</a></li>
                            </ul>
                            
                        </div></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
<div class="container content">
	<div class="row">
		<div class="col-md-6" style="height: 500px;">
        <h3 id="top">Diablo IV Unofficial Hub</h3>
        <p>Hírek és fórum a Diablo IV játékhoz. További infó: <a target="_blank" rel="noopener" href="http://diablo4.blizzard.com">Diablo IV hivatalos weblap</a>. Vagy nézd meg a trailert előbb:</p>
        <iframe class="mt-2" id="youtube-embed" width="560" height="315" src="https://www.youtube-nocookie.com/embed/0SSYzl9fXOQ" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
		</div>
		<div class="col-md-6" style="height: 500px;">
        <a class="twitter-timeline" data-width="100%" data-height="500px" data-theme="dark" href="https://twitter.com/Diablo?ref_src=twsrc%5Etfw" data-chrome="transparent"></a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
		</div>
	</div>
    <div class="row heading">
        <h3 class="mt-3 anchored" id="news">Hírek</h3>
    </div> 
    <div class="py-3 row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4" id="news-row">
    <div class="col">
            <div class="card news-card dummy new">
                <div class="card-header"></div>
                <div class="card-body">
                    <h5 class="card-title"></h5>
                    <p class="card-text"></p>
                </div>
                <div class="card-footer">
                    <a href="#" class="card-link"></a>
                </div>
                <div class="news-loading">
                <?php //include 'php/inc/loading-hex.php'?>
                </div>
                <div class="news-loading-blur"></div>
            </div>
        </div>
        <div class="col">
            <div class="card news-card dummy new">
                <div class="card-header"></div>
                <div class="card-body">
                    <h5 class="card-title"></h5>
                    <p class="card-text"></p>
                </div>
                <div class="card-footer">
                    <a href="#" class="card-link"></a>
                </div>
                <div class="news-loading">
                <?php //include 'php/inc/loading-hex.php'?>
                </div>
                <div class="news-loading-blur"></div>
            </div>
        </div>
            <div class="col">
            <div class="card news-card dummy new">
                <div class="card-header"></div>
                <div class="card-body">
                    <h5 class="card-title"></h5>
                    <p class="card-text"></p>
                </div>
                <div class="card-footer">
                    <a href="#" class="card-link"></a>
                </div>
                <div class="news-loading">
                <?php //include 'php/inc/loading-hex.php'?>
                </div>
                <div class="news-loading-blur"></div>
            </div>
        </div>
        <div class="col">
            <div class="card news-card dummy new">
                <div class="card-header"></div>
                <div class="card-body">
                    <h5 class="card-title"></h5>
                    <p class="card-text"></p>
                </div>
                <div class="card-footer">
                    <a href="#" class="card-link"></a>
                </div>
                <div class="news-loading">
                <?php //include 'php/inc/loading-hex.php'?>
                </div>
                <div class="news-loading-blur"></div>
            </div>
        </div>   
    </div>
    <?php if(isset($_SESSION['cookies']) == false) {echo'
    <div class="position-fixed bottom-0 start-0 p-0 w-100" style="z-index: 5">
        <div class="toast fade text-white bg-dark w-100 cookies" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
            <div class="d-flex px-2">
                <div class="toast-body">
                    <span><i class="fas fa-cookie-bite"></i> A weboldal használatával tudomásul veszed és elfogadod a sütik használatát.</span>
                </div>
                <button type="button" class="btn-close btn-close-white m-auto me-2" data-bs-dismiss="toast" aria-label="Close" id="cookie"></button>
            </div>
        </div>
    </div>
    <script defer src="js/allowCookies.js"></script>';} ?>
</div>


<footer>
    <div class="container">
    <p <?php if($admin == false){echo 'hidden="true"';}?>><a style="text-decoration: none" class="text-muted" href="php/addnew.php">Hírek kezelése</a></p>
</footer>
</div>
<?php session_write_close(); ?>
<script src="https://cdn.jsdelivr.net/npm/anchor-js/anchor.min.js"></script>
<script type="text/javascript">
anchors.options = {
  placement: 'right',
  visible: 'hover',
  icon: ''
};
anchors.add('anchor');
</script>
</body>
<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
<script defer src="js/navbar.js"></script>
<script defer src="js/loadNews.js"></script>
<script defer src="js/toastInit.js"></script>

</html>
