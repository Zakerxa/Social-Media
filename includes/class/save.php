<?php

require '../init.php';


if(isset($_POST['post'])){

    $post = $_POST['post'];

    if(isset($_POST['cat'])){
        $cat  = $_POST['cat'];
    }else{
     $cat = 'Public';
    }

    $stmtCheckPost = $pdo->prepare("SELECT post_id FROM saveposts WHERE user_id='$id' AND post_id = ?");
    $checkresult   = $stmtCheckPost->execute([$post]);
    $checkresult   = $stmtCheckPost->fetch(PDO::FETCH_ASSOC);

    if($checkresult){
       echo "Already Saved";
       exit();
    }else{
        $stmtsave = $pdo->prepare('INSERT INTO saveposts (user_id,post_id,s_category) VALUES(?,?,?)');
        $result   = $stmtsave->execute([$id,$post,$cat]);
        if($result){
            echo "Success Saved";
        }
    }
}






