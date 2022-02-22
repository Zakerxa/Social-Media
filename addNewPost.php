<?php

require "includes/init.php";
include "./assets/php/resize-img.php";

// $fileNames = array_filter($_FILES['images']);

if($getstarted == 0){
    echo "GET STARTED";
}else{

if (!empty(strval($_POST['content'])) && !empty($_POST['category'])) {


  if(isset($_COOKIE['id'])){
    $content = '';
    if(isset($_POST['content'])){
        $content = $_POST['content'];
    }
    
    
    $id = $_COOKIE['id'];
    $name = $_COOKIE['name'];
    $category = $_POST['category'];

    if (isset($_COOKIE['pic'])) {
      $pic = $_COOKIE['pic'];
    }

    $token = '123456789QWERTYUIOPASDFGHJKLZXCVBNM';
    $token = str_shuffle($token);
    $token = "10".substr($token, 0, 18);

    //  Image Path
    $path = 'QWERTYUIOPASDFGHJKLZXCVBNM123456789qwertyuiopasdfghjklzxcvbnm';
    $path = str_shuffle($path);
    $path = substr($path, 0, 20);
    $random = substr($path, 0, 10);
    $imgpath = "./uploads/$path"; //Create folder path name

    if (empty($_FILES['images']['name'])) {
        $uploadedFileStr = '';
    }else {

        // Create Folder and give permission
        if (!file_exists($imgpath)) {
            if (!mkdir($imgpath, 0777, true)) {
                echo "Failed to create folders...";
                die('Failed to create folders...');
            } else {
                chmod("$imgpath", 0777);
            }
        }

        $filesArr = $_FILES["images"];
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        $uploadedImage = '';


        
        foreach ($filesArr['name'] as $key => $val) {

            $image_name = $filesArr['name'][$key];
            $tmp_name = $filesArr['tmp_name'][$key];
            $size = $filesArr['size'][$key];
            $type = $filesArr['type'][$key];
            $error = $filesArr['error'][$key];

            // File upload path
            $fileName = 'MMweb' . $random . basename($image_name);
            $targetFilePath = $imgpath . '/' . $fileName;

            // Check whether file type is valid
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            if (in_array($fileType, $allowTypes)) {

                if ($size > 10000000) {
                    echo "Too much photo size,Try another one";
                    exit();
                } else {
                    if ($size > 200000 && $size < 400000) { // Greater than 200KB & less than 500KB
                        compressImage($tmp_name, 100);
                    }
                    if ($size > 400000 && $size < 500000) { // Greater than 200KB & less than 500KB
                        compressImage($tmp_name, 90);
                    }
                    if ($size > 500000 && $size < 1000000) { // 500KB 1MB
                        compressImage($tmp_name, 80);
                    }
                    if ($size > 1000000 && $size < 1500000) { // 1MB 1.5MB
                        compressImage($tmp_name, 70);
                    }
                    if ($size > 1500000 && $size < 2000000) { // 1MB 2MB
                        compressImage($tmp_name, 60);
                    }
                    if ($size > 2000000 && $size < 2500000) { // 2MB 3MB
                        compressImage($tmp_name, 50);
                    }
                    if ($size > 2500000 && $size < 3000000) { // 2MB 3MB
                        compressImage($tmp_name, 45);
                    }
                    if ($size > 3000000 && $size < 3500000) { // 2MB 3MB
                        compressImage($tmp_name, 40);
                    }
                    if ($size > 3500000 && $size < 4000000) { // 3MB 4MB
                        compressImage($tmp_name, 35);
                    }
                    if ($size > 4000000 && $size < 4500000) { //4MB 4.5MB
                        compressImage($tmp_name, 31);
                    }
                    if ($size > 4500000 && $size < 5000000) { //4.5MB 5MB
                        compressImage($tmp_name, 28);
                    }
                    if ($size > 5000000 && $size < 6000000) { //5MB 6MB
                        compressImage($tmp_name, 25);
                    }
                    if ($size > 6000000 && $size < 10000000) { //5MB 6MB
                        compressImage($tmp_name, 23);
                    }
                }

              

                // Store images on the server
                if (move_uploaded_file($tmp_name, $targetFilePath)) {
                    $uploadedImage .= $fileName . ',pa1@-@th2,';
                }

            } else {
                echo 'Only jpg,png,jpeg & gif are allowed';
            }
        }

        // Insert form data in the database
        $uploadedFileStr = trim($uploadedImage, ',pa1@-@th2,');

    }


    $msgstmt = $pdo->prepare("INSERT INTO posts(user_id,share_post,content,photo,video,link,category,path,post_token,type,region,report,created_date,modified_date) VALUE (:id,'',:content,:photo,'','',:category,:path,:token,'post','$region','',:created_date,'')");
    $resut = $msgstmt->execute(
        array(':id' => $id, ':content' => escape(strval($content)), ':photo' => $uploadedFileStr, ':category' => $category, ':path' => $path, ':token' => $token, ':created_date' => $ygntime)
    );

    if($resut){
        echo "Work";
    }else{
        echo "Error";
    }
    die();

  }

} else {
    echo "Error No Content";
}

}

die();

//  if($type == "image/jpeg" || $type == "image/png" || $type == "image/gif" || $type == "image/jpg") {
//     move_uploaded_file($tmp, "../../public_folder/user_files/$fileone");
// }else{
//     header("location: ../error.html");
// }

// $image_name = $_FILES['images']['name'];
// $tmp_name = $_FILES['images']['tmp_name'];
// $size = $_FILES['images']['size'];
// $type = $_FILES['images']['type'];

// move_uploaded_file($tmp_name, "uploads/$image_name");

