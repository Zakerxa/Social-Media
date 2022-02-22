<?php

require './init.php';

function Delete($path)
{
    if (is_dir($path) === true)
    {
        $files = array_diff(scandir($path), array('.', '..'));

        foreach ($files as $file)
        {
            Delete(realpath($path) . '/' . $file);
        }
        echo "Delete Folder";
        return rmdir($path);
    }

    else if (is_file($path) === true)
    {
        return unlink($path);
    }

    echo "No Folder";
    return false;
}

if (isset($_COOKIE['id'])) {

    if (isset($_POST['id'])) {

        $pid = $_POST['id'];
        $token = $_POST['token'];

        $stmtCheckPost = $pdo->prepare("SELECT * FROM posts WHERE user_id='$id' AND p_id = ?");
        $done          = $stmtCheckPost->execute([$pid]);
        $done          = $stmtCheckPost->fetch();

        $stmtDel = $pdo->prepare("DELETE FROM posts WHERE user_id='$id' AND p_id = ?");
        $del = $stmtDel->execute([$pid]);


        $stmtCheckCommentImg = $pdo->prepare("SELECT * FROM comments WHERE cm_post_id = ?");
        $commentImg          = $stmtCheckCommentImg->execute([$pid]);
        $commentImg          = $stmtCheckCommentImg->fetchAll();



        $stmtDelLike = $pdo->prepare("DELETE FROM likes WHERE token = ?");
        $delLike = $stmtDelLike->execute([$token]);

        $stmtDelDangerLike = $pdo->prepare("DELETE FROM unlikes WHERE token = ?");
        $delDangerLike = $stmtDelDangerLike->execute([$token]);

        $stmtDelComment = $pdo->prepare("DELETE FROM comments WHERE cm_post_id = ?");
        $delcomment = $stmtDelComment->execute([$pid]);


        if($commentImg){
            foreach ($commentImg as $key => $value) {
                $stmtCheckReplyImg  = $pdo->prepare("SELECT * FROM replys WHERE cm_id = ?");
                $replyImg           = $stmtCheckReplyImg->execute([$value['cm_id']]);
                $replyImg           = $stmtCheckReplyImg->fetchAll();
                if($replyImg){
                    foreach ($replyImg as $key => $row) {
                        if(!empty($row['rp_path'])){
                            Delete('../uploads/0areplyPhoto/'.$row['rp_path']);
                        }         
                    } 
                } 

                if(!empty($value['cm_path'])){
                    Delete('../uploads/0acommentPhoto/'.$value['cm_path']);
                }
                 
                $stmtDelReply = $pdo->prepare("DELETE FROM replys WHERE cm_id = ?");
                $delReply = $stmtDelReply->execute([$value['cm_id']]);
            }
        }





        if ($done && $del) {
            $path = '../uploads/'.$done['path'];
            Delete($path);
            exit();
        } else {
            echo "Delete item not found";
        }
        exit();
    }
}
