<?php

require '../init.php';


if(isset($_POST['post'])){

$post = $_POST['post'];

$stmtCheckPost = $pdo->prepare("SELECT post_id FROM saveposts WHERE user_id='$id' AND post_id = ?");
$checkresult   = $stmtCheckPost->execute([$post]);
$checkresult   = $stmtCheckPost->fetch(PDO::FETCH_ASSOC);

if($checkresult){
    $stmtsave = $pdo->prepare('DELETE FROM saveposts WHERE post_id = ?');
    $result   = $stmtsave->execute([$post]);
    if($result){
        echo "Success Remove";
    }
}else{
  echo "No Post to Delete"  ;
}
}