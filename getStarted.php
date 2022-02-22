<?php

include "includes/init.php";

if (isset($_POST['image']) && isset($_POST['city'])) {
    $direct = $_POST['image'];
    $birth = escape($_POST['birth']);
    $city = escape($_POST['city']);
    $gender = escape($_POST['gender']);

    $image_array_1 = explode(";", $direct);
    $image_array_2 = explode(",", $image_array_1[1]);

    $imgDataType = base64_decode($image_array_2[1]);

    $profile = '';
    $stmtfolder = $pdo->prepare("SELECT profile FROM users WHERE id = ?");
    $stmtfolder->execute([$id]);
    $userfolder = $stmtfolder->fetch(PDO::FETCH_ASSOC);

    if ($userfolder) {
        $profile = $userfolder['profile'];

        //  Image Path
        $path = 'QWERTYUIOPASDFGHJKLZXCVBNM123456789qwertyuiopasdfghjklzxcvbnm';
        $path = str_shuffle($path);
        $path = substr($path, 0, 20);
        $random = substr($path, 0, 10);
        $imgpath = "profile/" . $profile; //Create folder path name

        $imageName = $random . time() . '.png';

        // Create Folder and give permission
        if (!file_exists($imgpath)) {
            if (!mkdir($imgpath, 0777, true)) {
                echo "Failed to create folders...";
                die('Failed to create folders...');
            } else {
                chmod("$imgpath", 0777);
            }
        }

        file_put_contents($imgpath . '/' . $imageName, $imgDataType);

        $image_file = addslashes(file_get_contents($imgpath . '/' . $imageName));

        $dbpath = $profile.'/'.$imageName;

        $stmtGetStart = $pdo->prepare("UPDATE users SET pic = '$dbpath', birth = '$birth', city = '$city', gender = '$gender',get_start = '1' WHERE id='$id'");
        $done = $stmtGetStart->execute();

        if ($done) {

            setcookie("pic", $dbpath, time() + 60 * 60 * 24 * 7);
            echo "Done";

        } else {
            unlink($imgpath . '/' . $imageName);
            echo "Error";
        }

    }

//  $imgpath = "../profile/$profile"; //Create folder path name

}
