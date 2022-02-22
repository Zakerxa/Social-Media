<?php

require "../includes/init.php";
require "../assets/php/tnc.php";

$checkactivenow = date("Y-m-d h:i:s", time() - 15);
$ygntime = gmdate("Y-m-d H:i:s", (time() + $diffWithGMT) -15);

if (isset($_COOKIE['id'])) {
    $stmt = $pdo->prepare("SELECT * FROM friends WHERE user_one = :my_id OR user_two = :my_id");
    $stmt->bindValue(':my_id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll();

    $total_fri = $stmt->rowCount();

    $friends = array();

    if ($result) {
        foreach ($result as $key => $value) {
            if ($value['user_one'] == $id) {
                $row_array = $value['user_two'];
            }
            if ($value['user_two'] == $id) {
                $row_array = $value['user_one'];
            }
            array_push($friends, $row_array);
        }
    }

    $friensActive = array();
    

    if ($friends) {
        foreach ($friends as $key => $value) {
            $stmt_user = $pdo->prepare("SELECT * FROM users WHERE id='$value'");
            $result = $stmt_user->execute();
            $result = $stmt_user->fetchAll();

            if ($result) {
                foreach ($result as $key => $data) {
                    if ($ygntime <= $data['last_login']) {
                        $row_arr['status'] = "Online";
                    } else {
                        $row_arr['status'] = 'Offline';
                    }
                    $row_arr['name'] = $data['username'];
                    $row_arr['phone'] = $data['phone'];
                    $row_arr['country'] = $data['country'];
                    $row_arr['city'] = $data['city'];
                    $row_arr['pic'] = $data['pic'];
                    $row_arr['darkmode'] = $data['dark_mode'];
                    $row_arr['state'] = $data['state'];
                    $row_arr['date'] = $data['createdDate'];
                    $row_arr['ygn'] = $ygntime;
                    $row_arr['active'] = $data['last_login'];

                    array_push($friensActive, $row_arr);
                }
            }
        }
    }

    echo json_encode($friensActive, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
}
