<?php

//Your Image
session_start();
if(isset($_POST['p'])){
    $_SESSION['profileImg'] = $_POST['p'];
}



if (isset($_SESSION['profileImg'])) {
    $imgSrc = $_SESSION['profileImg'];

    //getting the image dimensions
    list($width, $height) = getimagesize($imgSrc);
    $info = getimagesize($imgSrc);

    if ($info['mime'] == 'image/jpeg' || $info['mime'] == 'image/jpg') {
        $myImage = imagecreatefromjpeg($imgSrc);
    } elseif ($info['mime'] == 'image/gif') {
        $myImage = imagecreatefromgif($imgSrc);
    } elseif ($info['mime'] == 'image/png') {
        $myImage = imagecreatefrompng($imgSrc);
    }


    // calculating the part of the image to use for thumbnail
    if ($width > $height) {
        $y = 0;
        $x = ($width - $height) / 2;
        $smallestSide = $height;
    } else {
        $x = 0;
        $y = ($height - $width) / 2;
        $smallestSide = $width;
    }

    // copying the part into thumbnail
    $thumbSize = 200;
    $thumb = imagecreatetruecolor($thumbSize, $thumbSize);
    imagecopyresampled($thumb, $myImage, 0, 0, $x, $y, $thumbSize, $thumbSize, $smallestSide, $smallestSide);

    //final output
    header('Content-type: image/jpeg');
    imagejpeg($thumb);
}
