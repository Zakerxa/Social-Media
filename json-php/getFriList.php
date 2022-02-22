<?php
include "../includes/init.php";
include "../assets/php/tnc.php";

$stmt = $pdo->prepare("SELECT * FROM friends WHERE user_one = :my_id OR user_two = :my_id");
$stmt->bindValue(':my_id',$id, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll();

$total_fri = $stmt->rowCount();

$friends = array();

if($result){
    foreach ($result as $key => $value) {
        if($value['user_one'] == $id){
            $row_array = $value['user_two'];
        }
        if($value['user_two'] == $id){
            $row_array = $value['user_one'];
        }

        array_push($friends,$row_array);
        
    }
}


array_push($friends,$id);

print_r($friends);