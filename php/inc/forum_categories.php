<?php 
    require_once 'user.php';
    require_once 'config.php';

    $submitted = false;
    $formMessage = "";
    if($_SERVER['REQUEST_METHOD'] == 'POST' && $admin == true) {
        $name =  filter_input(INPUT_POST, 'cat_name', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'cat_description', FILTER_SANITIZE_STRING);
        $id = filter_input(INPUT_POST, 'cat_id', FILTER_SANITIZE_STRING);
        if($id != "") {
            $stmt = $con->prepare('SELECT cat_id FROM categories WHERE cat_id = ?');
            $stmt->execute([$id]);
            if($stmt->rowCount()>0){
                $stmt = $con->prepare("UPDATE categories SET cat_name = ?, cat_description = ?, uploaded_by_id = ?, uploaded_by_name = ? WHERE cat_id = ?");
                $stmt->execute([$name,$description,$_SESSION['user']['id'],$_SESSION['user']['username'],$id]);
                if(!$stmt->rowCount()>0)
                {
                    $formMessage = 'Hiba ';
                }
                else
                {
                    $formMessage = 'Kategória sikeresen módosítva!';
                }
            }
        } elseif($name != "") {
            $stmt = $con->prepare('SELECT cat_name FROM categories WHERE cat_name = ? ');
            $stmt->execute([$name]);
            if(!$stmt->rowCount()>0) {
                $stmt = $con->prepare("INSERT INTO categories(cat_name, cat_description, uploaded_by_id, uploaded_by_name) VALUES(?,?,?,?)");
                $stmt->execute([$name,$description,$_SESSION['user']['id'],$_SESSION['user']['username']]);
                if(!$stmt->rowCount()>0)
                {
                    $formMessage = 'Hiba ';
                }
                else
                {
                    $formMessage = 'Új kategória hozzá adva. ';
                }
            } else {
                $formMessage = 'Ez a kategória már létezik!';
            }
        }
        
        $submitted = true;
    }
    
    if(isset($con)) {

        $result = $con->query("SELECT cat_name, cat_id, cat_description FROM categories");
        echo<<<END
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Kategóriák</li>
                </ol>
            </nav>
        END;
        
        echo '
        <script src="../js/deleteCat.js"></script>
        <table class="table table-hover table-dark">
            <tr>';
                if($admin ==true){echo '<th scope="col">id</th>';} echo '
                <th scope="col">Kategóriák</th>
                <th scope="col">Leírás</th>';
                if($admin == true){echo '
                <th scope="col">Műveletek</th>'; }
        echo '</tr>';
        foreach ($result as $row){
            echo 
            '<tr>';
            if($admin == true) {echo '<td>' . $row['cat_id'] . '</td>';} echo '
            <td><a href="?category=' . $row['cat_id'] . '" class="table-link"><p class="mb-0">' . anything_to_utf8($row['cat_name']) . '</p></a></td>
            <td><a href="?category=' . $row['cat_id'] . '"><p class="text-muted mb-0">' . anything_to_utf8($row['cat_description']) . '</p></a></td>';
            if($admin == true){ echo '<td><button id="' . $row['cat_id'] . '" class="btn btn-link btn-sm p-0 btn-delete" onClick="reply_click(this.id)" type="button"><i class="far fa-trash-alt"></i> - Törlés</button></td>'; }
            echo '</tr>';
        }
        echo '</table>';

        if($admin == true) {
            echo '
            <button class="btn btn-link ps-0" type="button" data-bs-toggle="collapse" data-bs-target="#new-cat-form" aria-expanded="'; if($submitted == false) { echo 'false'; } else { echo 'true'; } echo '">
                Kategória hozzáadása/szerkesztése <i class="fas fa-sort-down" id="cat-add-icon" style="transition: all .1s;'; if($submitted == false) { echo 'transform: rotate(90deg)'; } echo '"></i>
            </button>';
        }
        
        

        if($admin == true) { 
        echo '<div class="collapse'; if($submitted == true) { echo 'show'; } echo '" id="new-cat-form">
        <form method="post" action="" class="row mb-2" style="border-bottom: 1px solid red;">
            <h5>Kategória hozzáadása</h5>
            <div class="col-md-3">
                <div class="form-floating mb-3"> 
                    <input class="form-control" type="text" name="cat_name" id="cat_name" placeholder="Cím" />
                    <label for="cat_name">Cím</label>
                </div>
            </div> 
            <div class="col-md-6">
                <div class="form-floating mb-3">
                    <input class="form-control" type="text" name="cat_description" id="cat_description" placeholder="Leírás" />
                    <label for="cat_description">Leírás</label>
                </div>
            </div>
            <div class="col-md-3 pb-3">
                    <input class="btn btn-style-1" type="submit" value="Kategória hozzáadása" style="height: 100%;">
            </div>
        </form>
        <form method="post" action="" class="row">
            <h5>Kategória szerkesztése</h5>
            <div class="col-md-1">
                <div class="form-floating mb-3"> 
                    <input class="form-control" type="text" name="cat_id" id="cat_id" placeholder="Id" />
                    <label for="cat_id">Id</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-floating mb-3"> 
                    <input class="form-control" type="text" name="cat_name" id="cat_name" placeholder="Cím" />
                    <label for="cat_name">Cím</label>
                </div>
            </div> 
            <div class="col-md-5">
                <div class="form-floating mb-3">
                    <input class="form-control" type="text" name="cat_description" id="cat_description" placeholder="Leírás" />
                    <label for="cat_description">Leírás</label>
                </div>
            </div>
            <div class="col-md-3 pb-3">
                <input class="btn btn-style-1" type="submit" value="Kategória szerkesztése" style="height: 100%;">
            </div>
        </form>
        <p>' . $formMessage . '</p>
        </div>

        <script type="text/javascript">
            var catAddColl = document.getElementById("new-cat-form");
            catAddColl.addEventListener("hide.bs.collapse", function() {
                document.getElementById("cat-add-icon").style.transform = "rotate(90deg)";
            })
            catAddColl.addEventListener("show.bs.collapse", function() {
                document.getElementById("cat-add-icon").style.transform = "rotate(0deg)";
            })
        </script>
        ';}
    } else {
        echo '<p>Hiba a kategóriák betöltése közben!</p>';
        
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