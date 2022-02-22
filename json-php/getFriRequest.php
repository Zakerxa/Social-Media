<?php

include "../includes/init.php";
include "../assets/php/tnc.php";

if (!empty($id)) {
    $sql = "SELECT fr_id,username,pic,time,users.id FROM `friend_request` JOIN users ON friend_request.sender = users.id WHERE receiver = ? AND req_state=0 ORDER BY fr_id DESC LIMIT 30";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $friReq = $stmt->fetchAll(PDO::FETCH_OBJ);

// echo $stmt->rowCount();

    $allFriRequest = array();

    if ($friReq) {
        foreach ($friReq as $key => $value) {
            $row_array['name'] = $value->username;
            $row_array['fr_id'] = $value->fr_id;
            $row_array['pic'] = $value->pic;
            $row_array['time'] = timeZone($value->time);
            $row_array['id'] = $value->id;
            array_push($allFriRequest, $row_array);
        }
    } else {
        // echo $stmt->rowCount();
        $allFriRequest = null;
    }

    echo json_encode($allFriRequest);
} else {
    header("location:../index.php");
}
