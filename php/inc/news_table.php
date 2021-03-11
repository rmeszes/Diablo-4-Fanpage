<?php 
    require_once 'user.php';
    require_once 'config.php';

    $breakpoint = 0;
    
    if(isset($con)) {

        $result = $con->query("SELECT new_name, new_id FROM news ORDER BY new_date DESC");
        echo<<<END
        <script src="../js/deleteNew.js"></script>
        END;
        foreach ($result as $row){
            echo 
            '<tr>
            <td class="align-middle">' . anything_to_utf8($row['new_name']) . '</td>
            <td><button id="' . anything_to_utf8($row['new_id']) . '" class="btn btn-link btn-sm p-0 btn-delete" onClick="reply_click(this.id)" type="button"><i class="far fa-trash-alt"></i> - Törlés</button></td>
            </tr>';
        }
    } else {
        echo '<p>Hiba a hírek betöltése közben!</p>';
        
    }

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