<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="icon" href="icon/zakerxa.png">
  <!-- <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" /> -->
  <title>MM Technic</title>
</head>

<body>
  

 <?php if (!isset($_COOKIE["id"]) || !isset($_COOKIE["name"])) {?>

    <!------------------------ Navigation  ------------------------->
     <div class="navigation w-100" id="nav"></div>

     <div class="container">
        <div class="row pt-5 mt-4 mt-lg-5 justify-content-center">
          <div class="col-12 col-lg-7 text-center">
             <h2 class="p-3 p-lg-4">MM Technic Web</h2><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
            <p class="p-2" style="font-size: 18px;">
              Lorem ipsum dolor sit, amet consectetur adipisicing elit. Fugit esse nobis, delectus ipsa eius nihil nesciunt
              iusto! Magnam, veniam dolorum autem ipsa molestiae vel soluta ullam provident aliquam laborum. Nulla.
            </p>
          </div>
        </div>
    
        <div class="row pt-md-3 justify-content-center">
           <div class="col-md-4 p-3 col-12">
             <a class="text-decoration-none" href="login.php"><button class="btn btn-success w-100 text-light shadow" style="font-weight: bold;">Login</button></a>
          </div>
          <div class="col-md-4 p-3 col-12">
            <a class="text-decoration-none" href="register.php"> <button class="btn btn-info w-100 text-light shadow" style="font-weight: bold;">Created Account</button></a>
          </div>
        </div>
     </div>
 

 <?php } else {?>
   <script>
     window.location.href="home.php";
   </script>
  <?php } ?> 

  
  <script src="https://unpkg.com/vue@3.0.5"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!-- JavaScript Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="assets/js/index.js"></script>
</body>

</html>