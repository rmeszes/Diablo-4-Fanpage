<!doctype html>
<?php require 'header.php';
    require_once 'inc/user.php';
    require_once 'inc/config.php';
    ?>
    <title>Profil</title>
    <link rel="stylesheet" type="text/css" href="../css/user-settings.css">
</head>

<?php 
if (!isset($_SESSION['user']['username'])) { header('location: login.php'); }
$admin = false;
if ($_SESSION['user']['user_role'] == 1) { $admin = true; };
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
                        <li class="nav-item" ><div class="btn-group">
                            <a href="#" class="nav-link">Profil (<?php echo $_SESSION['user']['username'];  if($admin == false) {echo ' <i class="fas fa-user-alt"></i>';} else {echo ' <i class="fas fa-user-tie"></i>';}?>)</a>
                            <button type="button" class="btn dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false"></button>
                            <ul class="dropdown-menu">
                                <li class="dropdown-item" id="logoutButton"><a href="inc/logout_inc.php" class="nav-link ">Kijelentkezés</a></li>
                            </ul>
                            
                        </div></li>                        
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <div class="container content">
        <div class="row">
            <div class="col pb-5">
                <!-- Account Sidebar-->
                <div class="author-card pb-3">
                    <div class="author-card-cover"></div>
                    <div class="author-card-profile">
                        <div class="author-card-avatar"><i class="fas fa-user-circle fa-5x" style="color: white;"></i>
                        </div>
                        <div class="author-card-details">
                            <p class="author-card-name text-lg" id="name"><?php echo $_SESSION['user']['username']?></p>
                        </div>
                    </div>
                </div>
            <!-- Profile Settings-->
                <div class="col pb-5">
                    <form class="row" action="#">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="account-email">E-mail cím</label>
                                <input class="form-control" type="email" id="email" value="<?php echo $_SESSION['user']['email']?>" disabled="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="account-fn">Felhasználónév</label>
                                <input class="form-control" type="text" id="username" value="<?php echo $_SESSION['user']['username']?>" required="">
                                <p class="wrong" id="userErr"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="account-pass">Új jelszó</label>
                                <input class="form-control" type="password" id="password" placeholder="(hagyd üresen ha nincs változás)">
                                <div id="pass_meter"></div>
                                <p class="wrong" id="passErr"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="account-confirm-pass">Új jelszó mégegyszer</label>
                                <input class="form-control" type="password" id="confirm-pass" placeholder="(hagyd üresen ha nincs változás)">
                                <p class="wrong" id="confErr"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="account-pass">Régi jelszó (kötelező)</label>
                                <input class="form-control" type="password" id="old-password" required="">
                                <p class="wrong" id="oldErr"></p>
                            </div>
                        </div>
                        <div class="col-12">
                            <hr class="mt-2 mb-3">
                            <div class="d-flex flex-wrap justify-content-between align-items-center">
                                <input class="btn btn-style-1" type="button" id="update-btn" value="Profil frissítés">
                                <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#deleteAccPrompt">Fiók törlése</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<div class="modal fade" id="deleteAccPrompt" tabindex="-1" role="dialog" aria-labelledby="deleteAccPromptLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteAccPromptLabel">Fiók törlése</h5>
      </div>
      <div class="modal-body pb-2">
      <div class="container">
            <div class="col-md-12">
                <p class="lead mb-2">Biztosan törölni szeretnéd a fiókod?</p>
            </div>
        <div class="col-md-12">
            <form action="inc/delete_acc.php" method="POST">
                <div class="form-group">
                    <label for="passDelete" class="form-label mb-0">Jelszó: </label>
                    <input type="password" class="form-control" name="passDelete" id="passDelete"></input>
                    <p class="wrong" id="delErr"></p>
                </div>
            </form>
        </div>
      </div>
      </div>
      <div class="modal-footer py-1">
        <div class="container">
            <div class="d-flex flex-row-reverse">
            <button type="button" class="btn btn-danger mx-1" id="delBtn">Igen!</button>
            <button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal">Mégsem</button>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script defer src="../js/deleteAcc.js"></script>
<script defer src="../js/validateMail.js"></script>
<script defer type="text/javascript" src="../js/zxcvbn.js"></script>
<script defer type="text/javascript" src="../js/jquery.password.strength.js"></script>
<script defer src="../js/userpage.js"></script>

<?php require 'footer.php'; ?>
