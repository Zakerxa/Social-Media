<?php
include "../includes/init.php";
include "../assets/php/tnc.php";


if(isset($_POST['res'])){

  $LikeUpdate = array();

  foreach ($_POST['res'] as $key => $temporary_value) {
      // Final State Get All Post Data By ID
      $stmtFinal = $pdo->prepare("SELECT * FROM posts LEFT JOIN users ON posts.user_id = users.id WHERE posts.p_id = ?");
      $finalResult = $stmtFinal->execute([$temporary_value]);
      $finalResult = $stmtFinal->fetchAll();
      if ($finalResult) {
          foreach ($finalResult as $key => $temporary_value) {
              array_push($LikeUpdate, $temporary_value);
          }
      }
  }

  echo json_encode(jsonArrayFormatPost($LikeUpdate, $pdo, $id), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
  

}else{
  header("location:../index.php");
}