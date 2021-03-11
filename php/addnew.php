<!doctype html>
<?php require 'header.php';
    require_once 'inc/user.php';
    require_once 'inc/config.php';
    ?>
    <title>Hír hozzáadása</title>
    <link rel="stylesheet" type="text/css" href="../css/user-settings.css">
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
                                <li class="dropdown-item  d-none d-lg-block" <?php if($loggedIn == false){echo 'hidden="true"';} ?>><a href="userpage.php" class="nav-link">Beállítások</a></li>
                                <li class="dropdown-item" <?php if($loggedIn == false){echo 'hidden="true"';} ?> id="logoutButton"><a href="inc/logout_inc.php" class="nav-link ">Kijelentkezés</a></li>
                            </ul>
                            
                        </div></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container content">
        <p class="lead" <?php if($admin == true){echo 'hidden="true"';} ?>>Ez az oldal nem elérhető számodra!</p>
        <form <?php if($admin == false){echo 'hidden="true"';} ?> class="row" method="post" action="" enctype="multipart/form-data">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label" for="new_name">Cím:</label> 
                    <input class="form-control" type="text" name="new_name" value="<?php echo $_POST['new_name'] ?>" />
                </div> 
            </div>
            <div class="col-md-6">
                <div class="form-group">    
                    <label class="form-label" for="new_description">Leírás: </label>
                    <input class="form-control" type="text" name="new_description" value="<?php echo $_POST['new_description'] ?>" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">    
                    <label class="form-label" for="new_description">Link: </label>
                    <input class="form-control" type="text" name="new_link" value="<?php echo $_POST['new_link'] ?>" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label" for="picture">Kép: (csak webp)</label>
                    <input type="file" class="form-control" name="picture">
                </div>
            </div>
            <div class="col-12">
                <hr class="mt-2 mb-3">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                    <input class="btn btn-style-1" type="submit" value="Hír hozzáadása">
                </div>
            </div>
        </form>

        <?php 
            if($_SERVER['REQUEST_METHOD'] == 'POST' && $admin == true) {
                if($_FILES['picture'] != null && $_POST['new_name'] != "" && $_POST['new_description'] != "" && $_POST['new_link'] != ""){
                    $target_dir = "../img/";
                    $target_file = $target_dir . basename($_FILES["picture"]["name"]);
                    $uploadOk = 1;
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                    
                    if (file_exists($target_file)) {
                        echo "A kép létezik. ";
                        $uploadOk = 0;
                    }

                    if($imageFileType != "webp" ) {
                    echo "Kérlek konvertáld a képed webp-re. ";
                    $uploadOk = 0;
                    }

                    if ($uploadOk != 0) {
                    // if everything is ok, try to upload file
                        if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
                            //echo "A kép: ". htmlspecialchars( basename( $_FILES["picture"]["name"])). " feltöltve";
                            $name = filter_input(INPUT_POST, 'new_name', FILTER_SANITIZE_STRING);
                            $description = filter_input(INPUT_POST, 'new_description', FILTER_SANITIZE_STRING);
                            $link = filter_input(INPUT_POST, 'new_link', FILTER_SANITIZE_STRING);
                            $path = 'img/' . basename($_FILES["picture"]["name"]);
                            $stmt = $con->prepare("INSERT INTO news(new_name, new_description, new_link, picture, new_date, uploaded_by) VALUES(?,?,?,?,NOW(),?)");
                            $stmt->execute([$name,$description,$link,$path,$_SESSION['user']['username']]);
                            if(!$stmt->rowCount()>0)
                            {
                            //something went wrong, display the error
                            echo 'Hiba ';
                            }
                            else
                            {
                            echo 'Új hír hozzá adva. ';
                            }
                        } else {
                            echo "A feltöltés nem sikerült ";
                        }
                    }
                } else { echo 'Valamit kihagytál '; }
                    
            }
        ?>


        <div class="row py-5">
            <div class="col-md-12 mx-auto">
                <table class="table table-hover table-dark">
                    <thead> 
                        <tr>
                            <th scope="col" width="80%">Hír cím</th>
                            <th scope="col" width="20%">Művelet</th>
                        </tr>
                    </thead>
                    <tbody id="table-body">
                        <?php include 'inc/news_table.php'; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php require 'footer.php'; ?>