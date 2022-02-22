<?php

include "../includes/init.php";
include "../assets/php/tnc.php";


if($getstarted == 0){
    echo "GET STARTED";
}else{
    
    if (isset($_POST['publicPostData']) && isset($_POST['friPostData'])) {
        $postLimit = $_POST['publicPostData'];
        $friLimit = $_POST['friPostData'];
    }else{
        header("location:../index.php");
        exit();
    }
    
    include "hightRankPost.php";

    if ($Total_Post == []) {
        print_r($Total_Post);
    } else {
        echo json_encode(jsonArrayFormatPost($Total_Post, $pdo, $id), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
    }
}


