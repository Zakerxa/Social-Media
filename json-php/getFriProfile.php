<?php

require "../includes/init.php";
require "../assets/php/tnc.php";

$profile = array();
$posts   = array();

if(isset($_COOKIE['id'])){

    $uid = escape($_POST['pid']);
    
    $stmtUser = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $result   = $stmtUser->execute([$uid]);
    $result   = $stmtUser->fetch(PDO::FETCH_ASSOC);

    if($result){
        $row_arr['name']    = $result['username'];
        $row_arr['phone']   = $result['phone'];
        $row_arr['country'] = $result['country'];
        $row_arr['city']    = $result['city'];
        $row_arr['pic']     = $result['pic'];
        $row_arr['birth']   = $result['birth'];
        $row_arr['cv']      = $result['cv'];
        $row_arr['bio']     = $result['bio'];
        $row_arr['row']     = $result['user_row'];
        $row_arr['friends'] = $result['friends'];
        $row_arr['darkmode']= $result['dark_mode'];
        $row_arr['state']   = $result['state'];
        $row_arr['date']    = $result['createdDate'];
        $profile['info'][]  = $row_arr;
     
    }else{
        back();
    }

    $stmtCheckUser = $pdo->prepare("SELECT * FROM friends WHERE (user_one = :my_id AND user_two = :user_id) OR (user_one = :user_id AND user_two = :my_id)");
    $stmtCheckUser->bindValue(':my_id', $id, PDO::PARAM_INT);
    $stmtCheckUser->bindValue(':user_id', $uid, PDO::PARAM_INT);
    $stmtCheckUser->execute();
    $checkResult = $stmtCheckUser->fetch(PDO::FETCH_ASSOC);

    if($checkResult){
        $stmtGetPost = $pdo->prepare("SELECT * FROM posts LEFT JOIN users ON posts.user_id=users.id WHERE posts.user_id = :user_id");
        $stmtGetPost->bindValue(':user_id',$uid,PDO::PARAM_INT);
        $stmtGetPost->execute();
        $getPost   = $stmtGetPost->fetchAll();
        if($getPost){
            foreach ($getPost as $key => $value) {
               array_push($posts,$value);
            }
            $profile['post'][] = jsonArrayFormatPost($posts, $pdo, $id);
        }else{
            $profile['post'][] = null;
        }
    }else{
        $stmtGetPost = $pdo->prepare("SELECT * FROM posts LEFT JOIN users ON posts.user_id=users.id WHERE posts.user_id = :user_id AND category='Region' OR category='Anyone'");
        $stmtGetPost->bindValue(':user_id',$uid,PDO::PARAM_INT);
        $stmtGetPost->execute();
        $getPost   = $stmtGetPost->fetchAll();
        if($getPost){
            foreach ($getPost as $key => $value) {
               array_push($posts,$value);
            }
            $profile['post'][] = jsonArrayFormatPost($posts, $pdo, $id);
        }else{
            $profile['post'][] = null;
        }
    }
    

    echo json_encode($profile, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);

}else{
    echo "Unauthorise User";
    back();
}