<?php 
    require_once 'user.php';
    require_once 'config.php';

    $breakpoint = 0;
    
    if(isset($con)) {

        $result = $con->query("SELECT new_name, new_description, picture, new_link FROM news ORDER BY new_date DESC LIMIT 4");

        foreach ($result as $row){
            echo '<div class="col">';
            echo '<div class="card news-card my-3 h-100 new">';
            echo '<div class="card-img-top" style="background-image: url(' . $row['picture'] . '"></div>';
            echo '<div class="card-body">';
            echo anything_to_utf8('<h5 class="card-title">' . $row['new_name'] . '</h5>');
            echo anything_to_utf8('<p class="card-text">' . $row['new_description'] . '</p>');
            echo '</div>';
            echo '<div class="card-footer">';
            echo '<a href="' . $row['new_link'] . '" class="card-link" target="_blank" rel="noopener">További infó</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
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