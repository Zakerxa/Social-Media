<?php
include "../includes/init.php";

function redirect()
{
    header("location: ../index.php");
}

$confirm = "";

if (!isset($_GET['email']) || !isset($_GET['token'])) {
   redirect();
  exit();
} else {
  $email = escape($_GET['email']);
  $token = escape($_GET['token']);

  $stmtconfirm = $pdo->prepare("SELECT * FROM users WHERE email=:email AND token=:token AND state='0'");
  $confirm_user = $stmtconfirm->execute(
    array(':email'=>$email,':token'=>$token)
  );
  $confirm_user = $stmtconfirm->fetch(PDO::FETCH_OBJ);

  if ($confirm_user) {

       //  Shuffle String 
      $path = 'QWERTYUIOPASDFGHJKLZXCVBNM123456789qwertyuiopasdfghjklzxcvbnm';
      $path = str_shuffle($path);
      $path = substr($path, 0, 20);
     
      $profileFolder = "../profile/$path"; //Create folder path name

      // Create Folder and give permission
      if (!file_exists($profileFolder)) {
        if (!mkdir($profileFolder, 0777, true)) {
            echo "Failed to create folders...";
            die('Failed to create folders...');
        } else {
            chmod("$profileFolder", 0777);
        }
      }

      $stmtGet = $pdo->prepare("UPDATE users SET state=1, token='', profile='$path' WHERE email='$email'");
      $confirmuser = $stmtGet->execute();
      if($confirmuser){
        $confirm = "Congratulations";
      }
     
  } else {
     redirect();
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../assets/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
  <link rel="icon" href="../photo/zekerxa.png">
  <title>Confirmed</title>
</head>

<body style="min-height: 100vh;">
  <div class="contianer">
    <div class="row ">
      <?php if($confirm != ''){ ?>
      <div class="modal fade pr-0" id="mailsend" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content p-1">

            <div class="modal-header">
              <h5 class="modal-title text-success" style="letter-spacing: 1px;" id="exampleModalLabel"> <i
                  class="fa fa-check-circle  fa-fw"></i>
                <?=$confirm?>
              </h5>
              <a href="../">
                <button type="button" class="btn-close" aria-label="Close"></button>
              </a>
            </div>

            <div class="modal-body d-inline-block pb-3 pt-3 p-2">

              <p class="mt-2 text-muted font-monospace">
                Your email <span class="text-primary">
                  <?=$email?>
                </span> has been confirmed.
                We will send updateds notifications to this email.
              </p>

            </div>

            <div class="modal-footer">

              <a href="../login.php">
                <button class="btn btn-success">Log In Now</button>
              </a>
            </div>

          </div>
        </div>
      </div>
      <?php } ?>

    </div>
   
  </div>


  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf"
    crossorigin="anonymous"></script>
  <script>
    var sendmail = new bootstrap.Modal(document.getElementById('mailsend'), {
      keyboard: false,
      backdrop: 'static'
    })

    sendmail.show();
  </script>

</body>

</html>