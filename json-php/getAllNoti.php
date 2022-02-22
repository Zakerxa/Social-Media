<?php

require "../includes/init.php";
require "../assets/php/tnc.php";

$getAllPost = array();
$getUserDetail = array();
$information = array();


if (isset($_COOKIE['id'])) {

    $stmt_getallpost = $pdo->prepare("SELECT p_id FROM posts WHERE user_id = '$id'");
    $allpost         = $stmt_getallpost->execute();
    $allpost         = $stmt_getallpost->fetchAll();

    if ($allpost) {

        foreach ($allpost as $key => $value) {
            array_push($getAllPost, $value['p_id']);
        }

        $stmt_getnoti = $pdo->prepare("SELECT * FROM noti LEFT JOIN users ON noti.user_id = users.id WHERE noti.post_token IN ( '" . implode("', '", $getAllPost) . "' ) AND users.id != '$id'");
        $result       = $stmt_getnoti->execute();
        $result       = $stmt_getnoti->fetchAll();


        if ($result) {
            
            foreach ($result as $key => $value) {

                if (!empty($value['like_token'])) {
                    switch ($value['like_token']) {
                        case 1:
                            $row['reaction'] = 'like';
                            break;
                        case 2:
                            $row['reaction'] = 'love';
                            break;
                        case 3:
                            $row['reaction'] = 'haha';
                            break;
                        case 4:
                            $row['reaction'] = 'wow';
                            break;
                        case 5:
                            $row['reaction'] = 'cool';
                            break;
                        case 6:
                            $row['reaction'] = 'confused';
                            break;
                        case 7:
                            $row['reaction'] = 'sad';
                            break;
                        case 8:
                            $row['reaction'] = 'angry';
                            break;
                        default:
                            $row['reaction'] = null;
                            # code...
                            break;
                    }
                } else {
                }

                $row['username'] = $value['username'];
                $row['pic']      = $value['pic'];
                $row['post_id']  = $value['post_token'];
                $row['seen']     = $value['seen'];

                if (empty($value['like_token'])) {
                    $row['reacted']  = null;
                    $row['comment']  = 'yes';
                } else {
                    $row['reacted']  = null;
                    $row['comment']  = 'no';
                }
                $row['time']     = timeZone($value['date_time']);

                array_push($getUserDetail, $row);
            }

            if (empty($getUserDetail)) {
                echo 'null';
            } else {
                echo json_encode($getUserDetail, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
            }
        } else {
            echo "Empty";
        }
    }
}

// $stmt_final = $pdo->prepare("SELECT * FROM users WHERE id IN ( '" . implode("', '", $getUserDetail) . "' ) AND id != '$id'");
// $finaldata  = $stmt_final->execute();
// $finaldata  = $stmt_final->fetchAll();

// foreach ($finaldata as $key => $value) {

//     print_r($value['username']);
// }
