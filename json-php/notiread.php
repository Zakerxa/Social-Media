<?php

require '../includes/init.php';

if (isset($_COOKIE['id'])) {

    $stmt = $pdo->prepare("UPDATE noti SET seen = '1'");
    $done = $stmt->execute();

    if($done){
        echo "Success";
    }
}