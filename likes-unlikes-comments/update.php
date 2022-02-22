<?php

require "../includes/init.php";
include "../assets/php/resize-img.php";


if($_POST['state'] == 'likes'){
  $likesunlike_obj->likes($_POST['user_id'],$_POST['token'],$_POST['emoji'],$ygntime);
}

if($_POST['state'] == 'updatelikes'){
  $likesunlike_obj->updatelikes($_POST['user_id'],$_POST['token'],$_POST['emoji']);
}

if($_POST['state'] == 'unlikes'){
  $likesunlike_obj->unlikes($_POST['user_id'],$_POST['token']);
}

if($_POST['state'] == 'dangerlikes'){
  $likesunlike_obj->dangerlikes($_POST['user_id'],$_POST['token']);
}

if($_POST['state'] == 'undangerlikes'){
  $likesunlike_obj->undangerlikes($_POST['user_id'],$_POST['token']);
}

if($_POST['state'] == 'addcomments'){

  $photo = '';
  $msg   = '';
  if(isset($_FILES["photo"])){
    $photo = $_FILES["photo"];
  }
  if(isset($_POST['gif'])){
    $photo = $_POST['gif'];
  }
  if(isset($_POST['content'])){
    $msg = $_POST['content'];
  }

  $likesunlike_obj->addcomments($_POST['post_id'],$_POST['user_id'],$msg,$photo,$ygntime);
}



if($_POST['state'] == 'reply'){
  $photo = '';
  $msg   = '';
  if(isset($_FILES["photo"])){
    $photo = $_FILES["photo"];
  }
  if(isset($_POST['gif'])){
    $photo = $_POST['gif'];
  }
  if(isset($_POST['content'])){
    $msg = $_POST['content'];
  }

  $likesunlike_obj->addreply($_POST['cm_id'],$_POST['user_id'],$msg,$photo,$ygntime);
}



if($_POST['state'] == 'cmlikes'){
  $likesunlike_obj->cmlikes($_POST['user_id'],$_POST['token']);
}

if($_POST['state'] == 'cmunlikes'){
  $likesunlike_obj->cmunlikes($_POST['user_id'],$_POST['token']);
}








// if (isset($_POST['liked'])) {
//     $postid = $_POST['postid'];
//     $result = mysqli_query($con, "SELECT * FROM posts WHERE id=$postid");
//     $row = mysqli_fetch_array($result);
//     $n = $row['likes'];

//     mysqli_query($con, "INSERT INTO likes (userid, postid) VALUES (1, $postid)");
//     mysqli_query($con, "UPDATE posts SET likes=$n+1 WHERE id=$postid");

//     echo $n+1;
//     exit();
// }



// if (isset($_POST['unliked'])) {
//     $postid = $_POST['postid'];
//     $result = mysqli_query($con, "SELECT * FROM posts WHERE id=$postid");
//     $row = mysqli_fetch_array($result);
//     $n = $row['likes'];

//     mysqli_query($con, "DELETE FROM likes WHERE postid=$postid AND userid=1");
//     mysqli_query($con, "UPDATE posts SET likes=$n-1 WHERE id=$postid");
    
//     echo $n-1;
//     exit();
// }