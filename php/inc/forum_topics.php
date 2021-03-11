<?php 
    require_once 'user.php';
    require_once 'config.php';

    $submitted = false;
    $formMessage = "";
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $admin == true) {
        $name =  filter_input(INPUT_POST, 'topic_name', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'topic_description', FILTER_SANITIZE_STRING);
        $id = filter_input(INPUT_POST, 'topic_id', FILTER_SANITIZE_STRING);
        if($id != "") {
            $stmt = $con->prepare('SELECT topic_id FROM topics WHERE topic_id = ?');
            $stmt->execute([$id]);
            if($stmt->rowCount()>0){
                $stmt = $con->prepare("UPDATE topics SET topic_name = ?, topic_description = ?, uploaded_by_id = ?, uploaded_by_name = ? WHERE topic_id = ?");
                $stmt->execute([$name,$description,$_SESSION['user']['id'],$_SESSION['user']['username'],$id]);
                if(!$stmt->rowCount()>0)
                {
                    $formMessage = 'Hiba ';
                }
                else
                {
                    $formMessage = 'Téma sikeresen módosítva!';
                }
            } else {
                $formMessage = 'Nincs téma ezzel az id-vel!';
            }
        } elseif($name != "") {
            $stmt = $con->prepare('SELECT topic_name FROM topics WHERE topic_name = ? AND cat_id = ?');
            $stmt->execute([$name,$_GET['category']]);
            if(!$stmt->rowCount()>0) {
                $stmt = $con->prepare("INSERT INTO topics(topic_name, topic_description, uploaded_by_id, uploaded_by_name, cat_id) VALUES(?,?,?,?,?)");
                $stmt->execute([$name,$description,$_SESSION['user']['id'],$_SESSION['user']['username'],$_GET['category']]);
                if(!$stmt->rowCount()>0)
                {
                    $formMessage = 'Hiba ';
                }
                else
                {
                    $formMessage = 'Új téma hozzá adva. ';
                }
            } else {
                $formMessage = 'Ez a téma már létezik!';
            }
        }
        $submitted = true;
    }
    
    if(isset($con)) {

        $stmt = $con->prepare("SELECT cat_name FROM categories WHERE cat_id = ? LIMIT 1");
        $stmt->execute([$_GET['category']]);
        $cat_name = $stmt->fetch();

        echo '
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="?">Kategóriák</a></li>
                <li class="breadcrumb-item active" aria-current="page">' . anything_to_utf8($cat_name['cat_name']) . '</li>
                </ol>
            </nav>
        ';

        $result = $con->prepare("SELECT topic_name, topic_id, topic_description FROM topics WHERE cat_id = ?");
        $result->execute([$_GET['category']]);

        

        echo '
        <script src="../js/deleteTopic.js"></script>
        <table class="table table-hover table-dark">
            <tr>';
                if($admin ==true){echo '<th scope="col">id</th>';} echo '
                <th scope="col">Témák</th>
                <th scope="col">Leírás</th>';
                if($admin == true){echo '
                <th scope="col">Műveletek</th>'; }
        echo '</tr>';
        foreach ($result as $row){
            echo 
            '<tr>';
            if($admin == true) {echo '<td>' . $row['topic_id'] . '</td>';} echo '
            <td><a href="?category=' . $_GET['category'] . '&topic=' . $row['topic_id'] . '" class="table-link"><p class="mb-0">' . anything_to_utf8($row['topic_name']) . '</p></a></td>
            <td><a href="?category=' . $_GET['category'] . '&topic=' . $row['topic_id'] . '"><p class="text-muted mb-0">' . anything_to_utf8($row['topic_description']) . '</p></a></td>';
            if($admin == true){ echo '<td><button id="' . $row['topic_id'] . '" class="btn btn-link btn-sm p-0 btn-delete" onClick="reply_click(this.id)" type="button"><i class="far fa-trash-alt"></i> - Törlés</button></td>'; }
            echo '</tr>';
        }
        echo '</table>';

        if($admin == true) {
            echo '
            <button class="btn btn-link ps-0" type="button" data-bs-toggle="collapse" data-bs-target="#new-topic-form" aria-expanded="'; if($submitted == false) { echo 'false'; } else { echo 'true'; } echo '">
                Téma hozzáadása/szerkesztése <i class="fas fa-sort-down" id="topic-add-icon" style="transition: all .1s;'; if($submitted == false) { echo 'transform: rotate(90deg)'; } echo '"></i>
            </button>';
        }
        
        

        if($admin == true) { 
        echo '<div class="collapse'; if($submitted == true) { echo 'show'; } echo '" id="new-topic-form">
        <form method="post" action="" class="row mb-2" style="border-bottom: 1px solid red;">
            <h5>Téma hozzáadása</h5>
            <div class="col-md-3">
                <div class="form-floating mb-3"> 
                    <input class="form-control" type="text" name="topic_name" id="topic_name" placeholder="Cím" />
                    <label for="topic_name">Cím</label>
                </div>
            </div> 
            <div class="col-md-6">
                <div class="form-floating mb-3">
                    <input class="form-control" type="text" name="topic_description" id="topic_description" placeholder="Leírás" />
                    <label for="topic_description">Leírás</label>
                </div>
            </div>
            <div class="col-md-3 pb-3">
                    <input class="btn btn-style-1" type="submit" value="Téma hozzáadása" style="height: 100%;">
            </div>
        </form>
        <form method="post" action="" class="row">
            <h5>Téma szerkesztése</h5>
            <div class="col-md-1">
                <div class="form-floating mb-3"> 
                    <input class="form-control" type="text" name="topic_id" id="topic_id" placeholder="Id" />
                    <label for="topic_id">Id</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-floating mb-3"> 
                    <input class="form-control" type="text" name="topic_name" id="topic_name" placeholder="Cím" />
                    <label for="topic_name">Cím</label>
                </div>
            </div> 
            <div class="col-md-5">
                <div class="form-floating mb-3">
                    <input class="form-control" type="text" name="topic_description" id="topic_description" placeholder="Leírás" />
                    <label for="topic_description">Leírás</label>
                </div>
            </div>
            <div class="col-md-3 pb-3">
                    <input class="btn btn-style-1" type="submit" value="Téma szerkesztése" style="height: 100%;">
            </div>
        </form>
        <p>' . $formMessage . '</p>
        </div>

        <script type="text/javascript">
            var topicAddColl = document.getElementById("new-topic-form");
            topicAddColl.addEventListener("hide.bs.collapse", function() {
                document.getElementById("topic-add-icon").style.transform = "rotate(90deg)";
            })
            topicAddColl.addEventListener("show.bs.collapse", function() {
                document.getElementById("topic-add-icon").style.transform = "rotate(0deg)";
            })
        </script>
        ';}
    } else {
        echo '<p>Hiba a témák betöltése közben!</p>';
        
    }

    echo '
    <script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
    </script>
    ';

/**
* Convert Anything To UTF-8
* @param mixed $var The variable you want to convert.
* @param boolean $deep Deep convertion? (*Default: TRUE).
* @return mixed
*/
function anything_to_utf8($var,$deep=TRUE){
    if(is_array($var)){
        foreach($var as $key => $value){
            if($deep){
                $var[$key] = anything_to_utf8($value,$deep);
            }elseif(!is_array($value) && !is_object($value) && !mb_detect_encoding($value,'utf-8',true)){
                    $var[$key] = utf8_encode($var);
            }
        }
        return $var;
    }elseif(is_object($var)){
        foreach($var as $key => $value){
            if($deep){
                $var->$key = anything_to_utf8($value,$deep);
            }elseif(!is_array($value) && !is_object($value) && !mb_detect_encoding($value,'utf-8',true)){
                    $var->$key = utf8_encode($var);
            }
        }
        return $var;
    }else{
        return (!mb_detect_encoding($var,'utf-8',true))?utf8_encode($var):$var;
    }
}

?>