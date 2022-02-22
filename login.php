<?php

if (isset($_COOKIE['name']) && isset($_COOKIE['id'])) {
  header("location:index.php");
}
  
require "includes/init.php";


$CSRF = hash_hmac('sha256','register',$_SESSION['CSRF']);


if (isset($_POST['login-btn'])) {
  $result = $user_obj->loginUser($_POST['email'], $_POST['password'], $CSRF,$_POST['login']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="icon" href="icon/zakerxa.png">
    <title>Login</title>
    <style>
      body{
        background: rgba(75, 164, 236, 0.888);
      }
    </style>
</head>
<body>

<div id="loading" style="height:100vh;background:#fff;">
    <!-- Show Loading if Data not ready yet -->
    <div class="row d-flex align-items-center" style="height:100vh;background:#fff;z-index:100010;position:fixed;width:100vw;">
        <div class="col-12  text-center">
            <img src="assets/icon/loadingdot.webp" style="width: 200px;" alt="">
        </div>
    </div>
</div>

    <div class="container" id="login">
      <div class="row justify-content-center d-flex align-items-center" style="height:100vh">
        <div class="col-11 shadow card col-md-8 col-lg-4 text-center pt-4 pb-4" style="border-radius: 20px;">
         <h4 class="font-weight-bold pb-3">LogIn</h4>

            <div>
               <b style="letter-spacing: 1px;">
                  <?php if(isset($result['errorMessage'])){
                     echo $result['errorMessage'];
                   }?>
                </b>
             </div>

          <form action="<?=$_SERVER['PHP_SELF']?>" method="POST" class="row justify-content-center">
             <input name="login" type="hidden" value="<?=$CSRF?>">

                 <li class=" list-unstyled mt-2">
                   <div class="col-12 mt-2 form-floating ">
                      <input spellcheck="false" autocomplete="off" name="email" v-model="email" class=" pl-3 form-control" placeholder="Email" type="email" required>
                      <label><i class="fa fa-envelope text-muted" aria-hidden="true"> Email</i> </label>
                   </div>
                  </li>

                  <li class=" list-unstyled mt-2">
                   <div class="col-12 mt-2 form-floating ">
                      <input spellcheck="false" name="password" v-model="password" class=" pl-3 form-control" placeholder="Password" type="password" required>
                      <label><i class="fa fa-lock text-muted" aria-hidden="true"> Password</i> </label>

                   </div>
                  </li>

               <li class="col-12 list-unstyled mt-2 pt-3 pb-3">
                <div class="text-center">
                  <button name="login-btn"  class="btn btn-dark border-0 pt-2 pb-2 w-100 text-light" style="font-weight: bold;">LogIn</button>
                </div>
               </li>

          </form>

           <p class="pt-2">Don't have an Account? <a href="register.php" class="text-success fw-bold" style="letter-spacing: 1px;;">Register</a></p>

        </div>

      </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.11"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>



    <script>


    let app     = document.getElementById('login');
    let loading = document.getElementById('loading');


     $(document).ready(function () {
       loading.style.display = 'none';
       app.style.display = 'block';
     });


      window.addEventListener('DOMContentLoaded',()=>{
       loading.style.display = 'block';
       app.style.display = 'none';
      })
    </script>

</body>
</html>

