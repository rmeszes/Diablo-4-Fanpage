<?php
    $stmt = $con->prepare("SELECT cat_name, cat_id FROM categories WHERE cat_id = ? LIMIT 1");
    $stmt->execute([$_GET['category']]);
    $cat = $stmt->fetch();

    $stmt = $con->prepare("SELECT topic_name, topic_id FROM topics WHERE topic_id = ? LIMIT 1");
    $stmt->execute([$_GET['topic']]);
    $topic = $stmt->fetch();

    echo '
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="?">Kategóriák</a></li>
            <li class="breadcrumb-item"><a href="?category=' . $cat['cat_id'] . '">' . anything_to_utf8($cat['cat_name']) . '</a></li>
            <li class="breadcrumb-item active" aria-current="page">' . anything_to_utf8($topic['topic_name']) . '</li>
            </ol>
        </nav>
    ';

    $formMessage = "";
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $loggedIn == true) {
        $post = filter_input(INPUT_POST, 'new_post', FILTER_SANITIZE_STRING);
        $post_title =  filter_input(INPUT_POST, 'post-title', FILTER_SANITIZE_STRING);
        if($post != "" && $post_title != "") {
            $stmt = $con->prepare("INSERT INTO posts(post_content, post_title, uploaded_by_id, uploaded_by_name, topic_id, uploaded_on) VALUES(?,?,?,?,?,NOW())");
            $stmt->execute([$post,$post_title,$_SESSION['user']['id'],$_SESSION['user']['username'],$_GET['topic']]);
            if(!$stmt->rowCount()>0)
            {
                $formMessage = 'Sikertelen megosztás!';
            }
        }
    }
    
    if($loggedIn == true) { echo '

    
    <form class="row g-3 new-post pb-3 px-3" method="POST" action="">
    ' . $formMessage . '
        <h4>Új poszt</h4>
        <div class="row">
            <div class="col-auto">
                <label for="post-title" class="col-form-label">Cím:</label>
            </div>
            <div class="col-auto">
                <input type="text" class="form-control botbord" id="post-title" name="post-title">
            </div>
        </div>
        <div class="col-md-9 col-lg-10 ">
            <label for="new-post" class="visually-hidden">Mondj valamit!</label>
            <textarea class="form-control" required id="new-post" placeholder="Tartalom" name="new_post"></textarea>
        </div>
        <div class="col-md-auto align-self-end">
            <input class="btn btn-style-1" type="submit" value="Megosztás">
        </div>
    </form>'; } else {
        echo '<p>Jelentkezz be hogy posztolhass!</p>';
    }


    $stmt = $con->prepare( "SELECT COUNT(*) FROM posts" );
    $stmt->execute();

    list($count) = $stmt->fetch(PDO::FETCH_NUM);

    if(isset($_GET['show'])) {
        if($_GET['show']>6){
            $end = $_GET['show'];
        } else {
            $end = 6;
        }
    } else {
        $end = 6;
    }
    echo '<script src="../js/deletePost.js"></script>';
    $posts = $con->prepare('SELECT * FROM posts WHERE topic_id = ? ORDER BY uploaded_on DESC LIMIT ' . $end);
    $posts->execute([$_GET['topic']]);
    echo '<h3 class="heading my-3 pb-2">Posztok</h3>';
    foreach ($posts as $row) {
        echo '
        <div class="card post my-3">
            <div class="card-header justify-content-between row" id="post-' . $row['post_id'] . '">
                <div class="col-auto">' . $row['uploaded_by_name'] . '</div>
                <div class="col-auto"><p class="card-text text-muted"><small>' . $row['uploaded_on'] . '</small></p></div>
            </div>
            <div class="card-body pt-1">
                <div class="row justify-content-between mb-2">
                    <div class="col-auto"><p class="card-text"><strong>' . $row['post_title'] . '</strong></p></div>
                    <div class="col-auto">'; if($admin == true || $_SESSION['user']['username'] == $row['uploaded_by_name']) { include 'actionbuttonsPost.php'; } echo '</div>
                </div>
                <p class="card-text">' . $row['post_content'] . '</p>
            </div>
            <div class="card-footer">
                <button class="btn btn-link p-0" id="replies-' . $row['post_id'] . '">Kommentek</button>
            </div>
        </div>
        ';
    }

    if($posts->rowCount()>0) {
        if(isset($_GET['show'])) {
            if ($_GET['show'] < $count) {
                echo '<a class="btn btn-style-1 w-100" href="?category=' . $_GET['category'] . '&topic=' . $_GET['topic'];
                if(isset($_GET['show'])) {
                    echo '&show=' . 6 + $_GET['show'] . '#post-' . $row['post_id'];
                }
                echo '">Több..</a>';
            } else {
                echo '<p class="text-center">Úgy látszik a végére értél.. *cirip cirip*</p>';
            }
        } elseif ($count > 4) {
            echo '<a class="btn btn-style-1 w-100" href="?category=' . $_GET['category'] . '&topic=' . $_GET['topic'];
            if(isset($_GET['show'])) {
                echo '&show=' . 6 + $_GET['show'] . '#post-' . $row['post_id'];
            } else {
                echo '&show=12#post-' . $row['post_id'];
            }
            echo '">Több..</a>';
        } else {
            echo '<p class="text-center">Úgy látszik a végére értél.. *cirip cirip*</p>';
        }
    }

    echo '
    <script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
    </script>
    ';
?>