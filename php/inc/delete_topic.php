<?php 
    require_once 'user.php';
    require_once 'config.php';
   
    if($_SESSION['user']['user_role'] == 1){
    $stmt = $con->prepare("DELETE FROM topics WHERE topic_id = ?");

    $stmt->execute([$_GET['id']]);
    }
    return true;