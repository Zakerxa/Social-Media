<?php

class LikesAndComments
{

    protected $db;

    public function __construct($db_connection)
    {
        $this->db = $db_connection;
    }

    public function likes($user_id, $token,$emoji,$time)
    {

        try {

            $stmtCheckPost = $this->db->prepare("SELECT * FROM posts WHERE post_token = ?");
            $result        = $stmtCheckPost->execute([$token]);
            $result        = $stmtCheckPost->fetch(PDO::FETCH_ASSOC);

            if($result){
                $sql = "INSERT INTO `likes`(like_user_id, token,rid_fk) VALUES(?,?,?)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$user_id, $token,$emoji]);
    
                $check = $this->db->prepare("SELECT * FROM unlikes WHERE unlike_user_id = ?");
                $exist = $check->execute([$user_id]);
                $exist = $check->fetchAll(PDO::FETCH_OBJ);

                $stmtpostId = $this->db->prepare("SELECT p_id FROM posts WHERE post_token = '$token'");
                $postId     = $stmtpostId->execute();
                $postId     = $stmtpostId->fetch(PDO::FETCH_ASSOC);

                $notistmt = $this->db->prepare("INSERT INTO noti (user_id,post_token,like_token,date_time,seen,comments_id) VALUES(?,?,?,?,'','')");
                $notistmt->execute([$user_id,$postId['p_id'],$emoji,$time]);

                if ($exist) {
                    $delstmt = $this->db->prepare("DELETE FROM `unlikes` WHERE unlike_user_id = ? AND token = ?");
                    $delstmt->execute([$user_id, $token]);
                }
            }else{
                echo "deleted";
                exit();
            }

        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function updatelikes($user_id, $token,$emoji)
    {
        try {
           
            $check = $this->db->prepare("SELECT * FROM likes WHERE like_user_id = ? AND token = ?");
            $exist = $check->execute([$user_id,$token]);
            $exist = $check->fetchAll(PDO::FETCH_OBJ);

            if ($exist) {
                $updateStmt = $this->db->prepare("UPDATE likes SET rid_fk = ? WHERE token = ? AND like_user_id = ? ");
                $updateStmt->execute([$emoji, $token,$user_id]);
            }

        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    
    public function unlikes($user_id, $token)
    {

        try {
            $sql = "DELETE FROM `likes` WHERE like_user_id = ? AND token = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$user_id, $token]);

            $check = $this->db->prepare("SELECT * FROM noti WHERE user_id = ?");
            $exist = $check->execute([$user_id]);
            $exist = $check->fetchAll(PDO::FETCH_OBJ);

            if ($exist) {

                $stmtpostId = $this->db->prepare("SELECT p_id FROM posts WHERE post_token = '$token'");
                $postId     = $stmtpostId->execute();
                $postId     = $stmtpostId->fetch(PDO::FETCH_ASSOC);

                $delstmt = $this->db->prepare("DELETE FROM noti WHERE user_id = ? AND post_token = ?");
                $delstmt->execute([$user_id, $postId['p_id']]);
            }


        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function dangerlikes($user_id, $token)
    {

        try {
            $sql = "INSERT INTO `unlikes`(unlike_user_id, token) VALUES(?,?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$user_id, $token]);

            $check = $this->db->prepare("SELECT * FROM likes WHERE like_user_id = ?");
            $exist = $check->execute([$user_id]);
            $exist = $check->fetchAll(PDO::FETCH_OBJ);

            if ($exist) {
                $delstmt = $this->db->prepare("DELETE FROM`likes` WHERE like_user_id = ? AND token = ?");
                $delstmt->execute([$user_id, $token]);
            }

        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function undangerlikes($user_id, $token)
    {

        try {
            $sql = "DELETE FROM `unlikes` WHERE unlike_user_id = ? AND token = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$user_id, $token]);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function cmlikes($user_id, $token)
    {
        try {
            $sql = "INSERT INTO `comment_likes`(cm_like_user_id, cm_text_id) VALUES(?,?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$user_id, $token]);

        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function cmunlikes($user_id, $token)
    {
        try {
            $sql = "DELETE FROM `comment_likes` WHERE cm_like_user_id = ? AND cm_text_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$user_id, $token]);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function addcomments($post_id, $user_id, $content, $image, $time)
    {
        try {

            $uploadedPhoto = '';
            $path          = '';

            if (!empty($image['name'])) {

                $photoname = $image['name'];
                $tmp_name = $image['tmp_name'];
                $size = $image['size'];
                //  Image Path
                $path = 'QWERTYUIOPASDFGHJKLZXCVBNM123456789qwertyuiopasdfghjklzxcvbnm';
                $path = str_shuffle($path);
                $path = substr($path, 0, 20);
                $random = substr($path, 0, 3);
                $imgpath = "../uploads/0acommentPhoto/$path"; //Create folder path name

                // Create Folder and give permission
                if (!file_exists($imgpath)) { 
                    if (!mkdir($imgpath, 0777, true)) {
                        echo "Failed to create folders...";
                        die('Failed to create folders...');
                    } else {
                        chmod("$imgpath", 0777);
                    }
                }

                // File upload path
                $fileName = 'MMcm' . $random . basename($photoname);
                $targetFilePath = $imgpath . '/' . $fileName;

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
                        compressImage($tmp_name, 95);
                    }
                    if ($size > 1000000 && $size < 1500000) { // 1MB 1.5MB
                        compressImage($tmp_name, 80);
                    }
                    if ($size > 1500000 && $size < 2000000) { // 1MB 2MB
                        compressImage($tmp_name, 70);
                    }
                    if ($size > 2000000 && $size < 2500000) { // 2MB 3MB
                        compressImage($tmp_name, 75);
                    }
                    if ($size > 2500000 && $size < 3000000) { // 2MB 3MB
                        compressImage($tmp_name, 60);
                    }
                    if ($size > 3000000 && $size < 3500000) { // 2MB 3MB
                        compressImage($tmp_name, 50);
                    }
                    if ($size > 3500000 && $size < 4000000) { // 3MB 4MB
                        compressImage($tmp_name, 45);
                    }
                    if ($size > 4000000 && $size < 4500000) { //4MB 4.5MB
                        compressImage($tmp_name, 40);
                    }
                    if ($size > 4500000 && $size < 5000000) { //4.5MB 5MB
                        compressImage($tmp_name, 35);
                    }
                    if ($size > 5000000 && $size < 6000000) { //5MB 6MB
                        compressImage($tmp_name, 30);
                    }
                    if ($size > 6000000 && $size < 10000000) { //5MB 6MB
                        compressImage($tmp_name, 25);
                    }
                }

                // Store images on the server
                if (move_uploaded_file($tmp_name, $targetFilePath)) {
                    $uploadedPhoto = $fileName;
                }

            }else{
                $uploadedPhoto = $image;
            }

            $stmtCheckPost = $this->db->prepare("SELECT * FROM posts WHERE p_id = ?");
            $result        = $stmtCheckPost->execute([$post_id]);
            $result        = $stmtCheckPost->fetch(PDO::FETCH_ASSOC);

            if($result){
                $sql = "INSERT INTO `comments`(cm_post_id,cm_user_id,cm_content,cm_photo,cm_path,cm_created_date) VALUES(?,?,?,?,'$path',?)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$post_id, $user_id, escape($content), escape($uploadedPhoto), $time]);


                $notistmt = $this->db->prepare("INSERT INTO noti (user_id,post_token,comments_id,date_time,like_token,seen) VALUES(?,?,?,?,'',0)");
                $notistmt->execute([$user_id,$post_id,escape($content),$time]);

            }else{
                echo "deleted";
                exit();
            }


        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public function addreply($cm_id, $user_id, $content, $image, $time)
    {
        try {

            $uploadedPhoto = '';
            $path          = '';

            if (!empty($image['name'])) {

                $photoname = $image['name'];
                $tmp_name = $image['tmp_name'];
                $size = $image['size'];
                //  Image Path
                $path = 'QWERTYUIOPASDFGHJKLZXCVBNM123456789qwertyuiopasdfghjklzxcvbnm';
                $path = str_shuffle($path);
                $path = substr($path, 0, 20);
                $random = substr($path, 0, 3);
                $imgpath = "../uploads/0areplyPhoto/$path"; //Create folder path name

                // Create Folder and give permission
                if (!file_exists($imgpath)) {  
                    if (!mkdir($imgpath, 0777, true)) {
                        echo "Failed to create folders...";
                        die('Failed to create folders...');
                    } else {
                        chmod("$imgpath", 0777);
                    }
                }

                // File upload path
                $fileName = 'MMrp' . $random . basename($photoname);
                $targetFilePath = $imgpath . '/' . $fileName;

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
                        compressImage($tmp_name, 95);
                    }
                    if ($size > 1000000 && $size < 1500000) { // 1MB 1.5MB
                        compressImage($tmp_name, 80);
                    }
                    if ($size > 1500000 && $size < 2000000) { // 1MB 2MB
                        compressImage($tmp_name, 70);
                    }
                    if ($size > 2000000 && $size < 2500000) { // 2MB 3MB
                        compressImage($tmp_name, 75);
                    }
                    if ($size > 2500000 && $size < 3000000) { // 2MB 3MB
                        compressImage($tmp_name, 60);
                    }
                    if ($size > 3000000 && $size < 3500000) { // 2MB 3MB
                        compressImage($tmp_name, 50);
                    }
                    if ($size > 3500000 && $size < 4000000) { // 3MB 4MB
                        compressImage($tmp_name, 45);
                    }
                    if ($size > 4000000 && $size < 4500000) { //4MB 4.5MB
                        compressImage($tmp_name, 40);
                    }
                    if ($size > 4500000 && $size < 5000000) { //4.5MB 5MB
                        compressImage($tmp_name, 35);
                    }
                    if ($size > 5000000 && $size < 6000000) { //5MB 6MB
                        compressImage($tmp_name, 30);
                    }
                    if ($size > 6000000 && $size < 10000000) { //5MB 6MB
                        compressImage($tmp_name, 25);
                    }
                }

                // Store images on the server
                if (move_uploaded_file($tmp_name, $targetFilePath)) {
                    $uploadedPhoto = $fileName;
                }

            }else{
                $uploadedPhoto = $image;
            }

            $stmtCheckPost = $this->db->prepare("SELECT * FROM comments WHERE cm_id = ?");
            $result        = $stmtCheckPost->execute([$cm_id]);
            $result        = $stmtCheckPost->fetch(PDO::FETCH_ASSOC);

            if($result){
                $sql = "INSERT INTO `replys`(cm_id,rp_user_id,rp_content,rp_photo,rp_path,rp_created_date) VALUES(?,?,?,?,'$path',?)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$cm_id, $user_id, escape($content), escape($uploadedPhoto), $time]);
            }else{
                echo "deleted";
                exit();
            }




        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }


}
