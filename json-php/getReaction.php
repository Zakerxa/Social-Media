<?php

include "../includes/init.php";
include "../assets/php/tnc.php";

$userReaction = array();
$total        = array();

if (isset($_POST['token'])) {

    $token = $_POST['token'];

    $stmtCheckPost = $pdo->prepare("SELECT * FROM posts WHERE post_token = ?");
    $result        = $stmtCheckPost->execute([$token]);
    $result        = $stmtCheckPost->fetch(PDO::FETCH_ASSOC);

    if($result){
        $stmt = $pdo->prepare("SELECT users.id,users.username,users.pic,reactions.name FROM likes LEFT JOIN reactions ON reactions.rid = likes.rid_fk LEFT JOIN users ON users.id = likes.like_user_id WHERE likes.token = :token");
        $stmt->execute(
            array(':token' => $token)
        );
        $stmt->execute();
        $emoji = $stmt->fetchAll();
    
        $userReaction['total'][] = $stmt->rowCount();
    
        if ($emoji) {
            foreach ($emoji as $key => $value) {
    
                $row['username'] = $value['username'];
                $row['id'] = $value['id'];
                $row['pic'] = $value['pic'];
                $row['name'] = $value['name'];
    
                $userReaction['reaction'][] = $row;
            }
        }
    
        echo json_encode($userReaction, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
    }else{
        echo "deleted";
        exit();
    }

}else{
    header("location:../index.php");
}
