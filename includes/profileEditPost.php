<?php

require './init.php';

if (isset($_COOKIE['id'])) {

    if (isset($_POST['content']) && isset($_POST['pid'])) {

        $pid = escape($_POST['pid']);
        $content = escape($_POST['content']);

        $stmtcheckPost = $pdo->prepare("SELECT * FROM posts WHERE p_id = :pid");
        $result = $stmtcheckPost->execute(
            array(':pid' => $pid)
        );

        $result = $stmtcheckPost->fetch(PDO::FETCH_ASSOC);

        if ($result) {

            if ($_POST['category'] == 'Default') {
                $category = $result['category'];
            } else {
                $category = escape($_POST['category']);
            }

            $stmtEditPost = $pdo->prepare("UPDATE posts SET content = '$content', category = '$category' WHERE p_id = ?");
            $Result = $stmtEditPost->execute([$pid]);
            
            if($result){
               echo "Updated";
            }else{
                echo "Error";
                exit();
            }
        }else{
            echo "There is no post";
            exit();
        }
    }
} else {
    echo "Error";
    exit();
}
