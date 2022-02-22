<?php

include "../includes/init.php";

$stmt   = $pdo->prepare('SELECT email FROM users');
$result = $stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_OBJ); // Call Object

$return_arr = array();

if ($result) {
    foreach ($result as $key => $value) {
        $row_array['email'] = $value->email;
        array_push($return_arr, $row_array);
    }
}

echo json_encode($return_arr);





