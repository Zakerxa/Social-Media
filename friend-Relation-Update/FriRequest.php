<?php

include "../includes/init.php";
include "../assets/php/resize-img.php";

if($_POST['state'] == 'accept' ){
    $fri_obj->make_friends($_POST['my_id'],$_POST['sender'],$ygntime);
}

if($_POST['state'] == 'delete'){
    $fri_obj->delete_friends($_POST['my_id'],$_POST['user_id']);
}



if($_POST['state'] == 'addfri'){
    $fri_obj->fri_request($_POST['sender'],$_POST['receiver'],$ygntime);
}

if($_POST['state'] == 'addcancle'){
    $fri_obj->cancel_friend_request($_POST['my_id'],$_POST['user_id']);
}

exit();

