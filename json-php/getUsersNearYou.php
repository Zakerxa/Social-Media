<?php

include "../includes/init.php";
include "../assets/php/tnc.php";

$getUserNearYou = array();
$pendingUserNearYou = array();

function jsonArrayFormatUser($InsertArr)
{
    $Container = array();
    foreach ($InsertArr as $key => $value) {
        $row_array['name'] = $value->username;
        $row_array['pic'] = $value->pic;
        $row_array['id'] = $value->id;
        $row_array['time'] = timeZone($value->createdTime);
        $row_array['state'] = $value->state;
        array_push($Container, $row_array);
    }
    return json_encode($Container, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
}

if (!empty($id)) {
    // Get User from friend_request to know already send or not
    // Find my id not to show sender & reveiver
    $stmt = $pdo->prepare("SELECT * FROM `friend_request` WHERE sender ='$id' || receiver ='$id'");
    $relationRow = $stmt->execute();
    $relationRow = $stmt->fetchAll(PDO::FETCH_OBJ);

    if ($relationRow) {
        foreach ($relationRow as $key => $value) {
            if ($value->sender == $id) {
                array_push($pendingUserNearYou, $value->receiver);
            }
            if ($value->receiver == $id) {
                array_push($pendingUserNearYou, $value->sender);
            }
        }
    } else {
        $pendingUserNearYou = [];
    }

// Add My Id to PendingUserNearYou Not to Show in Screen
    array_push($pendingUserNearYou, $id);

// print_r($pendingUserNearYou[$key]);

// Get All New User & Not Fri with Me
    $get_users = $pdo->prepare("SELECT username,pic,id,createdTime,state FROM `users` WHERE id NOT IN ( '" . implode("', '", $pendingUserNearYou) . "' ) AND city='$region' AND get_start=1 ORDER BY id DESC LIMIT 20");
    $allUserState1 = $get_users->execute();
    $allUserState1 = $get_users->fetchAll(PDO::FETCH_OBJ);

    if ($allUserState1) {
        foreach ($allUserState1 as $value) {
            array_push($getUserNearYou, $value);
        }
    }

// $allUsers =  $user_obj->all_users($id);

    echo jsonArrayFormatUser($getUserNearYou);
}
