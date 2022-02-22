<?php

include "../includes/init.php";

if(isset($_POST['darkmode'])){

   if($_POST['darkmode'] == 'true'){
       $darkmode = 1;
   }
   if($_POST['darkmode'] == 'false'){
       $darkmode = 0;
   }

   $stmt   = $pdo->prepare("UPDATE users SET dark_mode = '$darkmode' WHERE id ='$id'");
   $result = $stmt->execute();

}else{
    header("location:../index.php");
}







