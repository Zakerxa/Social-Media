<?php

if (isset($_COOKIE['name']) && isset($_COOKIE['id'])) {
  header("location:index.php");
}

require "includes/init.php";

$CSRF = hash_hmac('sha256','register',$_SESSION['CSRF']);

if (isset($_POST['signup-btn'])) {

  $token    = 'QWERTYUIOPASDFGHJKLZXCVBNM0123456789';
  $token    = str_shuffle($token);
  $token    = substr($token, 0, 25);
  $result = $user_obj->singUpUser($_POST['username'],$_POST['mail'], $_POST['tel'], $_POST['pass'], $token, $ygntime,$ygndate, $CSRF ,$_POST['register']);

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
    <title>Register</title>
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

    <div class="container" id="reg">
      <div class="row justify-content-center d-flex align-items-center" style="height:100vh">
        <div class="col-11 shadow card mt-4 col-md-8 col-lg-4 text-center pt-4 pb-4" style="border-radius: 15px;">

           <form action="<?=$_SERVER['PHP_SELF']?>" method="POST" class="row justify-content-left">
               
                <div v-show="first">
                  
                  <h4 class="font-weight-bold pb-3">{{msg}}</h4>

                  <div>
                    <b style="letter-spacing: 1px;">
                       <?php if(isset($result['errorMessage'])){
                          echo $result['errorMessage'];
                        }?>
                     </b>
                  </div>

                  <li class=" list-unstyled mt-2">
                   <div class="col-12 mt-3 form-floating ">  
                      <input spellcheck="false" autocomplete="off" name="username" v-model="username" class=" pl-3 form-control" :class="namevalid" placeholder="Username" type="text" required>
                      <label><i class="fa fa-user text-muted" aria-hidden="true"> Username</i> </label>
                   </div>
                  </li>
                  
                  <li class=" list-unstyled mt-2">
                   <div class="col-12 mt-3 form-floating ">  
                      <input spellcheck="false" autocomplete="off" name="mail" v-model="email" class=" pl-3 form-control" :class="mailvalid" placeholder="Email" type="email" required>
                      <label><i class="fa fa-envelope text-muted" aria-hidden="true"> Email</i> </label>
                      <div class="form-text col-12">We'll never share your email with anyone else.</div>
                   </div>
                  </li class="list-unstyled">
                          
                  <li class="col-12 list-unstyled mt-4 pt-3 pb-3">
                    <div class="text-center">
                      <div @click="stateone()"  class="btn btn-dark  pt-2 pb-2 w-100 shadow text-light" style="font-weight: bold;">Next 
                        <i class="fa text-light fa-arrow-right" aria-hidden="true"></i>
                      </div>
                    </div>
                   </li>

               </div>

               <input name="register" type="hidden" value="<?=$CSRF?>">
                
               <div v-show="second">
                  
                 <h4 class="font-weight-bold pb-3">
                   <b @click="stateback()" class="position-absolute" style="left: 17px;">
                     <i class="fa fa-arrow-left" aria-hidden="true"></i>
                   </b>
                    <i class="fa fa-user-circle" aria-hidden="true"> {{username}} </i>
                  </h4>

                  <li class=" list-unstyled mt-2">
                   <div class="col-12 mt-3 form-floating ">  
                      <input spellcheck="false" autocomplete="off" name="tel" class=" pl-3 form-control" placeholder="Password" type="tel" required>
                      <label><i class="fa fa-phone text-muted" aria-hidden="true"> Phone</i> </label>
                   </div>
                  </li>
   

                  <li class=" list-unstyled mt-2">
                   <div class="col-12 mt-3 form-floating ">  
                      <input spellcheck="false" autocomplete="off" name="pass" class=" pl-3 form-control" placeholder="Password" type="password" required>
                      <label><i class="fa fa-lock text-muted" aria-hidden="true"> Password</i> </label>
                   </div>
                  </li>
                          
                  <li class="list-unstyled mt-3 col-10 col-lg-8">
                   <div class="form-check" :onload="load()">
                       <input v-model="agree" class="form-check-input" type="checkbox" value="" id="invalidCheck2" required>
                       <label class="form-check-label">
                         Agree to <a href="policy.html">terms and conditions</a>
                       </label>
                     </div>
                  </li>

                  <li class="col-12 list-unstyled mt-3 pt-3 pb-3">
                    <div class="text-center">
                      <button :disabled="dis" name="signup-btn"  class="btn btn-dark pt-2 pb-2 w-100 shadow text-light"  style="font-weight: bold;">Sign Up</button>
                    </div>
                   </li>

               </div>
                      
               <li class="list-unstyled mt-2 mb-2">
                 <div class="text-center">
                   <small class="text-muted">Already have an account?</small>
                   <a href="login.php" class="text-success fw-bold" style="letter-spacing: 1px;">Login</a>
                 </div>
               </li>
               
           </form>

        </div>
        
      </div>
    </div>


    <script src="assets/js/vue.min.js"></script> 
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
  
    
    <script>

    let app     = document.getElementById('reg');
    let loading = document.getElementById('loading');


    $(document).ready(function () {
       loading.style.display = 'none';
       app.style.display = 'block';

        new Vue({
          el:"#reg",
          data(){
            return{
              msg : "Create Account",
              username : '',
              email    : '',
              mailvalid: '',
              namevalid: '',
              dis    : true,
              first : true,
              second : false,
              agree    : false
            }
          },
          methods: {
            stateback(){
              this.first = true;
              this.second = false;
            },
            stateone(){

              if(this.username == '' || this.email == ''){
                
                if(this.username == ''){
                  this.namevalid = 'is-invalid';
                }

                if(this.email == ''){
                  this.mailvalid = 'is-invalid';
                }

              }else{
                if((this.username.length > 5) && this.email.endsWith('@gmail.com')){
                  this.namevalid = '';
                  this.mailvalid = '';    
                  this.first = false;
                  this.second = true;
                }else{
                  if(this.username.length <= 5 || this.username.startsWith(' ')){
                    this.namevalid = 'is-invalid';   
                  }
                  else{
                    this.namevalid = '';
                  }
                  if(!this.email.endsWith('@gmail.com')){
                    this.mailvalid = 'is-invalid';
                  }
                  else{
                    this.mailvalid = '';
                  }
                }
              }
              
            },
            load(){
              if(this.agree == true){
                this.dis = false;
              }else{
                this.dis = true;
              }
            }
          },
          mounted() {
    
          },
        })

    });

    window.addEventListener('DOMContentLoaded',()=>{
     loading.style.display = 'block';
     app.style.display = 'none';
    })


    </script>
</body>
</html>

