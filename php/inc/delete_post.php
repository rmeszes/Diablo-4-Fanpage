<?php 
    require_once 'user.php';
    require_once 'config.php';
   

    $stmt = $con->prepare("DELETE FROM posts WHERE post_id = ?");

    $stmt->execute([$_GET['id']]);
    
    return true;