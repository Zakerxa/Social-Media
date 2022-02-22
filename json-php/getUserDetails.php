<?php

require "../includes/init.php";
require "../assets/php/tnc.php";

$userDetails = array();
$userPosts = array();

if (isset($_COOKIE['id'])) {

    $stmt_user = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $data = $stmt_user->execute([$id]);
    $data = $stmt_user->fetch(PDO::FETCH_ASSOC);

    $stmt_user_post = $pdo->prepare("SELECT * FROM posts LEFT JOIN users ON posts.user_id=users.id WHERE posts.user_id='$id'");
    $postData = $stmt_user_post->execute();
    $postData = $stmt_user_post->fetchAll();

    $stmt_user_fri = $pdo->prepare("SELECT * FROM friends WHERE user_one ='$id' OR user_two ='$id'");
    $userfriends   = $stmt_user_fri->execute();
    $total_fri = $stmt_user_fri->rowCount();

    if ($data) {
        $row_arr['name'] = $data['username'];
        $row_arr['phone'] = $data['phone'];
        $row_arr['country'] = $data['country'];
        $row_arr['city'] = $data['city'];
        $row_arr['pic'] = $data['pic'];
        $row_arr['birth'] = $data['birth'];
        $row_arr['cv'] = $data['cv'];
        $row_arr['bio'] = '';
        $row_arr['row'] = $data['user_row'];
        $row_arr['friends'] = $total_fri;
        $row_arr['darkmode'] = $data['dark_mode'];
        $row_arr['state'] = $data['state'];
        $row_arr['date'] = $data['createdDate'];
        $userDetails['details'][] = $row_arr;
    } else {
        echo "Error";
    }

    if ($postData) {
        foreach ($postData as $key => $value) {
            array_push($userPosts, $value);
        }
        $userDetails['post'][] = jsonArrayFormatPost($userPosts, $pdo, $id);
    } else {
        $userDetails['post'][] = null;
    }

    echo json_encode($userDetails, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
}


