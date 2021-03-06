<?php

if (!isset($_COOKIE['name']) && !isset($_COOKIE['id'])) {
    header("location:index.php");
    exit();
}


require "includes/init.php";


// $clientDetails = json_decode(file_get_contents("https://ipinfo.io?token=3af7306d8ea158"));

// 8caf56e414caaa
// print_r($clientDetails);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="assets/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="assets/css/custominput.css">
    <link rel="stylesheet" type="text/css" href="assets/css/comment.css">
    <link rel="stylesheet" type="text/css" href="assets/css/tooltipsterReaction.css">
    <link rel="stylesheet" type="text/css" href="assets/css/app.css">
    <!-- <link rel="stylesheet" href="slick/slick/slick-theme.css">
    <link rel="stylesheet" href="slick/slick/slick.css"> -->
    <link rel="stylesheet" href="croppie/croppie.css">
     
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="icon" href="assets/icon/zakerxa.png">
    <title>MM-Technic</title>
    <style type="text/css">
      .cr-slider-wrap{
        display: none;
      }
      #rsnoti::after{
        content: attr(data);
        padding-left: 2px;
        position: relative;
        bottom: 5px;
        background:transparent;
        color: red;
      }

      #mainoti::after{
        content: attr(data);
        padding-left: 2px;
        position: relative;
        bottom: 5px;
        background:transparent;
        color: red;
      }
      /* @media only screen and (orientation: landscape) {
        body {
          background-color: lightblue;
        }
      } */
      @media screen and (min-device-width: 300px) and (max-device-width: 360px){
        .savepostimg > img {
          width:100px;
          height: 100px;
        }
        .postImg > img {
           min-height: 30vh;
           max-height: 45vh;
        }
        .profileBg{
          height: 370px;
        }
        .cvphoto{
          height: 180px;
        }
      }
      @media screen and (min-device-width: 361px) and (max-device-width: 480px) {
        .savepostimg > img {
          width:100px;
          height: 100px;
        }
        .postImg > img {
           min-height: 30vh;
           max-height: 45vh;
        }
        .profileBg{
          height: 410px;
        }
        .cvphoto{
          height: 200px;
        }
      }
      @media screen and (min-width: 480px) {
        .savepostimg > img {
          width:140px;
          height: 140px;
        }
        .postImg > img {
          min-height: 45vh;
          max-height: 50vh;
        }
        .profileBg{
          height: 450px;
        }
        .cvphoto{
          height: 250px;
        }
      }
      @media screen and (min-width: 992px) {
        .savepostimg > img {
          width:180px;
          height: 180px;
        }
        .profileBg{
          height: 460px;
        }
      }
      /* .loader{
        display: none!important;
      } */
      
    </style>
</head>

<body style="background:#ddd">


<div id="loading" style="height:100vh;background:#fff;">
    <!-- Show Loading if Data not ready yet -->
    <div class="row d-flex align-items-center" style="height:100vh;background:#fff;z-index:100010;position:fixed;width:100vw;">
        <div class="col-12  text-center">
            <img src="assets/icon/loadingdot.webp" style="width: 200px;" alt="">
        </div>
    </div>
</div>


<div id="authuser" :onload="watching()">

    <div class="w-100 auth_nav" :style="globalColor">
        <div id="routercontainer" class="row pt-1 pb-1 justify-content-center p-0 border-bottom">

            <div  class="col-md-6 text-left pl-5 d-none d-md-block col-lg-4">
               <img src="./assets/icon/registeruser.png" style="width: 47px;height:47px;border-radius:50%;" alt="">
               <input v-model="globalsearch" type="text" class="border-0 bg-light p-2" placeholder="Search . . ." style="border-radius:20px;outline:none;padding-left:20px!important;">
               <i v-show="globalsearch.length < 1" class="fa fa-search position-relative text-muted" style="top:2px;right:35px;"></i>
            </div>

            <div @click="goHomePage('home')" :style="globalColor" class="col router active">
                <i style="font-size:18px;" class="fa fa-home"></i>
            </div>

            <div @click="goFriendsPage('friends')" :style="globalColor" class="col router">
                <i style="font-size:18px;" id="rsnoti" class=" fa fa-users"></i>
            </div>

            <div @click="goGlobalPage('global')" :style="globalColor" class="col router">
                <i style="font-size:18px;" class="fas fa-globe-europe"></i>
            </div>

            <div @click="goNotiPage('noti')" :style="globalColor" class="col router">
                <i style="font-size:18px;" id="mainoti" class="far fa-bell"></i>
            </div>

            <div @click="goProfilePage('profile')" :style="globalColor" class="col router"><i style="font-size:18px;"
                    class="fa fa-user-circle"></i>
            </div>

            <div  class="col-md-1 col-lg-4 pt-1 d-none d-md-block">

            </div>


        </div>
    </div>



    <div class="container-fluid ">

        <!-- Main Containr  -->
        <div class="row pt-5 pt-md-3 pt-lg-4 justify-content-center">

             <!-- Left Lg -->
             <div class="col-md-3 col-lg-3 pt-md-5 pt-lg-3 d-none d-md-block position-sticky" style="top:24px;height:95vh;z-index:1;">
                <!-- Add New Post -->
                <div class="row mt-lg-4" id="#">
                     <div class="card border pt-3 pb-3 " :style="globalColor">
                          <div class="p-3" :style="globalColor">
                             <h4>Account Information</h4>
                           </div>
                           <ul class="list-group list-group-flush">
                             <li class="list-group-item p-3" :style="globalColor" ><b>{{cookieName}}</b></li>
                             <li @click="savePostItems()" class="list-group-item p-3" :style="globalColor" style="cursor:pointer"><i class="fa fa-bookmark"></i> <b>Saved</b></li>


                             <li class="list-group-item p-3" :style="globalColor">
                                <p class="mb-0">
                                  <i class="fa fa-users"></i>
                                   Friends <span class="fw-bold">{{globalUser.friends}}</span>
                                </p>
                             </li>
                             
                             <li class="list-group-item p-3" :style="globalColor">
                               <p v-if="globalUser.row == 0" class="mb-0">
                                  <i class=" fa fa-star-half"></i>
                                   Normal User
                                </p>
                                <p v-if="globalUser.row == 1" class="mb-0">
                                  <i class="fa fa-star"></i>
                                   Advenced User
                                </p>
                                <p v-if="globalUser.row == 2" class="mb-0">
                                  <i class="fa fa-check-circle text-primary"></i>
                                   Pro User
                                </p>
                                <p v-if="globalUser.row == 3" class="mb-0">
                                  <i class="fa fa-check-circle"></i> 
                                  Pro User
                                </p>
                             </li>


                             <li class="list-group-item p-3" :style="globalColor" @click="dbDarkMode()" >
                                 <div class="form-check form-switch">
                                   <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" :checked="checkbtn">
                                   <label class="form-check-label" for="flexSwitchCheckDefault">Dark Mode</label>
                                 </div>
                             </li>

                             <li class="list-group-item p-3" :style="globalColor" onclick="return confirm('Are you sure you want to Logout?');"> 
                                <a href="logout.php" class="btn w-100" :style="globalColor"> 
                                <i style="padding-right: 10px;" class="fa fa-power-off text-danger" aria-hidden="true"></i> Log Out
                                </a>
                             </li>
                           </ul>
                     </div>
                 </div>
            </div>




            <!-- Home Page -->
            <div v-show="homePage" id="homePage" class="col-12 col-md-5 pt-md-5 pt-lg-3 pb-lg-4">

                <!-- Add New Post -->
                <div class="row mt-lg-3 pt-2 justify-content-center m-md-0" id="#">
                    <div class="card border pt-3 pb-3 col-12 col-lg-11" :style="globalColor">
                        <div class="row" @click="newpost">
                            <div class="col-2">
                                <img :src="'profile/'+cookiePic" class="" style="border-radius: 50px;width:45px;height:45px;"
                                    alt="">
                            </div>
                            <div class="col-9 position-relative">
                                <button 
                                    class="w-100 text-start text-muted position-absolute border-0 p-2 btn btn-light"
                                    style="left:0;top:3px;border-radius:20px;">What's on your mind?</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="row  justify-content-center m-md-0">
                  <div class="position-relative w-100 p-0"  id="slideruser" :style="globalColor">
                  <div v-for="fri in friendActive" v-if="fri.status == 'Online'" class="" :style="globalColor">
                    <img :src="'profile/'+fri.pic" :title="fri.name" style="width:45px;height:45px;border-radius:50px;" alt="">
                     <i class="fa fa-circle" style="font-size: 12px;color:#0f0;position:absolute;bottom:10px;left:45px;"></i>
                   </div>
                   <div v-for="fri in friendActive" v-if="fri.status == 'Offline'" class="d-inline-block">
                       <img :src="'profile/'+fri.pic" :title="fri.name" style="width:45px;height:45px;border-radius:50px;" alt="">       
                    </div>
                    <div v-for="fri in friendActive" v-if="fri.status == 'Offline'" class="d-inline-block">
                       <img :src="'profile/'+fri.pic" :title="fri.name" style="width:45px;height:45px;border-radius:50px;" alt="">       
                    </div>
                    
                  </div>
                </div> -->

                <!-- Show Loading if Data not ready yet -->
                <div v-if="loading" class="row justify-content-center d-flex align-items-center position-fixed w-100 m-0 p-0" style="left:0;top:0;background:#fff;height:100vh;">
                    <div class="col-12 text-center">
                        <img src="assets/icon/loading.webp" style="width: 110px;" alt="">
                    </div>
                </div>

                <div v-else>

                    <!-- Start Looping Array Container  -->
                    <div v-if="highOrderRanking != null" class="row pt-2 pb-1 mt-lg-1 justify-content-center m-md-0" v-for="(post,index) in highOrderRanking">

                        <!-- Post Type Start-->
                        <div v-if="post.type == 'post'" class="card col-12 col-lg-11" :id="'sourceslider'+index" :style="globalColor">

                          <!-- Card Body Start -->
                            <div class="card-body p-0">

                              <!-- Post Header Start -->
                                <div class="row pb-2 pt-2">
                                    <div class="col-10 position-relative">
                                        <img @click="viewprofile(post.user_id)" :src="'profile/'+post.pic" class="" style="border-radius: 50px;width:45px;height:45px;" alt="">
                                        <div style="top:0;left:62px;" class="position-absolute mb-0">
                                            <p @click="viewprofile(post.user_id)" class="d-inline" style="font-size: 15px;font-weight:500;cursor:pointer;">
                                                {{post.name}} 
                                                <i v-if="post.row == 0" class="fa fa-star-half" style="color: #FFFF00;"></i>
                                                <i v-if="post.row == 1" class="fa fa-star" style="color: #33ff22;"></i>
                                                <i v-if="post.row == 2" class="fa fa-star cf"></i>
                                                <i v-if="post.row == 3" class="fa fa-check-circle text-primary"></i>
                                              </p>
                                            <small class="text-muted d-block" style="font-size:12px;">{{post.time}}
                                                <i :class="post.category" class="fa"></i></small>
                                        </div>
                                    </div>

                                    <div class="col-2 position-relative">
                                        <div class="position-absolute w-100"
                                            style="right:10px;top:-10px;font-size: 20px;">
                                            <b class="position-absolute" style="right: 0;cursor:pointer;" @click="postsetting(post.id,post.save,post.category)"> . . .</b>
                                        </div>
                                    </div>
                                </div>

                              <!-- Post Header End -->

                              <!-- Post Content Place -->
                              <readmore-post :post="post.content.toString()" :link="post.link" :index="index" ></readmore-post>

                               <!-- View Post Modal  -->
                                <div class="modal fade p-0" :id="'readMore'+index" style="width:100vw;" :style="{'z-index': zindex},globalColor" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                        <div class="modal-content border-0" :style="globalColor">

                                          <!-- Header Modal -->
                                            <div class="modal-header p-2 pb-3 pt-0">
                                                <div class="col-10 position-relative">
                                                    <img @click="viewprofile(post.user_id)" :src="'profile/'+post.pic" style="border-radius: 50px;width:45px;height:45px" alt="">
                                                    <div style="top:0;left:62px;" class="position-absolute mb-0">
                                                        <p @click="viewprofile(post.user_id)" class="d-inline"
                                                            style="font-size: 15px;font-weight:500;cursor:pointer;">{{post.name}}
                                                        </p>
                                                        <small class="text-muted d-block"
                                                            style="font-size:12px;">{{post.time}} <i
                                                                :class="post.category" class="fa"></i></small>
                                                    </div>
                                                </div>

                                                <!-- <div class="col-2 position-relative">
                                                    <div class="position-absolute w-100"
                                                        style="right:10px;top:-25px;font-size: 20px;">
                                                        <b class="position-absolute" style="right: 0;"> . . .</b>
                                                    </div>
                                                </div> -->
                                            </div>
                                          <!-- Header End -->

                                          <!-- Modal Body -->
                                            <div class="modal-body p-1" style="min-height: 70vh;">
                                                <!-- Content And Link -->
                                                <p class="pt-3" style="white-space:pre-wrap;font-size:14px;">{{post.content.toString()}}</p>
                                                    <div v-show="post.link[0] != ''">
                                                       <a v-for="url in post.link" target="blank" class="d-block p-1" :href="url">{{url}}</a>
                                                     </div>

                                                <!-- Post All Images -->
                                                <div class=" row justify-content-center w-100 p-0 m-0" v-if="post.images[0] != ''">
                                                    <!-- Remove row element if images does't exist -->

                                                    <div v-for="(img,i) in post.images" class="col-12 col-lg-5 p-lg-4 text-center p-0 mt-3 ">
                                                        <img @click="modalImgSoloView(img)" class="img-thumbnail shadow" :id="'solo'+img" :src="'uploads/'+post.path+'/'+img"
                                                            alt="..." style="width:100%;">
                                                    </div>

                                                </div>
                                                <!-- Post Images End -->
                                            </div>
                                          <!-- Modal Body End -->

                                            <div class="modal-footer d-inline-block p-0 pt-1">
                                               <!-- Post Like and Comments -->
                                                <div class="row">

                                                     <div class="col-5 position-relative" style="padding-right:0!important;">
                                                      <!-- Like No Place -->
                                                         <span class="text-muted" style="font-size: 12px;">
                                                            <span v-if="post.reactions == 0">Be the first to Like.</span>
                                                            <span style="cursor:pointer;" @click="reactions(post.token)" v-if="(post.like_user == cookieId) && (post.reactions == 1)">
                                                               <i v-if="post.react_no[0] != 0" :class="post.react_name[0]+'IconSmall'" class="likeTypeSmall"></i>
                                                               <i v-if="post.react_no[1] != 0" :class="post.react_name[1]+'IconSmall'" class="likeTypeSmall"></i>
                                                               <i v-if="post.react_no[2] != 0" :class="post.react_name[2]+'IconSmall'" class="likeTypeSmall"></i>
                                                                You {{ cookieName }}</span>
                                                            <span style="cursor:pointer;" @click="reactions(post.token)" v-if="(post.like_user == cookieId) && (post.reactions  > 1)">
                                                               <i v-if="post.react_no[0] != 0" :class="post.react_name[0]+'IconSmall'" class="likeTypeSmall"></i>
                                                               <i v-if="post.react_no[1] != 0" :class="post.react_name[1]+'IconSmall'" class="likeTypeSmall"></i>
                                                               <i v-if="post.react_no[2] != 0" :class="post.react_name[2]+'IconSmall'" class="likeTypeSmall"></i>
                                                                You and {{ post.reactions - 1 }} others</span>
                                                            <span style="cursor:pointer;" @click="reactions(post.token)" v-if="(post.like_user != cookieId) && (post.reactions == 1)">
                                                               <i v-if="post.react_no[0] != 0" :class="post.react_name[0]+'IconSmall'" class="likeTypeSmall"></i>
                                                               <i v-if="post.react_no[1] != 0" :class="post.react_name[1]+'IconSmall'" class="likeTypeSmall"></i>
                                                               <i v-if="post.react_no[2] != 0" :class="post.react_name[2]+'IconSmall'" class="likeTypeSmall"></i>
                                                                {{ post.reactionsnc }} like</span>
                                                            <span style="cursor:pointer;" @click="reactions(post.token)" v-if="(post.like_user != cookieId) && (post.reactions > 1)">
                                                               <i v-if="post.react_no[0] != 0" :class="post.react_name[0]+'IconSmall'" class="likeTypeSmall"></i>
                                                               <i v-if="post.react_no[1] != 0" :class="post.react_name[1]+'IconSmall'" class="likeTypeSmall"></i>
                                                               <i v-if="post.react_no[2] != 0" :class="post.react_name[2]+'IconSmall'" class="likeTypeSmall"></i>
                                                                {{ post.reactionsnc }} likes</span>
                                                         </span>
                                                     </div>

                                                     <div class="col-4 position-relative p-0">
                                                      <!--Comment No Place  -->
                                                         <span v-if="post.comments == 0" class="text-muted position-absolute" style="font-size: 12px;right:0;bottom:2px;"> </span>
                                                         <span @click="showModalComments(post.id,index,post.reactions,post.unlikes,post.comments,post.like_user,post.token,post.react_name,post.react_no)" v-if="post.comments == 1" class="text-muted position-absolute" style="font-size: 12px;right:0;bottom:2px;cursor:pointer;"> {{ post.commentsnc }} Comment</span>
                                                         <span @click="showModalComments(post.id,index,post.reactions,post.unlikes,post.comments,post.like_user,post.token,post.react_name,post.react_no)" v-if="post.comments > 1" class="text-muted position-absolute" style="font-size: 12px;right:0;bottom:2px;cursor:pointer;"> {{ post.commentsnc }} Comments</span>
                                                     </div>

                                                     <div class="col-3 position-relative p-0">
                                                      <!--Unlike No Place  -->
                                                         <span v-if="post.unlikes == 0" class="text-muted position-absolute" style="font-size: 12px;right:0;bottom:2px;"></span>
                                                         <span v-if="post.unlikes > 0" class="text-muted position-absolute" style="font-size: 12px;right:0;bottom:2px;">{{ post.unlikesnc }} Unlike</span>
                                                     </div>

                                                     <!-- Like   -->
                                                    <div class="col-4 p-0">
                                                       <button :style="globalColor" v-if="post.like_user == cookieId" :id="'like'+post.token" @click="vueunlikes(post.token)" rel="unlike" class="unLike w-100 text-primary border-0" style="padding:7px 0;background:#fff;min-height:45px;">
                                                         <i :class="post.like_emoj+'IconSmall'" class="text-primary likeTypeSmall" aria-hidden="true"></i>
                                                         <span style="font-size: 12px;">{{post.like_emoji}}</span>
                                                       </button>

                                                       <button :style="globalColor" v-else  :id="'like'+post.token" rel="like" class="reaction w-100 text-muted border-0" style="padding:7px 0;background:#fff;min-height:45px;">
                                                         <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                                         <span style="font-size: 12px;">Like</span>
                                                       </button>
                                                    </div>
                                                     <!-- Comments -->
                                                    <div class="col-4 p-0">
                                                        <button :style="globalColor" @click="showModalComments(post.id,index,post.reactions,post.unlikes,post.comments,post.like_user,post.token,post.react_name,post.react_no)" class=" w-100 text-muted border-0" style="padding:7px 0;background:#fff;">
                                                          <i class="fa fa-comment" aria-hidden="true"></i>
                                                          <span style="font-size: 12px;">Comment</span>
                                                        </button>

                                                    </div>
                                                    <!-- Unlike -->
                                                    <div class="col-4 p-0 position-relative">
                                                       <button :style="globalColor" v-if="post.unlike_user == cookieId" @click="vueundangerlikes(post.token)" class=" w-100 text-danger border-0" style="padding:7px 0;background:#fff;">

                                                         <i class="fa fa-thumbs-down text-danger pl-2" aria-hidden="true" style="right: 24px; top: 13px;"></i>
                                                         <span style="font-size: 12px;"> Unlike</span>
                                                       </button>

                                                        <button :style="globalColor" v-else @click="vuedangerlikes(post.token)" class=" w-100 text-muted border-0" style="padding:7px 0;background:#fff;">

                                                         <i class="fa fa-thumbs-down text-muted pl-2" aria-hidden="true" style="right: 24px; top: 13px;"></i>
                                                         <span style="font-size: 12px;"> Unlike</span>
                                                        </button>
                                                    </div>

                                                </div>

                                               <!-- Post Like and Comments -->
                                            </div>

                                        </div>
                                    </div>
                                </div>
                               <!-- View Post Modal  -->

                             <!-- Post Content End -->

                            </div>
                          <!-- Card Body End -->

                           <!-- Post Images Place Start -->
                            <div class="row pt-2" v-if="post.images[0] != ''">

                              <div v-if="post.images.length == 1" class="position-relative w-100 p-0">
                                <div class="col-12 p-0 position-relative">
                                  <img v-for="(img,i) in post.images" @click="clickPostImg(index,post.images.length,img)" class="fullscreen w-100" :id="'image'+img" style="max-height: 75vh;" :src="'uploads/'+post.path+'/'+img" alt="...">
                                </div>
                              </div>

                              <!-- Image 2 -->
                              <div v-if="post.images.length == 2" v-for="(img,i) in post.images" class="col-6 p-0 postImg">
                                  <img @click="clickPostImg(index,post.images.length,img)" class="fullscreen w-100" :id="'image'+img" :src="'uploads/'+post.path+'/'+img" alt="...">
                              </div>

                              <!-- Image 3 -->
                              <!-- <div v-if="post.images.length == 3" v-for="(img,i) in post.images" class="col-6 p-0 postImg">
                                  <img @click="clickPostImg(index,post.images.length,img)" class="fullscreen w-100" :id="'image'+img" :src="'uploads/'+post.path+'/'+img" alt="...">
                              </div> -->
                              <!-- Image 3 -->
                              <div v-if="post.images.length == 3" class="row p-0 m-0 w-100">
                                 <div class="p-0 postImg col-6">
                                    <img @click="clickPostImg(index,post.images.length,post.images)" class="fullscreen w-100" :src="'uploads/'+post.path+'/'+post.images[0]" alt="">
                                  </div>
                                  <div class="p-0 postImg col-6 position-relative">
                                    <img @click="clickPostImg(index,post.images.length,post.images)" class="fullscreen w-100" :src="'uploads/'+post.path+'/'+post.images[1]" alt="">
                                    <div class="position-absolute" style="bottom:4%;right:6%;border-radius:50%;width:50px;height:50px;background:rgb(0, 0, 0, 0.7);">
                                       <div @click="clickPostImg(index,post.images.length,post.images)" class="justify-conent-center align-items-center d-flex h-100">
                                         <div v-if="post.images.length >= 2" class="col text-center fw-bold fs-4 text-light">+{{post.images.length - 2}}</div>
                                       </div>
                                    </div>
                                  </div>

                              </div>

                              <!-- Image 4  -->
                              <div v-if="post.images.length == 4" v-for="(img,i) in post.images" class="col-6 p-0 postImg">
                               <!-- Remove row element if images does't exist -->
                                  <img @click="clickPostImg(index,post.images.length,img)" class="fullscreen w-100" :id="'image'+img" :src="'uploads/'+post.path+'/'+img" alt="...">
                              </div>

                              <!-- Image Greater than 4 -->
                              <div v-if="post.images.length > 4" class="row p-0 m-0 w-100" @click="clickPostImg(index,post.images.length,post.images)">
                               <!-- Remove row element if images does't exist -->
                                  <div class="p-0 postImg col-6">
                                    <img class="fullscreen img-thumbnail w-100" :src="'uploads/'+post.path+'/'+post.images[0]" alt="">
                                  </div>
                                  <div class="p-0 postImg col-6">
                                    <img class="fullscreen img-thumbnail w-100" :src="'uploads/'+post.path+'/'+post.images[1]" alt="">
                                  </div>
                                  <div class="p-0 postImg col-6">
                                    <img class="fullscreen img-thumbnail w-100" :src="'uploads/'+post.path+'/'+post.images[2]" alt="">
                                  </div>
                                  <div class="p-0 postImg col-6 position-relative">
                                    <img class="fullscreen img-thumbnail w-100" :src="'uploads/'+post.path+'/'+post.images[3]" alt="">
                                    <div class="position-absolute w-100 h-100" style="top:0;background:rgb(0, 0, 0, 0.3);">
                                       <div class="justify-conent-center align-items-center d-flex h-100">
                                         <div v-if="post.images.length >= 5" class="col text-center fw-bold fs-4 text-light">+{{post.images.length - 4}}</div>
                                       </div>
                                    </div>
                                  </div>
                                  <!-- <img @click="clickPostImg(index,post.images.length,img)" class="fullscreen w-100" :id="'image'+img" :src="'uploads/'+post.path+'/'+img" alt="..."> -->
                              </div>

                              <!-- <div v-if="false" class="position-relative w-100 p-0">
                                <div :id="'slider-for'+index" class="col-12 p-0 position-relative">
                                  <img v-for="(img,i) in post.images" @click="clickPostImg(index,post.images.length,img)" class="fullscreen " :id="'image'+img" style="max-height: 75vh;" :src="'uploads/'+post.path+'/'+img" alt="...">
                                </div>

                                 <div :id="'slider-nav'+index" class="position-absolute w-100" style="bottom:0px;z-index:1001;background:rgb(125,125,125,0.2);padding:5px 0;">
                                      <img v-for="(img,i) in post.images" style="height:45px;width:45px" :src="'uploads/'+post.path+'/'+img" class="card-img-bottom  img-thumbnail rounded" alt="...">
                                 </div>
                              </div> -->

                            </div>
                           <!-- Post Images Place End -->

                            <!-- Post Like and Comments -->
                              <div class="row" :id="post.token">

                                <div class="row border-bottom pt-1 pb-1">

                                    <div class="col-5 position-relative" style="padding-right:0!important;">
                                     <!-- Like No Place -->
                                        <span class="text-muted" style="font-size: 12px;">
                                           <span v-if="post.reactions == 0">Be the first to Like.</span>
                                           <span style="cursor:pointer;" @click="reactions(post.token)" v-if="(post.like_user == cookieId) && (post.reactions == 1)">
                                              <i v-if="post.react_no[0] != 0" :class="post.react_name[0]+'IconSmall'" class="likeTypeSmall"></i>
                                              <i v-if="post.react_no[1] != 0" :class="post.react_name[1]+'IconSmall'" class="likeTypeSmall"></i>
                                              <i v-if="post.react_no[2] != 0" :class="post.react_name[2]+'IconSmall'" class="likeTypeSmall"></i>
                                               You {{ cookieName }}</span>
                                           <span style="cursor:pointer;" @click="reactions(post.token)" v-if="(post.like_user == cookieId) && (post.reactions  > 1)">
                                              <i v-if="post.react_no[0] != 0" :class="post.react_name[0]+'IconSmall'" class="likeTypeSmall"></i>
                                              <i v-if="post.react_no[1] != 0" :class="post.react_name[1]+'IconSmall'" class="likeTypeSmall"></i>
                                              <i v-if="post.react_no[2] != 0" :class="post.react_name[2]+'IconSmall'" class="likeTypeSmall"></i>
                                               You and {{ post.reactions - 1 }} others</span>
                                           <span style="cursor:pointer;" @click="reactions(post.token)" v-if="(post.like_user != cookieId) && (post.reactions == 1)">
                                              <i v-if="post.react_no[0] != 0" :class="post.react_name[0]+'IconSmall'" class="likeTypeSmall"></i>
                                              <i v-if="post.react_no[1] != 0" :class="post.react_name[1]+'IconSmall'" class="likeTypeSmall"></i>
                                              <i v-if="post.react_no[2] != 0" :class="post.react_name[2]+'IconSmall'" class="likeTypeSmall"></i>
                                               {{ post.reactionsnc }} like</span>
                                           <span style="cursor:pointer;" @click="reactions(post.token)" v-if="(post.like_user != cookieId) && (post.reactions > 1)">
                                              <i v-if="post.react_no[0] != 0" :class="post.react_name[0]+'IconSmall'" class="likeTypeSmall"></i>
                                              <i v-if="post.react_no[1] != 0" :class="post.react_name[1]+'IconSmall'" class="likeTypeSmall"></i>
                                              <i v-if="post.react_no[2] != 0" :class="post.react_name[2]+'IconSmall'" class="likeTypeSmall"></i>
                                               {{ post.reactionsnc }} likes</span>
                                        </span>
                                    </div>

                                    <div class="col-4 position-relative p-0">
                                     <!--Comment No Place  -->
                                        <span v-if="post.comments == 0" class="text-muted position-absolute" style="font-size: 12px;right:0;bottom:2px;"> </span>
                                        <span @click="showModalComments(post.id,index,post.reactions,post.unlikes,post.comments,post.like_user,post.token,post.react_name,post.react_no)" v-if="post.comments == 1" class="text-muted position-absolute" style="font-size: 12px;right:0;bottom:2px;cursor:pointer;"> {{ post.commentsnc }} Comment</span>
                                        <span @click="showModalComments(post.id,index,post.reactions,post.unlikes,post.comments,post.like_user,post.token,post.react_name,post.react_no)" v-if="post.comments > 1" class="text-muted position-absolute" style="font-size: 12px;right:0;bottom:2px;cursor:pointer;"> {{ post.commentsnc }} Comments</span>
                                    </div>

                                    <div class="col-3 position-relative p-0">
                                     <!--Unlike No Place  -->
                                        <span v-if="post.unlikes == 0" class="text-muted position-absolute" style="font-size: 12px;right:0;bottom:2px;"></span>
                                        <span v-if="post.unlikes > 0" class="text-muted position-absolute" style="font-size: 12px;right:0;bottom:2px;">{{ post.unlikesnc }} Unlike</span>
                                    </div>

                                </div>
                                <!-- Like   -->
                                <div class="col-4 p-0">
                                    <button :style="globalColor" v-if="post.like_user == cookieId" :id="'like'+post.token" @click="vueunlikes(post.token)" rel="unlike" class="unLike w-100 text-primary border-0" style="padding:7px 0;background:#fff;min-height:45px;">
                                      <i :class="post.like_emoj+'IconSmall'" class="text-primary likeTypeSmall" aria-hidden="true"></i>
                                      <span style="font-size: 12px;">{{post.like_emoji}}</span>
                                    </button>

                                    <button :style="globalColor" v-else  :id="'like'+post.token" rel="like" class="reaction w-100 text-muted border-0" style="padding:7px 0;background:#fff;min-height:45px;">
                                      <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                      <span style="font-size: 12px;">Like</span>
                                    </button>
                                </div>
                                 <!-- Comments -->
                                <div class="col-4 p-0">
                                    <button :style="globalColor" @click="showModalComments(post.id,index,post.reactions,post.unlikes,post.comments,post.like_user,post.token,post.react_name,post.react_no)" class=" w-100 text-muted border-0" style="padding:7px 0;background:#fff;">
                                      <i class="fa fa-comment" aria-hidden="true"></i>
                                      <span style="font-size: 12px;">Comment</span>
                                    </button>

                                </div>
                                <!-- Unlike -->
                                <div class="col-4 p-0 position-relative">
                                   <button :style="globalColor" v-if="post.unlike_user == cookieId" @click="vueundangerlikes(post.token)" class=" w-100 text-danger border-0" style="padding:7px 0;background:#fff;">

                                     <i class="fa fa-thumbs-down text-danger pl-2" aria-hidden="true" style="right: 24px; top: 13px;"></i>
                                     <span style="font-size: 12px;"> Unlike</span>
                                   </button>

                                    <button :style="globalColor" v-else @click="vuedangerlikes(post.token)" class=" w-100 text-muted border-0" style="padding:7px 0;background:#fff;">

                                     <i class="fa fa-thumbs-down text-muted pl-2" aria-hidden="true" style="right: 24px; top: 13px;"></i>
                                     <span style="font-size: 12px;"> Unlike</span>
                                    </button>
                                </div>

                              </div>
                            <!-- Post Like and Comments End -->


                              <!-- Ranking Comment One Place -->
                                <div class="row" v-if="post.comments > 0 && post.cm_user_id != cookieId">
                                    <div @click="viewprofile(post.cm_user_id)" class="col-12 border-bottom pt-2 pb-3" :style="globalColor">
                                       <img :src="'profile/'+post.cm_user_pic"  class="position-absolute mb-0" style="border-radius: 50px;width:35px;height:35px;bottom:20;left:10px;" alt="">

                                      <div class="pl-3  position-relative w-75 text-left" style="min-height:10px;left:40px;top:0;border-radius:10px;text-align:left;" :style="globalComment">
                                          <p class="d-inline-block m-0" style="font-size: 15px;font-weight:500;padding-top:5px!important;padding-left:10px!important;"> {{post.cm_user_name}} </p>

                                          <div @click="readmore = !readmore" class="p-2" data-bs-toggle="collapse" data-bs-target="#collapseExample" style="white-space:pre-wrap;padding-top:0!important;font-size:14px;">{{post.cm_user_content.toString().substr(0, 100)}}<span class="collapse" id="collapseExample" data-parent="#accordion">{{post.cm_user_content.toString().substr(100)}}
                                              </span>
                                             <span class="text-muted" v-if="post.cm_user_content.length > 135 && readmore"> ...See More</span>
                                          </div>

                                      </div>

                                        <div v-if="post.cm_user_check_photo != ''" >
                                          <img v-if="post.cm_user_photo.includes('giphy.com')" :src="post.cm_user_check_photo" class="position-relative mb-0" style="border-radius: 10px;height:100px;bottom:0px;left:41px;" alt="">
                                           <img v-else :src="post.cm_user_photo" class="position-relative mb-0" style="border-radius: 10px;height:100px;bottom:0px;left:41px;" alt="">
                                        </div>
                                        <!-- footer -->
                                        <div class="row justify-content-right pt-1">
                                             <div class="col-2 col-md-1"></div>
                                             <div class="col-2 col-md-1 p-0 small text-muted">
                                                 {{post.cm_user_time}}
                                             </div>

                                             <div v-if="post.cm_likes == 0" class="col-3 col-md-2"></div>
                                             <div v-if="post.cm_likes > 0" class="col-3 col-md-2 small text-muted"><i class="fa text-primary fa-thumbs-up"> {{post.cm_likes}}</i></div>
                                             <div class="col-1 col-md-4"></div>
                                        </div>
                                        <!-- footer end -->

                                    </div>
                                </div>
                              <!-- Ranking Comment One Place -->



                        </div>
                        <!-- Post Type End -->

                        <!-- Blog Type Start-->
                        <div v-if="post.type == 'blog'" class="card col-lg-6">
                            <h3>This is Blog Post</h3>
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Animi quibusdam
                                reprehenderit dicta quas consequuntur nobis perspiciatis rerum delectus voluptas
                                voluptates aliquid hic quidem impedit officiis, aspernatur totam accusamus soluta
                                eos?
                            </p>
                        </div>
                        <!-- Blog Type End -->

                        <!-- Share Type Start-->
                        <div v-if="post.type == 'share'" class="card col-lg-6">
                            <h3>This is Share Post</h3>
                            <p>
                                Lorem ipsum dolor sit, amet consectetur adipisicing elit. Velit iste animi nobis
                                explicabo, necessitatibus et culpa? Sequi, accusamus? Laudantium sunt possimus
                                voluptate amet. Aperiam quaerat, cupiditate corrupti consectetur ipsa quod?
                            </p>
                        </div>
                        <!-- Share Type End -->

                    </div>

                    <!-- Show Loading if Data not ready yet -->
                    <scroll-loader v-if="highOrderRanking != null" :loader-method="postLoadMore" :loader-enable="scrollLoadMore">
                      <!-- <div v-if="postMoreLoading" class="row pt-2" style="height:50px;z-index:100000">
                          <div class="col-12 text-center">
                             <i class="fa fa-spinner fa-pulse fa-fw"></i>
                          </div>
                      </div> -->
                   </scroll-loader>


                    <div v-if="noMorePost" class="row pt-1" style="height:6vh;z-index:100000">
                        <div class="col-12 text-center">
                           <small class="text-muted" style="font-size: 13px;">No more post . . .</small>
                        </div>
                    </div>

                    <div v-if="highOrderRanking == null" class="row justify-content-center">

                      <div class="card col-12 col-lg-11  p-0 mt-3" :style="globalColor">
                         <div class="card-body text-center">
                         <i class="fa fa-2x fa-unlock-alt" aria-hidden="true"></i>
                         <h5 class="card-title p-2">There is no post right now.</h5>
                           <p class="card-text" style="letter-spacing: 1px;">Please setup your information first.We will decided which post is better for you. </p>
                         </div>
                       </div>

                       <div class="card border-0 row justify-content-center p-0 mt-3" style="background-color: transparent;" >
                         <div class="card-body text-center">
                         <i class="fa fa-2x fa-handshake text-primary" aria-hidden="true"></i>
                           <h5 class="card-title p-2">Welcome to MM-Technic!</h5>
                           <p class="card-text">Add a profile picture so your friends know it's you </p>

                           <div class="">
                             <button @click="getstarted()" class="btn btn-primary fw-bold font-monospace">GET STARTED</button>
                           </div>
                         </div>
                       </div>

                    </div>

                </div>

            </div>

            <!-- Relation Page -->
            <div v-show="relationPage" class="col-12 col-md-5 pt-md-5 pt-lg-3 pb-5">

                <div class="row pt-2 mt-lg-3 pl-1 m-md-0">
                    <div class="card border pt-3 pb-3" :style="globalColor">
                       <h2 class="m-0" style="font-weight:bold">Friends</h2>
                    </div>

                </div>

                <div v-if="getuserloading" class="row justify-content-center d-flex align-items-center m-md-0 "
                    style="height:100vh;background: #fff;">
                    <div class="col-12 text-center">
                        <img src="assets/icon/loadingdot.webp" style="width: 150px;" alt="">
                    </div>
                </div>

                <div v-else class="row pb-5 m-md-0">

                    <!-- SHOW FRIEND REQUEST START -->
                    <div class="col-12" v-if="allDynamicFriRequest.length != 0" :style="globalColor">
                        <h5 class="pb-3 pt-3">Friend Request <span
                                class="text-success">{{ allDynamicFriRequest.length }}</span></h5>

                        <!-- FRIEND REQUEST LIST -->
                        <div class="row">
                            <div v-for="(friReqUser,index) in allDynamicFriRequest"  :id="'frierequser'+friReqUser.id" class="col-12 text-left d-inline-block position-relative p-0"
                                style="min-height:100px;" :style="globalColor">

                                <img :src="'profile/'+friReqUser.pic" class="position-absolute mb-0"
                                    style="border-radius: 50px;width:77px;height:77px;top:0;left:5px;" alt="">

                                <div style="top:0;left:90px;height:40px;" class="position-absolute mb-0">
                                    <p class="d-inline pb-1" style="font-size: 16px;font-weight:600;">
                                        {{friReqUser.name}}</p>
                                </div>

                                <p style="top:0;right:20px;" class="position-absolute text-muted mb-0">
                                    {{friReqUser.time}}</p>

                                <accept-btn v-on:updated="friRelation" :globalComment="globalComment" :key="friReqUser.id" :id="<?=$_COOKIE['id']?>"
                                    :container="allDynamicFriRequest" :requser="friReqUser">
                                </accept-btn>

                            </div>
                        </div>
                        <!-- FRIEND REQUEST LIST -->

                    </div>
                    <!-- SHOW FRIEND REQUEST END -->


                    <!-- SHOW FRIEND NEAR YOU START -->
                    <div class="col-12" v-if="allDynamicNearYou.length != 0" :style="globalColor">
                        <h5 class="pb-3 pt-3">Friends Near You </h5>
                        <!-- FRIEND REQUEST LIST -->
                        <div class="row">

                            <div v-for="(users,index) in allDynamicNearYou" :id="'newuserslider'+users.id"
                                class="col-12 text-left d-inline-block position-relative p-0"
                                style="min-height:100px;">

                                <img :src="'profile/'+users.pic" class="position-absolute mb-0"
                                    style="border-radius: 50px;width:77px;height:77px;top:0;left:5px;" alt="">

                                <div style="top:0;left:90px;max-height:20px;" class="position-absolute mb-0">
                                    <p class="d-inline pb-1" style="font-size: 16px;font-weight:600;">{{users.name}}
                                    </p>
                                </div>

                                <p style="top:0;right:20px;" class="position-absolute text-muted mb-0">
                                    {{users.time}}</p>

                                <request-btn v-on:remove="removeuser" :globalComment="globalComment" v-bind:key="users.id" v-bind:id="cookieId"
                                    v-bind:container="allDynamicNearYou" v-bind:users="users">
                                </request-btn>


                            </div>

                        </div>
                        <!-- FRIEND REQUEST LIST -->


                    </div>
                    <!-- SHOW FRIEND NEAR YOU END -->


                    <!-- SHOW NEW USERS START -->
                    <div class="col-12" v-if="allDynamicNewUsers.length != 0" :style="globalColor">
                        <h5 class="pb-3 pt-3">New User</h5>
                        <!-- FRIEND REQUEST LIST -->
                        <div class="row">
                            <div v-for="(users,index) in allDynamicNewUsers" :id="'newuserslider'+users.id"
                                class="col-12 text-left d-inline-block position-relative p-0"
                                style="min-height:100px;">

                                <img :src="'profile/'+users.pic" class="position-absolute mb-0"
                                    style="border-radius: 50px;width:77px;height:77px;top:0;left:5px;" alt="">

                                <div style="top:0;left:90px;max-height:20px;" class="position-absolute mb-0">
                                    <p class="d-inline pb-1" style="font-size: 16px;font-weight:600;">{{users.name}}
                                    </p>
                                </div>

                                <p style="top:0;right:20px;" class="position-absolute text-muted mb-0">
                                    {{users.time}}</p>

                                <request-btn v-on:remove="removeuser" :globalComment="globalComment" v-bind:key="users.id" v-bind:id="<?=$_COOKIE['id']?>"
                                    v-bind:container="allDynamicNewUsers" v-bind:users="users">
                                </request-btn>


                            </div>
                        </div>
                        <!-- FRIEND REQUEST LIST -->


                    </div>
                    <!-- SHOW NEW USERS END -->


                </div>

            </div>

            <!-- Global Page -->
            <div v-show="globalPage" class="col-12 col-md-5 pt-md-5 pt-lg-3 pb-5">

               <div class="row pt-2 mt-lg-3  pl-1">
                    <div class="card border pt-3 pb-3" :style="globalColor">
                       <h3 class="m-0" style="font-weight:bold">Not Ready Yet</h3>
                    </div>

                </div>

                <div v-if="getuserloading" class="row justify-content-center d-flex align-items-center" style="height:93vh;background: #fff;">
                    <div class="col-12 text-center">
                        <img src="assets/icon/loadingdot.webp" class="w-25" alt="">
                    </div>
                </div>

                <div v-else class="row pb-5">
                  <div class="col">
                   
                     <h2 class="pt-4 pb-4">Coming Soon</h2>

                     <p>
                     Lorem ipsum dolor sit, amet consectetur adipisicing elit. Consequatur porro quos quibusdam
                     reprehenderit dolore, earum asperiores eaque atque corrupti sed ratione ipsam, itaque doloribus!
                     Consectetur praesentium dolores velit saepe ducimus.
                     </p>

                     <p>
                     Lorem ipsum dolor sit, amet consectetur adipisicing elit. Consequatur porro quos quibusdam
                     reprehenderit dolore, earum asperiores eaque atque corrupti sed ratione ipsam, itaque doloribus!
                     Consectetur praesentium dolores velit saepe ducimus.
                     </p>
                  </div>
                </div>

            </div>

            <!-- Notification Page -->
            <div v-show="notiPage" class="col-12 col-md-5 pt-md-5  pt-lg-3 pb-5">
                 <div class="row pt-2 mt-lg-3  pl-1">
                     <div class="card border pt-3 pb-3" :style="globalColor">
                        <h3 class="m-0" style="font-weight:bold">Notifications</h3>
                     </div>

                 </div>

                 <div v-if="notiContainer == null" class="row justify-content-center d-flex align-items-center" style="height:83vh;background: #fff;">
                      <div class="col-12 text-center text-muted pb-5 mb-5">
                        <i class="far fa-bell fa-2x pb-2 d-block" aria-hidden="true"></i>
                          <h7 class="pb-1">There is no notification</h7>
                      </div>
                 </div>

                 <div v-else class="row pb-5 pt-3" :style="globalColor">
                        <div v-for="(users,index) in notiContainer" :id="'newuserslider'+users.id" class="col-12 text-left d-inline-block position-relative p-0" style="min-height:90px;">

                           <img :src="'profile/'+users.pic" class="position-absolute mb-0"
                               style="border-radius: 50px;width:57px;height:57px;top:0;left:5px;" alt=""> 

                           <div v-if="users.reacted == 'yes'" @click="globalViewPostModal(users.post_id)" style="top:0;left:75px;max-height:20px;" class="position-absolute mb-0">
                               <p class="d-inline pb-1" style="font-size: 16px;font-weight:600;">{{users.username}}
                               </p><span> reacted to your post.</span>
                               <p style="bottom:0;right:10px;font-size:small" class=" text-muted mb-0">
                               <i :class="users.reaction+'IconSmall'" class="likeTypeSmall"></i> {{users.time}}</p>
                           </div> 

                           <div v-if="users.comment == 'yes'" @click="globalViewPostModal(users.post_id)" style="top:0;left:75px;max-height:20px;" class="position-absolute mb-0">
                               <p class="d-inline pb-1" style="font-size: 16px;font-weight:600;">{{users.username}}
                               </p><span> comment on your post.</span>
                               <p style="bottom:0;right:10px;font-size:small" class=" text-muted mb-0">
                               <i class="fas fa-comment" class="likeTypeSmall"></i> {{users.time}}</p>
                           </div>
                            
                        </div>
                 </div>
            </div>

            <!-- Profile Page -->
            <div v-show="profilePage" class="col-12 col-md-5 pt-md-5 pt-lg-3 ">

                 <div v-if="getuserloading"  class="mt-2">
                   <div class="row justify-content-center d-flex align-items-center m-md-0" style="height:93vh;background: #fff;">
                       <div class="col-12 text-center">
                           <img src="assets/icon/loadingdot.webp" class="w-25" alt="">
                       </div>
                   </div>
                 </div>


                 <div v-else class="pt-2 mt-lg-3 pl-1 justify-content-center"> 

                    <div class="row profileBg position-relative m-md-0" :style="globalColor">
   
                      <div class="col-12 pt-2 card border-0" :style="globalColor">
                      
                          <img v-if="globalUser.cv != ''" :src="'profile/'+globalUser.cv" class="card-img-top pt-1 img-thumbnail cvphoto"  alt="">
                          <img v-if="globalUser.cv == ''" src="profile/cp.jpg" class="card-img-top pt-1 img-thumbnail cvphoto"  alt="">

                          <div id="image_profile" class="text-center position-relative text-center" style="bottom: 100px;">
                             <div class="col-6 text-center d-inline-block col-md-5 col-lg-4" style="background:transparent">
                               <img :src="'profile/'+globalUser.pic" class="bg-light w-100 img-thumbnail" style="border-radius: 50%;" alt="">
                             </div>
                             <p class="fs-4 fw-bold text-center mt-2">
                               <i v-if="globalUser.row == 0" class="fa fa-star-half" style="color: #FFFF00;"></i>
                               <i v-if="globalUser.row == 1" class="fa fa-star" style="color: #33ff22;"></i>
                               <i v-if="globalUser.row == 2" class="fa fa-star cf"></i>
                               <i v-if="globalUser.row == 3" class="fa fa-check-circle text-primary"></i>
                                {{globalUser.name}}
                              </p>  
                             <p v-if="globalUser.bio == ''" class="fs-7 text-center text-center">This User is lazy to write something</p>  
                             <p v-else class="fs-7 text-center">{{globalUser.bio}}</p>  
                          </div>
                      </div>
                     
                    </div>

                    <div class="row position-relative p-2 m-md-0" :style="globalColor">

                      <p class="col-6 small p-1">
                        <i class="fa fa-home"></i>
                         Country <span class="fw-bold">Myanmar</span>
                      </p>
                      <p class="col-6 small p-1">
                        <i class="fa fa-street-view"></i>
                         Lives in <span class="fw-bold">{{globalUser.city}}</span>
                      </p>
                      <p class="col-6 small p-1">
                        <i class="fa fa-users"></i>
                         Friends <span class="fw-bold">{{globalUser.friends}}</span>
                      </p>
                      <p v-if="globalUser.row == 0" class="col-6 small p-1">
                        <i class=" fa fa-star-half"></i>
                         Normal User
                      </p>
                      <p v-if="globalUser.row == 1" class="col-6 small p-1">
                        <i class="fa fa-star"></i>
                         Advenced User
                      </p>
                      <p v-if="globalUser.row == 2" class="col-6 small p-1">
                        <i class="fa fa-check-circle text-primary"></i>
                         Pro User
                      </p>
                      <p v-if="globalUser.row == 3" class="col-6 small p-1">
                        <i class="fa fa-check-circle"></i> 
                        Pro User
                      </p>
                      <p class="col-6 small p-1">
                        <i class="fa fa-calendar"></i> 
                        Birth <span class="fw-bold">{{globalUser.birth}}</span>
                      </p>
                      <p class="col-6 small p-1">
                        <i class="fa fa-clock"></i> 
                        Joined <span class="fw-bold">{{globalUser.date}}</span>
                      </p>
                      
                    </div>

                    <div class="row p-2 mt-2 mt-lg-3 mb-2 m-md-0" :style="globalColor">
                      <div class="col small" >
                          <div @click="profileSettingShow=false;profilePostShow=true;profileUpgradeShow=false;profileActive1='active';profileActive2='';profileActive3=''" :class="profileActive1" :style="globalColor" class="w-100 pt-3 pb-3 fa fa-edit"> Posts </div>
                        </div>
  
                        <div class="col small" >
                          <div @click="profileSettingShow=false;profilePostShow=false;profileUpgradeShow=true;profileActive1='';profileActive2='active';profileActive3=''" :class="profileActive2" :style="globalColor" class="w-100 pt-3 pb-3 fa fa-suitcase"> Upgrade</div>
                        </div>
  
                        <div class="col small" >
                          <div @click="profileSettingShow=true;profilePostShow=false;profileUpgradeShow=false;profileActive1='';profileActive2='';profileActive3='active'" :class="profileActive3" :style="globalColor" class="w-100 pt-3 pb-3 fa fa-cog"> Settings</div>
                        </div>
                    </div>


                    <div v-if="profileSettingShow" class="">

                        <div class="row mt-2 justify-content-left m-md-0" :style="globalColor">

                          <div class="fw-bold text-center  p-3 border-top border-bottom">Settings and privacy</div>

                          <!-- FEATURN -->
                          <div class="fs-6 pt-3 pb-1 text-muted">FEATURE</div>


                          <div class="mt-2 col-11 text-start p-3" style="border-radius: 8px;" :style="globalColor">
                            <div  @click="dbDarkMode()" class="form-check form-switch text-start">
                              <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" :checked="checkbtn">
                              <label class="form-check-label" for="flexSwitchCheckDefault">Dark Mode</label>
                            </div>
                          </div>


                          <div class="fs-6 pt-3 pb-1 text-muted">POST</div>

                          <div class="mt-2 col-11 p-2 text-start" style="border-radius: 8px;" :style="globalColor">
                            <div class="p-2" @click="savePostItems()">
                              <i style="padding-right: 10px;" class="fa fa-bookmark text-muted"></i> Saved
                            </div>
                          </div>


                          <div class="fs-6 pt-3 pb-1 text-muted">ACCOUNT</div>

                          <div class="mt-2 col-11 p-2 text-start" style="border-radius: 8px;" :style="globalColor">
                            <div class="p-2">
                              <i style="padding-right: 10px;" class="fa text-muted fa-user-circle"></i> Personal Information
                            </div>
                          </div>

                          <div class="mt-2 col-11 p-2 text-start" style="border-radius: 8px;" :style="globalColor">
                            <div class="p-2">
                              <i style="padding-right: 10px;" class="fa text-muted fa-key"></i> Change Password
                            </div>
                          </div>

                          <div class="mt-2 col-11 p-2 text-start" style="border-radius: 8px;" :style="globalColor">
                            <div class="p-2">
                              <i style="padding-right: 10px;" class="fa text-muted fa-user-times"></i> Blocking
                            </div>
                          </div>

                          <div class="mt-2 col-11 p-2 text-start" style="border-radius: 8px;" :style="globalColor">
                            <div class="p-2">
                              <i style="padding-right: 10px;" class="fa text-muted fa-comment"></i> Active Status
                            </div>
                          </div>

                          <!-- BALANCE -->
                          <div class="fs-6 pt-3 pb-1 text-muted">BALANCE</div>

                          <div class="mt-2 col-11 p-2 text-start" style="border-radius: 8px;" :style="globalColor">
                            <div class="p-2">
                              <i style="padding-right: 10px;" class="fa text-warning fa-database"></i> Coins
                            </div>
                          </div>


                          <div class="fs-6 pt-3 pb-1 text-muted">SUPPORT</div>

                          <div class="mt-2 col-11 p-2 text-start" style="border-radius: 8px;" :style="globalColor">
                             <div class="p-2">
                               <i style="padding-right: 10px;" class="fa text-muted fa-exclamation-circle"></i> Report a Problem
                             </div>
                          </div>


                          <div class="mt-2 col-11 p-2 text-start" style="border-radius: 8px;" :style="globalColor">
                             <div class="p-2">
                               <i style="padding-right: 10px;" class="fa text-muted fa-question-circle"></i> Help Center
                             </div>
                          </div>


                          <div class="fs-6 pt-3 pb-1 text-muted">ABOUT</div>

                          <div class="mt-2 col-11 p-2 text-start" style="border-radius: 8px;" :style="globalColor">
                            <div class="p-2">
                              <i style="padding-right: 10px;" class="fa text-muted fa-lock"></i> Terms & Policies
                            </div>
                          </div>


                          <div class="col-12 d-lg-none p-2 border-top" :style="globalColor">
                             <a href="logout.php" onclick="return confirm('Are you sure you want to Logout?');" class="btn w-100" :style="globalColor"> 
                             <i style="padding-right: 10px;" class="fa fa-power-off text-danger" aria-hidden="true"></i> Log Out
                             </a>
                          </div>

                        </div>
                    </div>

                    <div v-if="profileUpgradeShow" class="">
                      <div class="row mt-2 justify-content-left m-md-0" :style="globalColor">
                        <p class="p-3">
                          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam quo odio ut ex similique, error hic atque. Id vel ut modi voluptas earum, iste nobis? Voluptatem ratione fuga architecto eaque.
                        </p>
                      </div>
                    </div>

                     <div v-if="profilePostShow">
                          <!-- Add New Post -->
                          <div class="row mt-lg-3 m-md-0" id="#">
                              <div class="card border pt-3 pb-3" :style="globalColor">
                                  <div class="row" @click="newpost">
                                      <div class="col-2">
                                          <img :src="'profile/'+cookiePic" class="" style="border-radius: 50px;width:45px;height:45px;"
                                              alt="">
                                      </div>
                                      <div class="col-9 position-relative">
                                          <button 
                                              class="w-100 text-start text-muted position-absolute border-0 p-2 btn btn-light"
                                              style="left:0;top:3px;border-radius:20px;">What's on your mind?</button>
                                      </div>
                                  </div>
                              </div>
                          </div>

                          <!-- Start Looping Array Container  -->
                          <div v-if="globalUserPost[0] != null" class="row pt-2 pb-1 mt-lg-1 m-md-0" v-for="(post,index) in globalUserPost[0]">
      
                              <!-- Post Type Start-->
                              <div v-if="post.type == 'post'" class="card" :id="'sourceslider'+index" :style="globalColor">
      
                                <!-- Card Body Start -->
                                  <div class="card-body p-0">
      
                                    <!-- Post Header Start -->
                                      <div class="row pb-2 pt-2">
                                          <div class="col-10 position-relative">
                                              <img :src="'profile/'+post.pic" class="" style="border-radius: 50px;width:45px;height:45px;" alt="">
                                              <div style="top:0;left:62px;" class="position-absolute mb-0">
                                                  <p class="d-inline" style="font-size: 15px;font-weight:500;cursor:pointer;">
                                                      {{post.name}}</p>
                                                  <small class="text-muted d-block" style="font-size:12px;">{{post.time}}
                                                      <i :class="post.category" class="fa"></i></small>
                                              </div>
                                          </div>
      
                                          <div class="col-2 position-relative">
                                            <b @click="profilePostSettingF(post.id)" id="dropdownMenuButton1" style="right: 0;cursor:pointer;" >. . .</b> 
                                          </div>
                                      </div>
      
                                    <!-- Post Header End -->

                                    <!-- Post Content Place -->
                                    <readmore-post :post="post.content.toString()" :link="post.link" :index="index+'profile'" ></readmore-post>
      
                                     <!-- View Post Modal  -->
                                   <div class="modal fade p-0" :id="'readMore'+index+'profileview'" style="width:100vw;" :style="{'z-index': zindex},globalColor" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                        <div class="modal-content border-0" :style="globalColor">

                                          <!-- Header Modal -->
                                            <div class="modal-header p-2 pb-3 pt-0">
                                                <div class="col-10 position-relative">
                                                    <img @click="viewprofile(post.user_id)" :src="'profile/'+post.pic" style="border-radius: 50px;width:45px;height:45px" alt="">
                                                    <div style="top:0;left:62px;" class="position-absolute mb-0">
                                                        <p @click="viewprofile(post.user_id)" class="d-inline"
                                                            style="font-size: 15px;font-weight:500;cursor:pointer;">{{post.name}}
                                                        </p>
                                                        <small class="text-muted d-block"
                                                            style="font-size:12px;">{{post.time}} <i
                                                                :class="post.category" class="fa"></i></small>
                                                    </div>
                                                </div>

                                                <!-- <div class="col-2 position-relative">
                                                    <div class="position-absolute w-100"
                                                        style="right:10px;top:-25px;font-size: 20px;">
                                                        <b class="position-absolute" style="right: 0;"> . . .</b>
                                                    </div>
                                                </div> -->
                                            </div>
                                          <!-- Header End -->

                                          <!-- Modal Body -->
                                            <div class="modal-body p-1" style="min-height: 70vh;">
                                                <!-- Content And Link -->
                                                <p class="pt-3" style="white-space:pre-wrap;font-size:14px;">{{post.content.toString()}}</p>
                                                    <div v-show="post.link[0] != ''">
                                                       <a v-for="url in post.link" target="blank" class="d-block p-1" :href="url">{{url}}</a>
                                                     </div>

                                                <!-- Post All Images -->
                                                <div class=" row justify-content-center w-100 p-0 m-0" v-if="post.images[0] != ''">
                                                    <!-- Remove row element if images does't exist -->

                                                    <div v-for="(img,i) in post.images" class="col-12 col-lg-5 p-lg-4 text-center p-0 mt-3 ">
                                                        <img @click="modalImgSoloView(img)" class="img-thumbnail shadow" :id="'solo'+img" :src="'uploads/'+post.path+'/'+img"
                                                            alt="..." style="width:100%;">
                                                    </div>

                                                </div>
                                                <!-- Post Images End -->
                                            </div>
                                          <!-- Modal Body End -->

                                            <div class="modal-footer d-inline-block p-0 pt-1">
                                               <!-- Post Like and Comments -->
                                                <div class="row">

                                                     <div class="col-5 position-relative" style="padding-right:0!important;">
                                                      <!-- Like No Place -->
                                                         <span class="text-muted" style="font-size: 12px;">
                                                            <span v-if="post.reactions == 0">Be the first to Like.</span>
                                                            <span style="cursor:pointer;" @click="reactions(post.token)" v-if="(post.like_user == cookieId) && (post.reactions == 1)">
                                                               <i v-if="post.react_no[0] != 0" :class="post.react_name[0]+'IconSmall'" class="likeTypeSmall"></i>
                                                               <i v-if="post.react_no[1] != 0" :class="post.react_name[1]+'IconSmall'" class="likeTypeSmall"></i>
                                                               <i v-if="post.react_no[2] != 0" :class="post.react_name[2]+'IconSmall'" class="likeTypeSmall"></i>
                                                                You {{ cookieName }}</span>
                                                            <span style="cursor:pointer;" @click="reactions(post.token)" v-if="(post.like_user == cookieId) && (post.reactions  > 1)">
                                                               <i v-if="post.react_no[0] != 0" :class="post.react_name[0]+'IconSmall'" class="likeTypeSmall"></i>
                                                               <i v-if="post.react_no[1] != 0" :class="post.react_name[1]+'IconSmall'" class="likeTypeSmall"></i>
                                                               <i v-if="post.react_no[2] != 0" :class="post.react_name[2]+'IconSmall'" class="likeTypeSmall"></i>
                                                                You and {{ post.reactions - 1 }} others</span>
                                                            <span style="cursor:pointer;" @click="reactions(post.token)" v-if="(post.like_user != cookieId) && (post.reactions == 1)">
                                                               <i v-if="post.react_no[0] != 0" :class="post.react_name[0]+'IconSmall'" class="likeTypeSmall"></i>
                                                               <i v-if="post.react_no[1] != 0" :class="post.react_name[1]+'IconSmall'" class="likeTypeSmall"></i>
                                                               <i v-if="post.react_no[2] != 0" :class="post.react_name[2]+'IconSmall'" class="likeTypeSmall"></i>
                                                                {{ post.reactionsnc }} like</span>
                                                            <span style="cursor:pointer;" @click="reactions(post.token)" v-if="(post.like_user != cookieId) && (post.reactions > 1)">
                                                               <i v-if="post.react_no[0] != 0" :class="post.react_name[0]+'IconSmall'" class="likeTypeSmall"></i>
                                                               <i v-if="post.react_no[1] != 0" :class="post.react_name[1]+'IconSmall'" class="likeTypeSmall"></i>
                                                               <i v-if="post.react_no[2] != 0" :class="post.react_name[2]+'IconSmall'" class="likeTypeSmall"></i>
                                                                {{ post.reactionsnc }} likes</span>
                                                         </span>
                                                     </div>

                                                     <div class="col-4 position-relative p-0">
                                                      <!--Comment No Place  -->
                                                         <span v-if="post.comments == 0" class="text-muted position-absolute" style="font-size: 12px;right:0;bottom:2px;"> </span>
                                                         <span @click="showModalComments(post.id,index,post.reactions,post.unlikes,post.comments,post.like_user,post.token,post.react_name,post.react_no)" v-if="post.comments == 1" class="text-muted position-absolute" style="font-size: 12px;right:0;bottom:2px;cursor:pointer;"> {{ post.commentsnc }} Comment</span>
                                                         <span @click="showModalComments(post.id,index,post.reactions,post.unlikes,post.comments,post.like_user,post.token,post.react_name,post.react_no)" v-if="post.comments > 1" class="text-muted position-absolute" style="font-size: 12px;right:0;bottom:2px;cursor:pointer;"> {{ post.commentsnc }} Comments</span>
                                                     </div>

                                                     <div class="col-3 position-relative p-0">
                                                      <!--Unlike No Place  -->
                                                         <span v-if="post.unlikes == 0" class="text-muted position-absolute" style="font-size: 12px;right:0;bottom:2px;"></span>
                                                         <span v-if="post.unlikes > 0" class="text-muted position-absolute" style="font-size: 12px;right:0;bottom:2px;">{{ post.unlikesnc }} Unlike</span>
                                                     </div>

                                                     <!-- Like   -->
                                                    <div class="col-4 p-0">
                                                       <button :style="globalColor" v-if="post.like_user == cookieId" :id="'like'+post.token" @click="vueunlikes(post.token)" rel="unlike" class="unLike w-100 text-primary border-0" style="padding:7px 0;background:#fff;min-height:45px;">
                                                         <i :class="post.like_emoj+'IconSmall'" class="text-primary likeTypeSmall" aria-hidden="true"></i>
                                                         <span style="font-size: 12px;">{{post.like_emoji}}</span>
                                                       </button>

                                                       <button :style="globalColor" v-else  :id="'like'+post.token" rel="like" class="reaction w-100 text-muted border-0" style="padding:7px 0;background:#fff;min-height:45px;">
                                                         <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                                         <span style="font-size: 12px;">Like</span>
                                                       </button>
                                                    </div>
                                                     <!-- Comments -->
                                                    <div class="col-4 p-0">
                                                        <button :style="globalColor" @click="showModalComments(post.id,index,post.reactions,post.unlikes,post.comments,post.like_user,post.token,post.react_name,post.react_no)" class=" w-100 text-muted border-0" style="padding:7px 0;background:#fff;">
                                                          <i class="fa fa-comment" aria-hidden="true"></i>
                                                          <span style="font-size: 12px;">Comment</span>
                                                        </button>

                                                    </div>
                                                    <!-- Unlike -->
                                                    <div class="col-4 p-0 position-relative">
                                                       <button :style="globalColor" v-if="post.unlike_user == cookieId" @click="vueundangerlikes(post.token)" class=" w-100 text-danger border-0" style="padding:7px 0;background:#fff;">

                                                         <i class="fa fa-thumbs-down text-danger pl-2" aria-hidden="true" style="right: 24px; top: 13px;"></i>
                                                         <span style="font-size: 12px;"> Unlike</span>
                                                       </button>

                                                        <button :style="globalColor" v-else @click="vuedangerlikes(post.token)" class=" w-100 text-muted border-0" style="padding:7px 0;background:#fff;">

                                                         <i class="fa fa-thumbs-down text-muted pl-2" aria-hidden="true" style="right: 24px; top: 13px;"></i>
                                                         <span style="font-size: 12px;"> Unlike</span>
                                                        </button>
                                                    </div>

                                                </div>

                                               <!-- Post Like and Comments -->
                                            </div>

                                        </div>
                                    </div>
                                   </div>
                                   <!-- Post Content End -->
      
                                  </div>
                                <!-- Card Body End -->
      
                                 <!-- Post Images Place Start -->
                                  <div class="row pt-2" v-if="post.images[0] != ''">
      
                                    <div v-if="post.images.length == 1" class="position-relative w-100 p-0">
                                      <div class="col-12 p-0 position-relative">
                                        <img v-for="(img,i) in post.images" @click="clickPostImg(index,post.images.length,img)" class="fullscreen w-100" :id="'image'+img" style="max-height: 75vh;" :src="'uploads/'+post.path+'/'+img" alt="...">
                                      </div>
                                    </div>
      
                                    <!-- Image 2 -->
                                    <div v-if="post.images.length == 2" v-for="(img,i) in post.images" class="col-6 p-0 postImg">
                                        <img @click="clickPostImg(index+'profileview',post.images.length,img+'profileImg')" class="fullscreen w-100" :id="'image'+img" :src="'uploads/'+post.path+'/'+img" alt="...">
                                    </div>
      
                                    <div v-if="post.images.length == 3" class="row p-0 m-0 w-100" @click="clickPostImg(index+'profileview',post.images.length,post.images+'profileImg')">
                                       <div class="p-0 postImg col-6">
                                          <img class="fullscreen w-100" :src="'uploads/'+post.path+'/'+post.images[0]" alt="">
                                        </div>
                                        <div  class="p-0 postImg col-6 position-relative" >
                                          <img class="fullscreen w-100" :src="'uploads/'+post.path+'/'+post.images[1]" alt="">
                                          <div class="position-absolute" style="bottom:4%;right:6%;border-radius:50%;width:50px;height:50px;background:rgb(0, 0, 0, 0.7);">
                                             <div class="justify-conent-center align-items-center d-flex h-100">
                                               <div v-if="post.images.length >= 2" class="col text-center fw-bold fs-4 text-light">+{{post.images.length - 2}}</div>
                                             </div>
                                          </div>
                                        </div>
      
                                    </div>
      
                                    <!-- Image 4  -->
                                    <div v-if="post.images.length == 4" v-for="(img,i) in post.images" class="col-6 p-0 postImg">
                                     <!-- Remove row element if images does't exist -->
                                        <img @click="clickPostImg(index+'profileview',post.images.length,img+'profileImg')" class="fullscreen w-100" :id="'image'+img" :src="'uploads/'+post.path+'/'+img" alt="...">
                                    </div>
      
                                    <!-- Image Greater than 4 -->
                                    <div v-if="post.images.length > 4" class="row p-0 m-0 w-100" @click="clickPostImg(index+'profileview',post.images.length,post.images+'profileImg')">
                                     <!-- Remove row element if images does't exist -->
                                        <div class="p-0 postImg col-6">
                                          <img class="fullscreen img-thumbnail w-100" :src="'uploads/'+post.path+'/'+post.images[0]" alt="">
                                        </div>
                                        <div class="p-0 postImg col-6">
                                          <img class="fullscreen img-thumbnail w-100" :src="'uploads/'+post.path+'/'+post.images[1]" alt="">
                                        </div>
                                        <div class="p-0 postImg col-6">
                                          <img class="fullscreen img-thumbnail w-100" :src="'uploads/'+post.path+'/'+post.images[2]" alt="">
                                        </div>
                                        <div class="p-0 postImg col-6 position-relative">
                                          <img class="fullscreen img-thumbnail w-100" :src="'uploads/'+post.path+'/'+post.images[3]" alt="">
                                          <div class="position-absolute w-100 h-100" style="top:0;background:rgb(0, 0, 0, 0.3);">
                                             <div class="justify-conent-center align-items-center d-flex h-100">
                                               <div v-if="post.images.length >= 5" class="col text-center fw-bold fs-4 text-light">+{{post.images.length - 4}}</div>
                                             </div>
                                          </div>
                                        </div>
                                        <!-- <img @click="globalViewPostModal(post.id,post.name)" class="fullscreen w-100" :id="'image'+img" :src="'uploads/'+post.path+'/'+img" alt="..."> -->
                                    </div>
      
      
                                  </div>
                                 <!-- Post Images Place End -->
      
                                  <!-- Post Like and Comments -->
                                    <div class="row" :id="post.token">
      
                                      <div class="row border-bottom pt-1 pb-1">
      
                                          <div class="col-5 position-relative" style="padding-right:0!important;">
                                           <!-- Like No Place -->
                                              <span class="text-muted" style="font-size: 12px;">
                                                 <span v-if="post.reactions == 0">Be the first to Like.</span>
                                                 <span style="cursor:pointer;" @click="reactions(post.token)" v-if="(post.like_user == cookieId) && (post.reactions == 1)">
                                                    <i v-if="post.react_no[0] != 0" :class="post.react_name[0]+'IconSmall'" class="likeTypeSmall"></i>
                                                    <i v-if="post.react_no[1] != 0" :class="post.react_name[1]+'IconSmall'" class="likeTypeSmall"></i>
                                                    <i v-if="post.react_no[2] != 0" :class="post.react_name[2]+'IconSmall'" class="likeTypeSmall"></i>
                                                     You {{ cookieName }}</span>
                                                 <span style="cursor:pointer;" @click="reactions(post.token)" v-if="(post.like_user == cookieId) && (post.reactions  > 1)">
                                                    <i v-if="post.react_no[0] != 0" :class="post.react_name[0]+'IconSmall'" class="likeTypeSmall"></i>
                                                    <i v-if="post.react_no[1] != 0" :class="post.react_name[1]+'IconSmall'" class="likeTypeSmall"></i>
                                                    <i v-if="post.react_no[2] != 0" :class="post.react_name[2]+'IconSmall'" class="likeTypeSmall"></i>
                                                     You and {{ post.reactions - 1 }} others</span>
                                                 <span style="cursor:pointer;" @click="reactions(post.token)" v-if="(post.like_user != cookieId) && (post.reactions == 1)">
                                                    <i v-if="post.react_no[0] != 0" :class="post.react_name[0]+'IconSmall'" class="likeTypeSmall"></i>
                                                    <i v-if="post.react_no[1] != 0" :class="post.react_name[1]+'IconSmall'" class="likeTypeSmall"></i>
                                                    <i v-if="post.react_no[2] != 0" :class="post.react_name[2]+'IconSmall'" class="likeTypeSmall"></i>
                                                     {{ post.reactionsnc }} like</span>
                                                 <span style="cursor:pointer;" @click="reactions(post.token)" v-if="(post.like_user != cookieId) && (post.reactions > 1)">
                                                    <i v-if="post.react_no[0] != 0" :class="post.react_name[0]+'IconSmall'" class="likeTypeSmall"></i>
                                                    <i v-if="post.react_no[1] != 0" :class="post.react_name[1]+'IconSmall'" class="likeTypeSmall"></i>
                                                    <i v-if="post.react_no[2] != 0" :class="post.react_name[2]+'IconSmall'" class="likeTypeSmall"></i>
                                                     {{ post.reactionsnc }} likes</span>
                                              </span>
                                          </div>
      
                                          <div class="col-4 position-relative p-0">
                                           <!--Comment No Place  -->
                                              <span v-if="post.comments == 0" class="text-muted position-absolute" style="font-size: 12px;right:0;bottom:2px;"> </span>
                                              <span @click="showModalComments(post.id,index,post.reactions,post.unlikes,post.comments,post.like_user,post.token,post.react_name,post.react_no)" v-if="post.comments == 1" class="text-muted position-absolute" style="font-size: 12px;right:0;bottom:2px;cursor:pointer;"> {{ post.commentsnc }} Comment</span>
                                              <span @click="showModalComments(post.id,index,post.reactions,post.unlikes,post.comments,post.like_user,post.token,post.react_name,post.react_no)" v-if="post.comments > 1" class="text-muted position-absolute" style="font-size: 12px;right:0;bottom:2px;cursor:pointer;"> {{ post.commentsnc }} Comments</span>
                                          </div>
      
                                          <div class="col-3 position-relative p-0">
                                           <!--Unlike No Place  -->
                                              <span v-if="post.unlikes == 0" class="text-muted position-absolute" style="font-size: 12px;right:0;bottom:2px;"></span>
                                              <span v-if="post.unlikes > 0" class="text-muted position-absolute" style="font-size: 12px;right:0;bottom:2px;">{{ post.unlikesnc }} Unlike</span>
                                          </div>
      
                                      </div>
                                      <!-- Like   -->
                                      <div class="col-6 p-0">
                                          <button :style="globalColor" v-if="post.like_user == cookieId" :id="'like'+post.token" @click="vueProfileUnlikes(post.token)" rel="unlike" class="unLike w-100 text-primary border-0" style="padding:7px 0;background:#fff;min-height:45px;">
                                            <i :class="post.like_emoj+'IconSmall'" class="text-primary likeTypeSmall" aria-hidden="true"></i>
                                            <span style="font-size: 12px;">{{post.like_emoji}}</span>
                                          </button>
      
                                          <button :style="globalColor" v-else  :id="'like'+post.token" rel="like" class="reaction w-100 text-muted border-0" style="padding:7px 0;background:#fff;min-height:45px;">
                                            <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                            <span style="font-size: 12px;">Like</span>
                                          </button>
                                      </div>
                                       <!-- Comments -->
                                      <div class="col-6 p-0">
                                          <button @click="showModalComments(post.id,index,post.reactions,post.unlikes,post.comments,post.like_user,post.token,post.react_name,post.react_no)" :style="globalColor" class=" w-100 text-muted border-0" style="padding:7px 0;background:#fff;">
                                            <i class="fa fa-comment" aria-hidden="true"></i>
                                            <span style="font-size: 12px;">Comment</span>
                                          </button>
      
                                      </div>

      
                                    </div>
                                  <!-- Post Like and Comments End -->
  
      
      
      
                              </div>
                              <!-- Post Type End -->
      
                              <!-- Blog Type Start-->
                              <div v-if="post.type == 'blog'" class="card col-lg-6">
                                  <h3>This is Blog Post</h3>
                                  <p>
                                      Lorem ipsum dolor sit amet consectetur adipisicing elit. Animi quibusdam
                                      reprehenderit dicta quas consequuntur nobis perspiciatis rerum delectus voluptas
                                      voluptates aliquid hic quidem impedit officiis, aspernatur totam accusamus soluta
                                      eos?
                                  </p>
                              </div>
                              <!-- Blog Type End -->
      
                              <!-- Share Type Start-->
                              <div v-if="post.type == 'share'" class="card col-lg-6">
                                  <h3>This is Share Post</h3>
                                  <p>
                                      Lorem ipsum dolor sit, amet consectetur adipisicing elit. Velit iste animi nobis
                                      explicabo, necessitatibus et culpa? Sequi, accusamus? Laudantium sunt possimus
                                      voluptate amet. Aperiam quaerat, cupiditate corrupti consectetur ipsa quod?
                                  </p>
                              </div>
                              <!-- Share Type End -->
      
                          </div>     
                     </div>

                 </div>

            </div>






            <!-- Left Lg -->
            <div class="col-md-3 pt-md-5 col-lg-3 pt-lg-3 d-none d-md-block position-sticky" style="top:24px;height:100vh;">
               
                <div class="row mt-lg-4" id="#">

                     <div class="card border pt-2 pb-3" :style="globalColor" >
                          <div class=" p-3">
                             Ads By Google
                           </div>
                           <p>
                             Lorem ipsum dolor, sit amet consectetur adipisicing elit. Esse autem officia, dolorum aut iste sed velit ipsam ullam atque cum facilis at soluta, mollitia excepturi amet sequi dignissimos nulla! Illum?
                           </p>
                     </div>

                     <div >
                        <div class="card position-relative row" :style="globalColor">
                            <div class="card-header p-3" :style="globalColor">
                              Contacts
                            </div>
                            <ul class="list-group list-group-flush" style="overflow: scroll;height:50vh">
                              <li v-for="fri in friendActive" v-if="fri.status == 'Online'" class="list-group-item" :style="globalColor">
                                 <img :src="'profile/'+fri.pic" style="width:40px;height:40px;border-radius:50px;" alt=""> {{fri.name}}
                                  <i class="fa fa-circle" style="font-size: 12px;color:#0f0;"></i>
                                </li>
                            </ul>
                        </div>

                      </div>


                 </div>
            </div>



        </div>
        <!-- Main Container End -->
















        <!-- Global Modal & Offcanva -->
        <edit-post v-on:edited="editProfilePost" :id="cookieId" :pic="'profile/'+cookiePic" :global="globalColor" :editpost="editpost" :name="cookieName" :userrow="userrow"></edit-post>

        <!---- Modal AddNew Post  -->
        <addnew-post v-on:updated="addNewPost" :id="cookieId" :pic="'profile/'+cookiePic" :global="globalColor" :access_token="access_token" :name="cookieName" :userrow="userrow"></addnew-post>

        <!-- Modal Write Comment Place -->
        <div class="modal fade p-0 text-center" id="modalCommentsId" :style="{'z-index': zindex},globalColor" data-bs-backdrop="static" data-bs-keyboard="false" >
           <div class="modal-dialog modal-lg modal-dialog-scrollable m-auto" >
             <div class="modal-content border-0 p-1" :style="globalColor">
                 <!-- Modal Header -->
                 <div class="modal-header" style="padding: 10px 0 10px 5px!important;" >
                      <!-- Like No Place -->
                      <span class="text-muted" style="font-size: 12px;">
                         <span v-if="modalCmLikes == 0">Be the first to Like.</span>
                         <span style="cursor:pointer;" @click="reactions(modalCmToken)" v-if="(modalCmLikeUser == cookieId) && (modalCmLikes == 1)">
                            <i v-if="modalCmrcno[0] != 0" :class="modalCmrcname[0]+'IconSmall'" class="likeTypeSmall"></i>
                            <i v-if="modalCmrcno[1] != 0" :class="modalCmrcname[1]+'IconSmall'" class="likeTypeSmall"></i>
                            <i v-if="modalCmrcno[2] != 0" :class="modalCmrcname[2]+'IconSmall'" class="likeTypeSmall"></i>
                             You {{ cookieName }}</span>
                         <span style="cursor:pointer;" @click="reactions(modalCmToken)" v-if="(modalCmLikeUser == cookieId) && (modalCmLikes  > 1)">
                            <i v-if="modalCmrcno[0] != 0" :class="modalCmrcname[0]+'IconSmall'" class="likeTypeSmall"></i>
                            <i v-if="modalCmrcno[1] != 0" :class="modalCmrcname[1]+'IconSmall'" class="likeTypeSmall"></i>
                            <i v-if="modalCmrcno[2] != 0" :class="modalCmrcname[2]+'IconSmall'" class="likeTypeSmall"></i>
                             You and {{ modalCmLikes - 1 }} others</span>
                         <span style="cursor:pointer;" @click="reactions(modalCmToken)" v-if="(modalCmLikeUser != cookieId) && (modalCmLikes == 1)">
                            <i v-if="modalCmrcno[0] != 0" :class="modalCmrcname[0]+'IconSmall'" class="likeTypeSmall"></i>
                            <i v-if="modalCmrcno[1] != 0" :class="modalCmrcname[1]+'IconSmall'" class="likeTypeSmall"></i>
                            <i v-if="modalCmrcno[2] != 0" :class="modalCmrcname[2]+'IconSmall'" class="likeTypeSmall"></i>
                             {{ modalCmLikes }} like</span>
                         <span style="cursor:pointer;" @click="reactions(modalCmToken)" v-if="(modalCmLikeUser != cookieId) && (modalCmLikes > 1)">
                            <i v-if="modalCmrcno[0] != 0" :class="modalCmrcname[0]+'IconSmall'" class="likeTypeSmall"></i>
                            <i v-if="modalCmrcno[1] != 0" :class="modalCmrcname[1]+'IconSmall'" class="likeTypeSmall"></i>
                            <i v-if="modalCmrcno[2] != 0" :class="modalCmrcname[2]+'IconSmall'" class="likeTypeSmall"></i>
                             {{ modalCmLikes }} likes</span>
                         </span>
                    <div class="col-3 position-relative text-center m-2" style="padding: 10px 5px 10px 0px!important;">
                      <!--Unlike No Place  -->
                      <span v-if="modalCmUnlikes == 0" class="text-muted position-absolute" style="font-size: 12px;right:0;bottom:2px;"></span>
                      <span v-if="modalCmUnlikes > 0" class="text-muted position-absolute" style="font-size: 12px;right:0;bottom:2px;"><span class="text-danger fw-bold">{{ modalCmUnlikes }} Unlike</span></span>
                    </div>
                    <div @click="sortcm('DESC')" class="col-1 text-center m-2">
                      <i v-if="!cmreverse" class="fa text-success fa fa-clock" aria-hidden="true"></i>
                      <i v-if="cmreverse" class="fa text-primary fa fa-clock" aria-hidden="true"></i>
                    </div>
                 </div>
                  <!-- Modal Header End -->

                 <!-- Show Loading if Data not ready yet -->
                 <div v-if="cmloading" class="row justify-content-center d-flex align-items-center" style="height:85vh">
                     <div class="col-12 pb-5 mb-5 text-center">
                         <img src="assets/icon/loadingdot.webp" style="width: 120px;" alt="">
                     </div>
                 </div>

                 <div v-else @scroll="commentScroll"  class="modal-body row justify-content-left d-inline-block p-0 pt-3 pb-5 mb-5" style="min-height: 75vh;">
                     <div  v-if="getAllComments != null" v-for="(cm,cmindex) in getAllComments" class="col-11 text-left d-inline-block position-relative p-0 mb-3">
                        <!-- If Commenter is me Change Bg & Color -->
                           <div v-if="cm.user == cookieId" class="">
                              <img @click="viewprofile(cm.user)" :src="'profile/'+cm.pic"  class="position-absolute mb-0" style="border-radius: 50px;width:45px;height:45px;top:0;left:0;" alt="">
                              <div class="pl-3  position-relative text-left" style="width:80%;min-height:10px;left:50px;top:0;border-radius:10px;text-align:left;background:#EBF7FF;" >
                                 <p @click="viewprofile(cm.user)" class="d-inline-block m-0 text-dark" style="font-size: 15px;font-weight:500;padding-top:5px!important;padding-left:10px!important;"> {{cm.uname}}</p>
                                 <readmore-post :post="cm.content.toString()" style="padding: 0 0 4px 10px!important;color:#444" :link="cm.link" :index="cmindex" ></readmore-post>
                              </div>
                              <div v-if="cm.check_photo != ''" class="col-lg-6">
                                <img v-if="cm.check_photo.includes('giphy.com')" :src="cm.check_photo" class="position-relative mb-0" style="border-radius: 10px;height:100px;max-width:130px;top:2px;left:-50px;" alt="">
                                <img @click="cmImgView(cmindex)" :id="'cmimage'+cmindex" v-else :src="cm.photo" class="position-relative mb-0" style="border-radius: 10px;height:100px;max-width:130px;top:2px;left:-50px;" alt="">
                              </div>
                           </div>
                            <!-- If Commenter is not me Default Bg & Color -->
                           <div v-else class="">
                              <img @click="viewprofile(cm.user)" :src="'profile/'+cm.pic"  class="position-absolute mb-0" style="border-radius: 50px;width:45px;height:45px;top:0;left:0;" alt="">
                              <div class="pl-3  position-relative text-left" style="width:80%;min-height:10px;left:50px;top:0;border-radius:10px;text-align:left;" :style="globalComment">
                                 <p @click="viewprofile(cm.user)" class="d-inline-block m-0" style="font-size: 15px;font-weight:500;padding-top:5px!important;padding-left:10px!important;"> {{cm.uname}}</p>
                                 <readmore-post :post="cm.content.toString()" style="padding: 0 0 4px 10px!important;" :link="cm.link" :index="cmindex" ></readmore-post>
                              </div>
                              <div v-if="cm.check_photo != ''" class="col-lg-6">
                                <img v-if="cm.check_photo.includes('giphy.com')" :src="cm.check_photo" class="position-relative mb-0" style="border-radius: 10px;height:100px;max-width:130px;top:2px;left:-50px;" alt="">
                                <img v-else :src="cm.photo" class="position-relative mb-0" style="border-radius: 10px;height:100px;max-width:130px;top:2px;left:-50px;" alt="">
                              </div>
                           </div>
                           <!-- footer -->
                            <div class="row justify-content-right pt-1">
                                 <div class="col-2 col-md-1"></div>
                                 <div class="col-2 col-md-1 p-0 small text-muted">
                                     {{cm.time}}
                                 </div>
                                 <div class="col-1 col-md-1 p-0 small text-muted">
                                     <div v-if="cm.like_user == cookieId" class="text-primary" @click="uncmlikes(cm.id)">
                                       Like
                                     </div>
                                     <div v-else class="text-muted" @click="cmlikes(cm.id)">
                                       Like
                                     </div>
                                 </div>
                                 <div @click="showModalReply(cm.id)" class="col-3 col-md-2 small text-muted">
                                     Reply
                                 </div>
                                 <div v-if="cm.likes == 0" class="col-3 col-md-2 small text-muted"></div>
                                 <div v-if="cm.likes > 0" class="col-3 col-md-2 small text-muted"><i class="fa text-primary fa-thumbs-up"></i> {{ cm.likes }} </div>
                                 <div class="col-1 col-md-4"></div>
                            </div>
                           <!-- footer end -->
                          <!-- Reply Comment Show -->
                              <div v-if="cm.reply > 0" class="row justify-content-right pt-1">
                                 <div class="col-10 text-right d-inline-block position-relative" @click="showModalReply(cm.id)" >
                                   <div v-if="cm.rp_user == cookieId">
                                     <img :src="'profile/'+cm.rp_user_pic"  class="position-absolute mb-0" style="border-radius: 50px;width:30px;top:3px;left:70px;" alt="">
                                      <div class="pl-3  position-relative text-left" style="min-height:10px;width:90%;left:91px;top:0;border-radius:10px;text-align:left;background:#EBF7FF;">
                                          <p class="d-inline-block m-0 text-dark" style="font-size: 15px;font-weight:500;padding-top:5px!important;padding-left:5px!important;">{{cm.rp_user_name}}</p>
                                          <div  class="p-1" style="white-space:nowrap;overflow:hidden;text-overflow: ellipsis;padding-left:10px!important;font-size:15px;color:#444;">{{cm.rp_user_content.toString().substr(0, 135)}} </span>
                                           </div>
                                      </div>
                                   </div>
                                   <div v-else>
                                      <img :src="'profile/'+cm.rp_user_pic"  class="position-absolute mb-0" style="border-radius: 50px;width:30px;top:3px;left:70px;" alt="">
                                      <div class="pl-3  position-relative text-left" style="min-height:10px;width:90%;left:91px;top:0;border-radius:10px;text-align:left;" :style="globalComment">
                                          <p class="d-inline-block m-0" style="font-size: 15px;font-weight:500;padding-top:5px!important;padding-left:5px!important;">{{cm.rp_user_name}}</p>
                                          <div  class="p-1" style="white-space:nowrap;overflow:hidden;text-overflow: ellipsis;padding-left:10px!important;font-size:15px;">{{cm.rp_user_content.toString().substr(0, 135)}} </span>
                                           </div>
                                      </div>
                                   </div>
                                    <div v-if="cm.viewmorereply" class="pt-2 pb-2 text-start" style="padding-left:94px!important;">
                                      <b><small>View 1 more reply...</small></b>
                                    </div>
                                 </div>
                              </div>
                           <!-- Reply Comment Show -->
                     </div>
                     <div v-if="getAllComments == null" class="row justify-content-center d-flex align-items-center" style="height:50vh">
                        <div class="col-12 text-center text-muted">
                        <i class="fa fa-comments fa-2x pb-2 d-block" aria-hidden="true"></i>
                            <h7 class="pb-1">No Comments Yet</h7>
                            <p style="font-size:13px;">Be the first to comment.</p>
                        </div>
                     </div>
                 </div>

                 <div class="modal-footer p-0 pt-1 position-absolute w-100" style="bottom: 0;left:0;min-height:10vh;" :style="globalColor">
                   <div class="row w-100" :style="globalColor">
                      <div class="col-12 col-lg-6 pb-2 pt-lg-2">
                         <textarea name="" v-model="commentText" id="" spellcheck="false" placeholder=" Write a comment . . ." class="bg-light border-0 p-2" style="width: 100%;border-radius:50px;height:40px;outline:none;" ></textarea>
                      </div>
                      <!-- GIF & Sticker Live Preview -->
                      <div v-if="commentGiphyContainer.length > 0" class="col-5 col-lg-2">
                          <!-- Show Loading if Data not ready yet -->
                            <div v-if="gifloading" class="row justify-content-center d-flex align-items-center" style="height:40vh">
                                  <div class="col-12 text-center">
                                      <img src="./assets/icon/loadingdot.webp" class="w-25" alt="">
                                  </div>
                            </div>
                           <!-- Images Live Preview -->
                           <div V-else class="col-12 p-0">
                             <div class="position-relative d-inline-block">
                               <img @click="removeImgPreview()" :src="commentGiphyContainer[0].url" :alt="commentGiphyContainer[0].url" style="width: 55px; height: 60px;width:60px"/>
                             </div>
                           </div>
                       </div>
                      <!-- Photo Comment Live Preview -->
                       <div v-if="photoCommentLivePreview.length > 0" class="col-4 col-lg-2">
                           <!-- Images Live Preview -->
                           <div class="mb-2" style="border-radius:5px;" id="imagePreview">
                               <div class="col-12 p-0">
                                 <div class="position-relative d-inline-block">
                                   <img @click="removeImgPreview(photoCommentLivePreview[0].name)" :src="globalCommentPhoto" :alt="photoCommentLivePreview[0].name"  style="width: 55px; min-height: 55px;"/>
                                 </div>
                               </div>
                             </div>
                       </div>
                       <div v-if="photoCommentLivePreview.length > 0" class="col-2 d-lg-none">
                       </div>
                       <!-- Upload Images Btn -->
                      <div v-if="photoCommentLivePreview.length == 0 && commentGiphyContainer.length == 0" class="col-2 col-lg-1 comment-upload pt-2">
                         <div class="comment-select p-0">
                           <div class="comment-select-button" >
                             <i class="fa fa-camera position-absolute" style="font-size: 20px; top: 8px;right:12px;"></i>
                           </div>
                           <div @change="changePhotoComment">
                             <input type="file" id="commentphoto" name="commentphoto" class="comment-upload" accept="image/*">
                           </div>
                         </div>
                      </div>
                      <!-- Upload GIF Btn -->
                      <div v-if="photoCommentLivePreview.length == 0 && commentGiphyContainer.length == 0" class="col-2 col-lg-1 comment-upload pt-2">
                         <button @click="loadGiphyCommentPreview('gif')" data-bs-toggle="offcanvas" data-bs-target="#offcanvasGif" class="btn  border" :style="globalColor">GIF</button>
                      </div>
                      <!-- Upload Images Btn -->
                      <div v-if="photoCommentLivePreview.length == 0 && commentGiphyContainer.length == 0" class="col-2 col-lg-1 comment-upload pt-2">
                         <button  @click="loadGiphyCommentPreview('sticker')" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSticker" class="btn  border" :style="globalColor"><i class="fa fa-smile"></i></button>
                      </div>
                      <div class="col-4 d-lg-none" style="height: 5vh;">
                      </div>
                      <div class="col-2 col-lg-3 pt-2">
                        <button @click="uploadComment(globalcommentId)" class="btn border text-info"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                      </div>
                   </div>
                </div>
               <!-- Modal Content End-->
             </div>
          </div>
        </div>

        <!-- Modal Write Reply Place -->
        <div class="modal fade p-0 text-center" id="modalReplyId" :style="{'z-index': zindex},globalColor" data-bs-backdrop="static" data-bs-keyboard="false" >
             <div class="modal-dialog modal-lg modal-dialog-scrollable m-auto">
               <div class="modal-content border-0 p-0 " :style="globalColor">
                    <!-- Modal Header -->
                   <div class="modal-header" style="padding: 10px 0 10px 5px!important;" :style="globalColor">
                        <!-- Like No Place -->
                     <span class="text-muted" style="font-size: 12px;">
                     </span>
                      <div class="col-3 position-relative text-center m-2">
                        <span class="font-monospaced">Replies</span>
                      </div>
                      <div class="col-1 text-center m-2">
                      </div>
                   </div>
                    <!-- Modal Header End -->
                    <!-- Show Loading if Data not ready yet -->
                   <div v-if="rploading" class="row justify-content-center d-flex align-items-center" style="height:70vh">
                       <div class="col-12 mb-5 pb-4 text-center">
                           <img src="assets/icon/loading.webp" style="width: 50px;" alt="">
                       </div>
                   </div>
                   <div v-else class="modal-body row justify-content-left d-inline-block p-0 pt-3 pb-5 mb-5" style="min-height: 75vh;" :style="globalColor">
                       <div  v-for="(cm,cmindex) in getAllReplys.comment" class="col-11 text-left d-inline-block position-relative p-0 mb-2">
                          <!-- If Commenter is me Change Bg & Color -->
                          <div v-if="cm.user == cookieId" class="">
                             <img @click="viewprofile(cm.user)" :src="'profile/'+cm.pic"  class="position-absolute mb-0" style="border-radius: 50px;width:45px;height:45px;top:0;left:0;" alt="">
                             <div class="pl-3  position-relative w-75 text-left" style="min-height:10px;left:50px;top:0;border-radius:10px;text-align:left;background:#EBF7FF">
                                <p @click="viewprofile(cm.user)" class="d-inline-block m-0 text-dark" style="font-size: 15px;font-weight:500;padding-top:5px!important;padding-left:10px!important;"> {{cm.uname}}</p>
                                <readmore-post style="padding: 0 0 0 10px!important;color:#444;" :post="cm.content.toString()" :link="cm.link" :index="cmindex+'commenter'" ></readmore-post>
                             </div>
                             <div v-if="cm.check_photo != ''" class="col-lg-6">
                                  <img v-if="cm.check_photo.includes('giphy.com')" :src="cm.check_photo" class="position-relative mb-0" style="border-radius: 10px;height:100px;max-width:130px;top:2px;left:-50px;" alt="">
                                  <img @click="cmImgView(cmindex)" :id="'cmimage'+cmindex"  v-else :src="cm.photo" class="position-relative mb-0" style="border-radius: 10px;height:100px;max-width:130px;top:2px;left:-50px;" alt="">
                             </div>
                          </div>
                           <!-- If Commenter is not me Default Bg & Color -->
                          <div v-else>
                             <img @click="viewprofile(cm.user)" :src="'profile/'+cm.pic"  class="position-absolute mb-0" style="border-radius: 50px;width:45px;height:45px;top:0;left:0;" alt="">
                             <div class="pl-3  position-relative w-75 text-left" style="min-height:10px;left:50px;top:0;border-radius:10px;text-align:left;" :style="globalComment">
                                <p  @click="viewprofile(cm.user)" class="d-inline-block m-0" style="font-size: 15px;font-weight:500;padding-top:5px!important;padding-left:10px!important;"> {{cm.uname}}</p>
                                <readmore-post style="padding: 0 0 0 10px!important;" :post="cm.content.toString()" :link="cm.link" :index="cmindex+'2'" ></readmore-post>
                             </div>
                             <div v-if="cm.check_photo != ''" class="col-lg-6">
                                  <img v-if="cm.check_photo.includes('giphy.com')" :src="cm.check_photo" class="position-relative mb-0" style="border-radius: 10px;height:100px;max-width:130px;top:2px;left:-50px;" alt="">
                                  <img @click="cmImgView(cmindex)" :id="'cmimage'+cmindex"  v-else :src="cm.photo" class="position-relative mb-0" style="border-radius: 10px;height:100px;max-width:130px;top:2px;left:-50px;" alt="">
                             </div>
                          </div>
                             <!-- footer -->
                              <div class="row justify-content-right pt-1" :style="globalColor">
                                   <div class="col-2 col-md-1"></div>
                                   <div class="col-2 col-md-1 p-0 small text-muted">
                                       {{cm.time}}
                                   </div>
                                   <div class="col-1 col-md-1 p-0 small text-muted">
                                   </div>
                                   <div v-if="cm.likes == 0" class="col-3 col-md-2 small text-muted"></div>
                                   <div v-if="cm.likes > 0" class="col-3 col-md-2 small text-muted"><i class="fa text-primary fa-thumbs-up"></i> {{ cm.likes }} </div>
                                   <div class="col-1 col-md-4"></div>
                              </div>
                             <!-- footer end -->
                             <!-- Reply Comment Show -->
                                <div  class="row justify-content-right pt-2">
                                   <div v-if="rp != null" v-for="(rp,rpindex) in getAllReplys.reply" class="col-9 text-right d-inline-block position-relative pb-2" >
                                      <!-- If Commenter is me Change Bg & Color -->
                                     <div v-if="rp.user == cookieId">
                                        <img  @click="viewprofile(rp.user)" :src="'profile/'+rp.pic"  class="position-absolute mb-0" style="border-radius: 50px;width:30px;top:3px;left:70px;" alt="">
                                        <div class="pl-3  position-relative w-100 text-left" style="min-height:10px;left:92px;top:0;border-radius:10px;text-align:left;background:#EBF7FF">
                                            <p  @click="viewprofile(rp.user)" class="d-inline-block m-0 text-dark" style="font-size: 15px;font-weight:500;padding-top:5px!important;padding-left:5px!important;">{{rp.uname}}</p>
                                             <readmore-post class="position-relative w-100" style="padding: 0 0 0 5px!important;color:#444;" :post="rp.content.toString()" :link="rp.link" :index="rpindex" ></readmore-post>
                                        </div>
                                     </div>
                                     <!-- If Commenter is not me Default Bg & Color -->
                                     <div v-else>
                                       <img  @click="viewprofile(rp.user)" :src="'profile/'+rp.pic"  class="position-absolute mb-0" style="border-radius: 50px;width:30px;top:3px;left:70px;" alt="">
                                        <div class="pl-3  position-relative w-100 text-left" style="min-height:10px;left:92px;top:0;border-radius:10px;text-align:left;" :style="globalComment">
                                            <p @click="viewprofile(rp.user)" class="d-inline-block m-0" style="font-size: 15px;font-weight:500;padding-top:5px!important;padding-left:5px!important;">{{rp.uname}}</p>
                                             <readmore-post class="position-relative w-100" style="padding: 0 0 0 5px!important;" :post="rp.content.toString()" :link="rp.link" :index="rpindex" ></readmore-post>
                                        </div>
                                     </div>
                                      <div v-if="rp.check_photo != ''" class="col-lg-6">
                                         <img v-if="rp.check_photo.includes('giphy.com')" :src="rp.check_photo" class="position-relative mb-0" style="border-radius: 10px;height:100px;max-width:130px;top:2px;left:0" alt="">
                                         <img @click="cmImgView(cmindex)" :id="'cmimage'+cmindex"  v-else :src="rp.photo" class="position-relative mb-0" style="border-radius: 10px;height:100px;max-width:130px;top:2px;left:0" alt="">
                                      </div>
                                     <!-- footer -->
                                      <div class="row justify-content-right pt-1">
                                           <div class="col-3 col-md-2"></div>
                                           <div class="col-4 col-md-1 p-0 small text-muted">
                                               {{rp.time}}
                                           </div>
                                           <div class="col-1 col-md-4"></div>
                                      </div>
                                     <!-- footer end -->
                                   </div>
                                </div>
                             <!-- Reply Comment Show -->
                       </div>
                   </div>
                   <div class="modal-footer p-0 pt-1 position-absolute w-100" style="bottom: 0;left:0;min-height:13vh;" :style="globalColor">
                     <div class="row w-100">
                     <div class="col-12 col-lg-6 pb-2 pt-lg-2" :style="globalColor">
                           <textarea name="" v-model="commentText" id="" spellcheck="false" placeholder=" Write a reply . . ." class="bg-light border-0 p-2" style="width: 100%;border-radius:50px;height:40px;outline:none;" ></textarea>
                        </div>
                        <!-- GIF & Sticker Live Preview -->
                        <div v-if="commentGiphyContainer.length > 0" class="col-5 col-lg-2">
                            <!-- Show Loading if Data not ready yet -->
                             <div v-if="gifloading" class="row justify-content-center d-flex align-items-center" style="height:40vh">
                                   <div class="col-12 text-center">
                                       <img src="assets/icon/loadingdot.webp" class="w-25" alt="">
                                   </div>
                             </div>
                             <!-- Images Live Preview -->
                             <div V-else class="col-12 p-0">
                               <div class="position-relative d-inline-block">
                                 <img @click="removeImgPreview()" :src="commentGiphyContainer[0].url" :alt="commentGiphyContainer[0].url" style="width: 55px; height: 60px;width:60px"/>
                               </div>
                             </div>
                         </div>
                        <!-- Photo Comment Live Preview -->
                         <div v-if="photoCommentLivePreview.length > 0" class="col-4 col-lg-2">
                             <!-- Images Live Preview -->
                             <div class="mb-2" style="border-radius:5px;" id="imagePreview">
                                 <div class="col-12 p-0">
                                   <div class="position-relative d-inline-block">
                                     <img @click="removeImgPreview(photoCommentLivePreview[0].name)" :src="globalCommentPhoto" :alt="photoCommentLivePreview[0].name"  style="width: 55px; min-height: 55px;"/>
                                   </div>
                                 </div>
                               </div>
                         </div>
                         <div v-if="photoCommentLivePreview.length > 0" class="col-2 d-lg-none">
                         </div>
                         <!-- Upload Images Btn -->
                        <div v-if="photoCommentLivePreview.length == 0 && commentGiphyContainer.length == 0"  class="col-2 col-lg-1 comment-upload pt-2">
                           <div class="comment-select p-0">
                             <div class="comment-select-button" >
                               <i class="fa fa-camera position-absolute" style="font-size: 20px; top: 8px;right:12px;"></i>
                             </div>
                             <div @change="changePhotoComment">
                               <input type="file" id="commentphoto" name="commentphoto" class="comment-upload" accept="image/*">
                             </div>
                           </div>
                        </div>
                        <!-- Upload GIF Btn -->
                        <div v-if="photoCommentLivePreview.length == 0 && commentGiphyContainer.length == 0" class="col-2 col-lg-1 comment-upload pt-2">
                           <button @click="loadGiphyCommentPreview('gif')" data-bs-toggle="offcanvas" data-bs-target="#offcanvasGif" :style="globalColor" class="btn  border">GIF</button>
                        </div>
                        <!-- Upload Sticker Btn -->
                        <div v-if="photoCommentLivePreview.length == 0 && commentGiphyContainer.length == 0" class="col-2 col-lg-1 comment-upload pt-2">
                           <button @click="loadGiphyCommentPreview('sticker')" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSticker" :style="globalColor" class="btn  border"><i class="fa fa-smile"></i></button>
                        </div>
                        <div class="col-4 d-lg-none" style="height: 5vh;">
                        </div>
                        <div class="col-2 col-lg-3 pt-2">
                          <button @click="uploadReply(getAllReplys.comment[0].id)" class="btn border text-info"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
        </div>

        <!-- Giphy Gif -->
        <div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasGif" aria-labelledby="offcanvasGifLabel" :style="globalColor" style="z-index: 100003;min-height:60vh">
          <div class="offcanvas-header">
            <div class="row">
              <div class="col-8">
                 <input v-model="giphysearchgif" spellcheck="false" placeholder="Search GIFs . . ." class="bg-light border-0 p-2" style="width: 100%;border-radius:50px;height:40px;outline:none;" ></input>
              </div>
              <div class="col-2">
                <button @click="searchGiphy('gif')" class="btn btn-light"><i class="fa fa-search"></i></button>
              </div>
              <div class="col-2">
                 <button type="button" class="btn-close text-reset mt-1" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>
            </div>
          </div>
          <div class="offcanvas-body small">
             <div class="row">
               <div @click="selectGiphyItem(giphy.images.preview_gif.url)" v-for="giphy in photoCommentGiphy" data-bs-dismiss="offcanvas" class="col-4 col-md-3 col-lg-2 p-1">
                 <img :src="giphy.images.preview_gif.url" class="w-100" alt="">
               </div>
             </div>
          </div>
        </div>

        <!-- Giphy Sticker -->
        <div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasSticker" aria-labelledby="offcanvasSticker" :style="globalColor" style="z-index: 100003;min-height:60vh">
          <div class="offcanvas-header">
            <div class="row">
              <div class="col-8">
                 <input v-model="giphysearchsticker" spellcheck="false" placeholder="Search Stickers . . ." class="bg-light border-0 p-2" style="width: 100%;border-radius:50px;height:40px;outline:none;" ></input>
              </div>
              <div class="col-2">
                <button @click="searchGiphy('sticker')" class="btn btn-light"><i class="fa fa-search"></i></button>
              </div>
              <div class="col-2">
                 <button type="button" class="btn-close text-reset mt-1" data-bs-dismiss="offcanvas" aria-label="Close"></button>
              </div>
            </div>
          </div>
          <div class="offcanvas-body small">
             <div class="row">
               <div @click="selectGiphyItem(giphy.images.preview_gif.url)" v-for="giphy in photoCommentGiphy" data-bs-dismiss="offcanvas" class="col-4 col-md-3 col-lg-2 p-1">
                 <img :src="giphy.images.preview_gif.url" class="w-100" alt="">
               </div>
             </div>
          </div>
        </div>

        <!-- Modal Saved Post Place -->
        <div class="modal fade p-0 text-center" id="modalSavedPost" :style="{'z-index': zindex},globalColor" data-bs-backdrop="static" data-bs-keyboard="false" >
           <div class="modal-dialog modal-lg modal-dialog-scrollable m-auto" >
             <div class="modal-content border-0 p-1" :style="globalColor">
                  <!-- Modal Header -->
                 <div class="modal-header border-0" style="padding: 0 0 0 5px!important;" >
                     <div class="pt-3">
                       <p class="fs-5 fw-bold text-center">Save Post</p>
                     </div>
                 </div>
                  <!-- Modal Header End -->

                  <!-- Show Loading if Data not ready yet -->
                 <div v-if="saveloading" class="row justify-content-center d-flex align-items-center" style="height:90vh">
                     <div class="col-12 pb-5 mb-5 text-center">
                         <img src="assets/icon/loadingdot.webp" style="width: 120px;" alt="">
                     </div>
                 </div>

                 <div v-else  class="modal-body justify-content-left d-inline-block p-0 pt-3 pb-5 mb-5" style="min-height: 75vh;">

                    <div v-if="savepost.length == 0" class="row justify-content-center d-flex align-items-center" style="height:50vh">
                      <div class="col-12 text-center text-muted">
                        <i class="fa fa-inbox fa-2x pb-2 d-block" aria-hidden="true"></i>
                            <h7 class="pb-1">No Savepost Yet</h7>
                        </div>
                    </div>

                    <div v-else v-for="(post,i) in savepost" class="card mb-3 border shadow" >
                      <div  class="row g-0">
                        <div @click="globalViewPostModal(post.id,post.name)" class="col-4 col-md-3  text-start">
                          <div class="savepostimg" v-if="post.images[0] != ''">
                            <img :src="'uploads/'+post.path+'/'+post.images[0]"  alt="..">
                          </div>
                          <div class="savepostimg" v-else>
                            <img src="assets/icon/post.png"  alt="..">
                          </div>

                        </div>
                        <div @click="globalViewPostModal(post.id,post.name)" class="col-7 col-md-8 ">
                          <div class="card-body">
                            <p class="fs-6 card-title text-start" style="text-overflow: ellipsis;">{{ post.content.substr(0,60) }}</p>
                            <p class="card-text text-start position-relative" style="bottom: 0;"><small class="text-muted">{{post.time}}</small></p>
                          </div>
                        </div>
                        <div class="col-1 col-md-1">
                          <span @click="removeSavePost(post.id)" class="position-relative fa fa-times text-danger" style="top: 7px;"></span>
                        </div>
                      </div>
                    </div>
                 </div>

               <!-- Modal Content End-->
             </div>
          </div>
        </div>

         <!-- Modal GET STARTED Place -->
        <div class="modal fade p-0 text-center" id="modalGetStarted" style="z-index: 100000;" :style="globalColor" data-bs-backdrop="static" data-bs-keyboard="false" >
             <div class="modal-dialog modal-lg modal-dialog-scrollable m-auto">
               <div class="modal-content border-0 p-0 " :style="globalColor">
                  <div v-show="getstartFrist">
                   <!-- Modal Header -->
                   <div class="modal-header" style="padding: 10px 0 10px 5px!important;" :style="globalColor">
                        <!-- Like No Place -->
                      <div v-if="getstartFrist == true && profilePhoto.length != 0" class="col">
                        <i @click="getstartCaseTwo()" class="fa fa-arrow-right"></i>
                      </div>
                      <div v-else class="col">
                      <i @click="getStartModalClose()" class="fa fa-arrow-left"></i>
                      </div>
                      <div class="col-6 position-relative text-center m-2">
                        <span class="font-monospace">Update Your Profile</span>
                      </div>
                      <div class="col"></div>
                      <div @click="getStartModalClose()" class="col text-center m-2 btn-close">  </div>
                   </div>
                    <!-- Modal Header End -->
                   <div class="modal-body p-0 pt-3 pb-5 mb-5" style="min-height: 80vh;" :style="globalColor">
                       <div  class="col-12 col-lg-9 d-inline-block p-0 mb-2">
                          <p class="fw-bold fs-4 text-start p-2 mb-0 ">Add Profile Photo</p>
                          <p class=" p-3 mb-0 pt-0  text-start" style="letter-spacing: 1px;">A profile photo will help friends find you on Zakerxa Site and help others get to know you.</p>
                          <p class="text-muted text-start p-2">Profile photos will not shown on newfeeds</p>
                       </div>
                       <div id="image_demo" class="text-center" style="min-height: 30vh;" >
                           <div v-if="profilePhoto.length == 0" class="col-8 text-center d-inline-block col-md-5 col-lg-4">
                             <img  src="./assets/icon/sample-photo1.jpg" class="bg-light w-100" style="border-radius: 50%;" alt="">
                           </div>
                       </div>
                       <div v-if="profilePhoto.length == 0" class="col-12 text-center">
                            <!-- Upload Images Btn -->
                           <div  class=" text-center comment-upload pt-2">
                              <div class="comment-select w-75 d-inline-block p-0">
                                <div class="comment-select-button w-100 text-center" >
                                  <i class="fa fa-camera " style="font-size: 20px; bottom: 8px;"></i>
                                </div>
                                <div @change="changeGetStartedPhoto">
                                  <input type="file"  class="comment-upload" accept="image/*">
                                </div>
                              </div>
                           </div>
                       </div>
                   </div>
                    <div class="modal-footer p-0 pt-1 position-absolute w-100" style="bottom: 0;left:0;min-height:6vh;" :style="globalColor">
                       <div class="row justify-content-center">
                          <div v-if="profilePhoto.length == 0" class="col text-center">
                            <button disabled class="btn fw-bold btn-primary">Next</button>
                          </div>
                          <div v-else class="col text-center">
                            <button @click="getstartCaseTwo()" class="btn fw-bold btn-primary">Next</button>
                          </div>
                       </div>
                    </div>
                 </div>
                  <div v-show="getstartSec" class="">
                    <!-- Modal Header -->
                      <div class="modal-header" style="padding: 10px 0 10px 5px!important;" :style="globalColor">
                          <!-- Like No Place -->
                        <div class="col">
                          <i @click="getstartCaseOne()" v-if="getstartFrist != true" class="fa fa-arrow-left"></i>
                        </div>
                        <div class="col-6 position-relative text-center m-2">
                          <span class="font-monospace">Update Your Profile</span>
                        </div>
                        <div class="col"></div>
                        <div @click="getStartModalClose()" class="col text-center m-2 btn-close">  </div>
                      </div>
                       <div class="modal-body p-0 pt-3 pb-5 mb-5" style="min-height: 80vh;" :style="globalColor">
                           <div  class="col-12 col-lg-9 d-inline-block  p-0 mb-2">
                             <p class="fw-bold fs-4 text-start p-2 mb-0">Add Current City</p>
                             <p class=" p-3 mb-0 pt-0 text-start" style="letter-spacing: 1px;">Add your current city to see public posts and find friends in your area.</p>
                             <p class="text-muted text-start p-2"><i class="fa fa-globe"></i> Public</p>
                           </div>
                           <div class="col-11 col-lg-9 text-center d-inline-block">
                              <p class="text-start fw-bold fs-6 p-1 mb-1">Country</p>
                              <select class="form-select" aria-label="Disabled select example" disabled>
                                <option selected>Myanmar <span class="text-muted">Default</span></option>
                              </select>
                           </div>
                           <div class="col-11 col-lg-9 pt-4 text-center d-inline-block">
                              <p class="text-start fw-bold fs-6 p-1 mb-1">City</p>
                               <select v-model="city" class="form-select" aria-label="Default select example">
                                 <option value="Yangon">Yangon</option>
                                 <option value="Mandalay">Mandalay</option>
                                 <option value="Naypyidaw">Naypyidaw</option>
                                 <option value="Mawlamyine">Mawlamyine</option>
                                 <option value="Taunggyi">Taunggyi</option>
                                 <option value="Bago">Bago</option>
                                 <option value="Monywa">Monywa</option>
                                 <option value="Myitkyina">Myitkyina</option>
                                 <option value="Pathein">Pathein</option>
                                 <option value="Sittwe">Sittwe</option>
                                 <option value="Pyay">Pyay</option>
                                 <option value="Pakokku">Pakokku</option>
                                 <option value="Myeik">Myeik</option>
                                 <option value="Meiktila">Meiktila</option>
                                 <option value="Taungoo">Taungoo</option>
                                 <option value="Myingyan">Myingyan</option>
                                 <option value="Mogok">Mogok</option>
                                 <option value="Magway">Magway</option>
                                 <option value="Hinthada">Hinthada</option>
                                 <option value="Sagaing">Sagaing</option>
                                 <option value="Thanlyin">Thanlyin</option>
                                 <option value="Dawei">Dawei</option>
                                 <option value="Nyaunglebin">Nyaunglebin</option>
                                 <option value="Shwebo">Shwebo</option>
                                 <option value="Bhamo">Bhamo</option>
                                 <option value="Aunglan">Aunglan</option>
                                 <option value="Yenangyaung">Yenangyaung</option>
                                 <option value="Bogale">Bogale</option>
                                 <option value="Minbu">Minbu</option>
                                 <option value="Hlegu">Hlegu</option>
                                 <option value="Tharrawaddy">Tharrawaddy</option>
                                 <option value="Hakha">Hakha</option>
                                 <option value="Thayet">Thayet</option>
                               </select>
                           </div>
                       </div>
                        <div class="modal-footer p-0 pt-1 position-absolute w-100" style="bottom: 0;left:0;min-height:6vh;" :style="globalColor">
                           <div class="row justify-content-center">
                              <div v-if="city == ''" class="col text-center">
                                <button disabled class="btn fw-bold btn-primary">Next</button>
                              </div>
                              <div v-else class="col text-center">
                                <button @click="getstartCaseThree()" class="btn fw-bold btn-primary">Next</button>
                              </div>
                           </div>
                        </div>
                  </div>
                  <div v-show="getstartThird" class="">
                    <!-- Modal Header -->
                      <div class="modal-header" style="padding: 10px 0 10px 5px!important;" :style="globalColor">
                          <!-- Like No Place -->
                        <div class="col">
                          <i @click="getstartCaseTwo()" v-if="getstartSec != true" class="fa fa-arrow-left"></i>
                        </div>
                        <div class="col-6 position-relative text-center m-2">
                          <span class="font-monospace">Update Your Profile</span>
                        </div>
                        <div class="col"></div>
                        <div @click="getStartModalClose()" class="col text-center m-2 btn-close">  </div>
                      </div>
                       <div class="modal-body p-0 pt-3 pb-5 mb-5" style="min-height: 80vh;" :style="globalColor">
                           <div  class="col-12 col-lg-9 d-inline-block  p-0 mb-2">
                             <p class="fw-bold fs-4 text-start p-2 mb-0">Add Date of Birth</p>
                             <p class=" p-3 mb-0 pt-0 text-start" style="letter-spacing: 1px;">Add date of birth to know how old are you.</p>
                             <p class="text-muted text-start p-2"><i class="fa fa-globe"></i> Public</p>
                           </div>
                            <div class="col-11 col-lg-9 pt-4 text-center d-inline-block">
                             <p class="text-start fw-bold fs-6 p-1 mb-1">Date of Birth</p>
                               <vuejs-datepicker :bootstrap-styling="true"  placeholder="Select birthday" :format="customFormatter"></vuejs-datepicker>
                           </div>
                           <div class="col-11 col-lg-9 pt-4 text-center d-inline-block">
                             <p class="text-start fw-bold fs-6 p-1 mb-1">Male or Female</p>
                              <select v-model="gender" class="form-select" aria-label="Default select example">
                                 <option value="select">Select gender</option>
                                 <option value="Male">Male</option>
                                 <option value="Female">Female</option>
                                 <option value="Custom">Custom</option>
                               </select>
                           </div>
                       </div>
                        <div class="modal-footer p-0 pt-1 position-absolute w-100" style="bottom: 0;left:0;min-height:6vh;" :style="globalColor">
                           <div class="row justify-content-center">
                              <div v-if="birth == '' || gender == 'select'" class="col text-center">
                                <button disabled class="btn fw-bold btn-primary">Save</button>
                              </div>
                              <div v-else class="col text-center">
                                <button @click="uploadProfile()" class="btn fw-bold btn-primary">Save</button>
                              </div>
                           </div>
                        </div>
                  </div>
                  <div v-show="getstartFo" class="">
                    <!-- Modal Header -->
                      <div class="modal-header" style="padding: 10px 0 10px 5px!important;" :style="globalColor">
                          <!-- Like No Place -->
                        <div class="col">
                          <i @click="getStartModalClose()" v-if="getstartThird != true" class="fa fa-arrow-left"></i>
                        </div>
                        <div class="col-6 position-relative text-center m-2">
                          <span class="font-monospace pl-2">Update Your Profile</span>
                        </div>
                        <div class="col"></div>
                        <div @click="getStartModalClose()" class="col text-center m-2 btn-close">  </div>
                      </div>
                       <div class="modal-body p-0 pt-3 pb-5 mb-5" style="min-height: 80vh;" :style="globalColor">
                           <div  class="col-12 col-lg-9 d-inline-block  p-0 mb-2">
                             <p class="fw-bold fs-4 text-start p-2 mb-0">You're all done!</p>
                             <div class="row p-0 m-0 justify-content-left">
                             <div class="col-1"></div>
                               <div class="col-4">
                                  <img src="assets/icon/complete.png" class="w-100" alt="">
                               </div>
                             </div>
                             <p class=" p-1 mb-0 pt-4 font-monospace text-start">Thank you for visiting our website.</p>
                           </div>
                       </div>
                        <div class="modal-footer p-0 pt-1 position-absolute w-100" style="bottom: 0;left:0;min-height:6vh;" :style="globalColor">
                           <div class="row justify-content-center">
                              <div class="col text-center">
                                <button @click="getStartModalClose()" class="btn fw-bold btn-primary">Done</button>
                              </div>
                           </div>
                        </div>
                  </div>
               </div>
            </div>
        </div>

        <!-- Modal Reaction Show Place -->
        <div class="modal fade p-0 text-center" id="reactions" style="z-index: 100002;" :style="globalColor" data-bs-backdrop="static" data-bs-keyboard="false" >
           <div class="modal-dialog modal-lg modal-dialog-scrollable m-auto" >
             <div class="modal-content border-0 p-1" :style="globalColor">
                  <!-- Modal Header -->
                 <div class="modal-header border-0" style="padding: 0 0 0 5px!important;" >
                     <div class="pt-3 row w-100 p-0 m-0">
                       <p class="fs-6 fw-bold text-start col-8">People who reacted </p>
                       <div class="text-end col-4" v-for="react in reactionsUser.total">All {{react}}
                       
                       </div>
                     </div>
                 </div>
                  <!-- Modal Header End -->

                  <!-- Show Loading if Data not ready yet -->
                 <div v-if="reactionsLoading" class="row justify-content-center d-flex align-items-center" style="height:90vh">
                     <div class="col-12 pb-5 mb-5 text-center">
                         <img src="assets/icon/loadingdot.webp" style="width: 120px;" alt="">
                     </div>
                 </div>

                 <div v-else  class="modal-body justify-content-left d-inline-block p-0 pt-3 pb-5 mb-5" style="min-height: 75vh;">
                    <div @click="viewprofile(react.id)" class="row pb-2 w-100" v-for="react in reactionsUser.reaction">
                         <div class="col-10 text-start" >
                            <img :src="'profile/'+react.pic" class="" style="border-radius: 50px;width:35px;height:35px;" alt=""> {{react.username}}
                         </div>
                         <div class="col-2 text-end">
                           <i :class="react.name.toLowerCase()+'IconSmall'" class="likeTypeSmall"></i>
                        </div>
                    </div>
                 </div>

               <!-- Modal Content End-->
             </div>
          </div>
        </div>


        <!-- Post Setting -->
        <div class="offcanvas offcanvas-bottom" tabindex="-1" id="postsetting"  data-bs-keyboard="false"  :style="globalColor" style="z-index: 100004;height:30vh">
          <div class="offcanvas-body small">
           
               <div class="row justify-content-center">
                  <button v-if="settingSave != cookieId" @click="dbPostSetting(settingPost,'save')" class="col-lg-7 col-11 p-2 btn text-center shadow m-2" style="padding-left:4px!important;cursor:pointer;">
                    <i class="p-1 fa fa-bookmark"></i> Save post
                  </button>
                  <button v-else @click="removeSavePost(settingPost)" class="col-lg-7 col-11 p-2 btn text-center shadow m-2" style="padding-left:4px!important;cursor:pointer;">
                    <i class="p-1 fa fa-bookmark"></i> Unsave post
                  </button>
                  <button @click="dbPostSetting(settingPost,'hide')" class="col-lg-7 col-11 p-2 btn text-center shadow m-2" style="padding-left:4px!important;cursor:pointer;">
                    <i class="p-1 fa fa-window-close"></i> Hide post
                  </button>
                  <button disabled @click="dbPostSetting(settingPost,'report')" class="col-lg-7 col-11 p-2 btn text-center shadow m-2" style="padding-left:4px!important;cursor:pointer;">
                    <i class="p-1 fa fa-bug"></i> Report this post
                  </button>
                </div>
            
          </div>
        </div>

        <!-- ProfilePost Setting -->
        <div class="offcanvas offcanvas-bottom" tabindex="-1" id="profilepostsetting"  data-bs-keyboard="false"  :style="globalColor" style="z-index: 100004;height:30vh">
          <div class="offcanvas-body small">
              <div class="row justify-content-center">
                 <div @click="profileEditPostF(profileEditPostId)" class="col-lg-7 col-11 p-2 btn text-center shadow m-2" style="padding-left:4px!important;cursor:pointer;">
                   <i class="p-1 fa fa-link"></i> Edit Post
                 </div>
                 <div @click="profileDelPost(profileEditPostId)"  class="col-lg-7 col-11 p-2 btn text-center shadow m-2" style="padding-left:4px!important;cursor:pointer;">
                   <i class="p-1 fa fa-bug"></i> Delete post
                 </div>
               </div>
          </div>
        </div>

       <!-- View Post Modal  -->
        <div class="modal fade p-0" id="globalPostView" style="width:100vw;" :style="{'z-index': zindex},globalColor" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg m-auto modal-dialog-scrollable">
                <div class="modal-content border-0 p-1" :style="globalColor">
                   <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabel">{{globalPostName}}</h5>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                   </div>
                   <!-- Modal Body -->
                   <div class="modal-body p-1 pb-5 mb-5" style="min-height: 75vh;" id="postviewId" style="overflow: scroll;">
                      <div v-for="post in globalPostViewContainer.post" class="" >
                         <div class="col-10 pt-2 position-relative">
                             <img :src="'profile/'+post.pic" style="border-radius: 50px;width:45px;height:45px" alt="">
                             <div style="top:13px;left:62px;" class="position-absolute mb-0">
                                 <p class="d-inline"
                                     style="font-size: 15px;font-weight:500;cursor:pointer;">{{post.name}}
                                 </p>
                                 <small class="text-muted d-block"
                                     style="font-size:12px;">{{post.time}} <i
                                         :class="post.category" class="fa"></i></small>
                             </div>
                         </div>
                         <!-- Content And Link -->
                          <p class="pt-4 p-2" style="white-space:pre-wrap;font-size:14px;">{{post.content.toString()}}</p>
                          <div v-show="post.link[0] != ''">
                            <a v-for="url in post.link" target="blank" class="d-block p-1" :href="url">{{url}}</a>
                          </div>
                         <div v-if="post.images[0] != ''" class="row justify-content-center w-100 p-0 m-0">
                             <!-- Remove row element if images does't exist -->
                             <div v-for="(img,i) in post.images" class="col-12 col-lg-5 p-lg-4 text-center p-0 mt-3 ">
                                 <img @click="modalImgSoloView(img)" class="img-thumbnail shadow" :id="'solo'+img" :src="'uploads/'+post.path+'/'+img"
                                     alt="..." style="width:100%;">
                             </div>
                         </div>
                          <hr class="m-2">
                         <div class="row w-100 m-0">
                             <div class="col-5 position-relative" style="padding-left:0!important;">
                              <!-- Like No Place -->
                                 <span class="text-muted position-relative" style="font-size: 12px;left:10px;">
                                    <span v-if="post.reactions == 0">Be the first to Like.</span>
                                    <span style="cursor:pointer;" @click="reactions(post.token)" v-if="(post.like_user == cookieId) && (post.reactions == 1)">
                                       <i v-if="post.react_no[0] != 0" :class="post.react_name[0]+'IconSmall'" class="likeTypeSmall pl-2"></i>
                                       <i v-if="post.react_no[1] != 0" :class="post.react_name[1]+'IconSmall'" class="likeTypeSmall pl-2"></i>
                                       <i v-if="post.react_no[2] != 0" :class="post.react_name[2]+'IconSmall'" class="likeTypeSmall pl-2"></i>
                                        You {{ cookieName }}</span>
                                    <span style="cursor:pointer;" @click="reactions(post.token)" v-if="(post.like_user == cookieId) && (post.reactions  > 1)">
                                       <i v-if="post.react_no[0] != 0" :class="post.react_name[0]+'IconSmall'" class="likeTypeSmall pl-2"></i>
                                       <i v-if="post.react_no[1] != 0" :class="post.react_name[1]+'IconSmall'" class="likeTypeSmall pl-2"></i>
                                       <i v-if="post.react_no[2] != 0" :class="post.react_name[2]+'IconSmall'" class="likeTypeSmall pl-2"></i>
                                        You and {{ post.reactions - 1 }} others</span>
                                    <span style="cursor:pointer;" @click="reactions(post.token)" v-if="(post.like_user != cookieId) && (post.reactions == 1)">
                                       <i v-if="post.react_no[0] != 0" :class="post.react_name[0]+'IconSmall'" class="likeTypeSmall pl-2"></i>
                                       <i v-if="post.react_no[1] != 0" :class="post.react_name[1]+'IconSmall'" class="likeTypeSmall pl-2"></i>
                                       <i v-if="post.react_no[2] != 0" :class="post.react_name[2]+'IconSmall'" class="likeTypeSmall pl-2"></i>
                                        {{ post.reactionsnc }} like</span>
                                    <span style="cursor:pointer;" @click="reactions(post.token)" v-if="(post.like_user != cookieId) && (post.reactions > 1)">
                                       <i v-if="post.react_no[0] != 0" :class="post.react_name[0]+'IconSmall'" class="likeTypeSmall pl-2"></i>
                                       <i v-if="post.react_no[1] != 0" :class="post.react_name[1]+'IconSmall'" class="likeTypeSmall pl-2"></i>
                                       <i v-if="post.react_no[2] != 0" :class="post.react_name[2]+'IconSmall'" class="likeTypeSmall pl-2"></i>
                                        {{ post.reactionsnc }} likes</span>
                                 </span>
                             </div>
                             <div class="col-4 position-relative p-0">
                              <!--Comment No Place  -->
                                 <span v-if="post.comments == 0" class="text-muted position-absolute" style="font-size: 12px;right:0;bottom:2px;"> </span>
                                 <span v-if="post.comments == 1" class="text-muted position-absolute" style="font-size: 12px;right:0;bottom:2px;cursor:pointer;"> {{ post.commentsnc }} Comment</span>
                                 <span v-if="post.comments > 1" class="text-muted position-absolute" style="font-size: 12px;right:0;bottom:2px;cursor:pointer;"> {{ post.commentsnc }} Comments</span>
                             </div>
                             <div class="col-2 position-relative p-0">
                              <!--Unlike No Place  -->
                                 <span v-if="post.unlikes == 0" class="text-muted position-absolute" style="font-size: 12px;right:0;bottom:2px;"></span>
                                 <span v-if="post.unlikes > 0" class="text-muted position-absolute" style="font-size: 12px;right:0;bottom:2px;">{{ post.unlikesnc }} Unlike</span>
                             </div>
                         </div>
                          <hr class="m-2">
                      </div>
                       <!-- Comment Show  -->
                          <div  v-if="getAllComments != null" v-for="(cm,cmindex) in getAllComments" class="col-11 text-left d-inline-block position-relative p-0 mb-3">
                            <!-- If Commenter is me Change Bg & Color -->
                               <div v-if="cm.user == cookieId" class="">
                                  <img :src="'profile/'+cm.pic"  class="position-absolute mb-0" style="border-radius: 50px;width:45px;height:45px;top:0;left:0;" alt="">
                                  <div class="pl-3  position-relative text-left" style="width:90%;min-height:10px;left:50px;top:0;border-radius:10px;text-align:left;background:#EBF7FF;" >
                                     <p class="d-inline-block m-0 text-dark" style="font-size: 15px;font-weight:500;padding-top:5px!important;padding-left:10px!important;"> {{cm.uname}}</p>
                                     <readmore-post :post="cm.content.toString()" style="padding: 0 0 4px 10px!important;color:#444" :link="cm.link" :index="cmindex" ></readmore-post>
                                  </div>
                                  <div v-if="cm.check_photo != ''" class="col-lg-6">
                                    <img v-if="cm.check_photo.includes('giphy.com')" :src="cm.check_photo" class="position-relative mb-0" style="border-radius: 10px;height:100px;max-width:130px;top:2px;left:50px;" alt="">
                                    <img v-else :src="cm.photo" class="position-relative mb-0" style="border-radius: 10px;height:100px;max-width:130px;top:2px;left:50px;" alt="">
                                  </div>
                               </div>
                                <!-- If Commenter is not me Default Bg & Color -->
                               <div v-else class="">
                                  <img :src="'profile/'+cm.pic"  class="position-absolute mb-0" style="border-radius: 50px;width:45px;height:45px;top:0;left:0;" alt="">
                                  <div class="pl-3  position-relative text-left" style="width:90%;min-height:10px;left:50px;top:0;border-radius:10px;text-align:left;" :style="globalComment">
                                     <p class="d-inline-block m-0" style="font-size: 15px;font-weight:500;padding-top:5px!important;padding-left:10px!important;"> {{cm.uname}}</p>
                                     <readmore-post :post="cm.content.toString()" style="padding: 0 0 4px 10px!important;" :link="cm.link" :index="cmindex" ></readmore-post>
                                  </div>
                                  <div v-if="cm.check_photo != ''" class="col-lg-6">
                                    <img v-if="cm.check_photo.includes('giphy.com')" :src="cm.check_photo" class="position-relative mb-0" style="border-radius: 10px;height:100px;max-width:130px;top:2px;left:50px;" alt="">
                                    <img v-else :src="cm.photo" class="position-relative mb-0" style="border-radius: 10px;height:100px;max-width:130px;top:2px;left:50px;" alt="">
                                  </div>
                               </div>
                               <!-- footer -->
                                <div class="row justify-content-right pt-1">
                                     <div class="col-2 col-md-1"></div>
                                     <div class="col-2 col-md-1 p-0 small text-muted">
                                         {{cm.time}}
                                     </div>
                                     <div class="col-1 col-md-1 p-0 small text-muted">
                                         <div v-if="cm.like_user == cookieId" class="text-primary" @click="uncmlikes(cm.id)">
                                           Like
                                         </div>
                                         <div v-else class="text-muted" @click="cmlikes(cm.id)">
                                           Like
                                         </div>
                                     </div>
                                     <div @click="showModalReply(cm.id)" class="col-3 col-md-2 small text-muted">
                                         Reply
                                     </div>
                                     <div v-if="cm.likes == 0" class="col-3 col-md-2 small text-muted"></div>
                                     <div v-if="cm.likes > 0" class="col-3 col-md-2 small text-muted"><i class="fa text-primary fa-thumbs-up"></i> {{ cm.likes }} </div>
                                     <div class="col-1 col-md-4"></div>
                                </div>
                               <!-- footer end -->
                              <!-- Reply Comment Show -->
                                <div v-if="cm.reply > 0" href="eee" class="row justify-content-right pt-1">
                                   <div class="col-10 text-right d-inline-block position-relative" @click="showModalReply(cm.id)" >
                                     <div v-if="cm.rp_user == cookieId">
                                       <img :src="'profile/'+cm.rp_user_pic"  class="position-absolute mb-0" style="border-radius: 50px;width:30px;top:3px;left:70px;" alt="">
                                        <div class="pl-3  position-relative text-left" style="min-height:10px;width:95%;left:91px;top:0;border-radius:10px;text-align:left;background:#EBF7FF;">
                                            <p class="d-inline-block m-0 text-dark" style="font-size: 15px;font-weight:500;padding-top:5px!important;padding-left:5px!important;">{{cm.rp_user_name}}</p>
                                            <div  class="p-1" style="white-space:nowrap;overflow:hidden;text-overflow: ellipsis;padding-left:10px!important;font-size:15px;color:#444;">{{cm.rp_user_content.toString().substr(0, 135)}} </span>
                                             </div>
                                        </div>
                                     </div>
                                     <div v-else>
                                        <img :src="'profile/'+cm.rp_user_pic"  class="position-absolute mb-0" style="border-radius: 50px;width:30px;top:3px;left:70px;" alt="">
                                        <div class="pl-3  position-relative text-left" style="min-height:10px;width:95%;left:91px;top:0;border-radius:10px;text-align:left;" :style="globalComment">
                                            <p class="d-inline-block m-0" style="font-size: 15px;font-weight:500;padding-top:5px!important;padding-left:5px!important;">{{cm.rp_user_name}}</p>
                                            <div  class="p-1" style="white-space:nowrap;overflow:hidden;text-overflow: ellipsis;padding-left:10px!important;font-size:15px;">{{cm.rp_user_content.toString().substr(0, 135)}} </span>
                                             </div>
                                        </div>
                                     </div>
                                      <div v-if="cm.viewmorereply" class="pt-2 pb-2 text-start" style="padding-left:94px!important;">
                                        <b><small>View 1 more reply...</small></b>
                                      </div>
                                   </div>
                                </div>
                               <!-- Reply Comment Show -->
                          </div>
                      <!-- Comment Show End -->
                   </div>

                    <div class="modal-footer p-0 pt-1 position-absolute w-100" style="bottom: 0;left:0;min-height:10vh;" :style="globalColor">
                       <div class="row w-100" :style="globalColor">
                          <div class="col-12 col-lg-6 pb-2 pt-lg-2">
                             <textarea name="" v-model="commentText" id="" spellcheck="false" placeholder=" Write a comment . . ." class="bg-light border-0 p-2" style="width: 100%;border-radius:50px;height:40px;outline:none;" ></textarea>
                          </div>
                          <!-- GIF & Sticker Live Preview -->
                          <div v-if="commentGiphyContainer.length > 0" class="col-5 col-lg-2">
                              <!-- Show Loading if Data not ready yet -->
                                <div v-if="gifloading" class="row justify-content-center d-flex align-items-center" style="height:40vh">
                                      <div class="col-12 text-center">
                                          <img src="./assets/icon/loadingdot.webp" class="w-25" alt="">
                                      </div>
                                </div>
                               <!-- Images Live Preview -->
                               <div V-else class="col-12 p-0">
                                 <div class="position-relative d-inline-block">
                                   <img @click="removeImgPreview()" :src="commentGiphyContainer[0].url" :alt="commentGiphyContainer[0].url" style="width: 55px; height: 60px;width:60px"/>
                                 </div>
                               </div>
                           </div>
                          <!-- Photo Comment Live Preview -->
                           <div v-if="photoCommentLivePreview.length > 0" class="col-4 col-lg-2">
                               <!-- Images Live Preview -->
                               <div class="mb-2" style="border-radius:5px;" id="imagePreview">
                                   <div class="col-12 p-0">
                                     <div class="position-relative d-inline-block">
                                       <img @click="removeImgPreview(photoCommentLivePreview[0].name)" :src="globalCommentPhoto" :alt="photoCommentLivePreview[0].name"  style="width: 55px; min-height: 55px;"/>
                                     </div>
                                   </div>
                                 </div>
                           </div>
                           <div v-if="photoCommentLivePreview.length > 0" class="col-2 d-lg-none">
                           </div>
                           <!-- Upload Images Btn -->
                          <div v-if="photoCommentLivePreview.length == 0 && commentGiphyContainer.length == 0" class="col-2 col-lg-1 comment-upload pt-2">
                             <div class="comment-select p-0">
                               <div class="comment-select-button" >
                                 <i class="fa fa-camera position-absolute" style="font-size: 20px; top: 8px;right:12px;"></i>
                               </div>
                               <div @change="changePhotoComment">
                                 <input type="file" id="commentphoto" name="commentphoto" class="comment-upload" accept="image/*">
                               </div>
                             </div>
                          </div>
                          <!-- Upload GIF Btn -->
                          <div v-if="photoCommentLivePreview.length == 0 && commentGiphyContainer.length == 0" class="col-2 col-lg-1 comment-upload pt-2">
                             <button @click="loadGiphyCommentPreview('gif')" data-bs-toggle="offcanvas" data-bs-target="#offcanvasGif" class="btn  border" :style="globalColor">GIF</button>
                          </div>
                          <!-- Upload Images Btn -->
                          <div v-if="photoCommentLivePreview.length == 0 && commentGiphyContainer.length == 0" class="col-2 col-lg-1 comment-upload pt-2">
                             <button  @click="loadGiphyCommentPreview('sticker')" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSticker" class="btn  border" :style="globalColor"><i class="fa fa-smile"></i></button>
                          </div>
                          <div class="col-4 d-lg-none" style="height: 5vh;">
                          </div>
                          <div class="col-2 col-lg-3 pt-2">
                            <button @click="uploadComment(globalcommentId)" class="btn border text-info"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                          </div>
                       </div>
                    </div>
              </div>
            </div>
        </div>
        
        <!-- Modal Profile Show Place -->
        <div class="modal fade p-0 text-center" id="profile" :style="{'z-index': zindex},globalColor" data-bs-backdrop="static" data-bs-keyboard="false" >
           <div class="modal-dialog modal-lg modal-dialog-scrollable m-auto" >
             <div class="modal-content border-0 p-1" :style="globalColor">
         
                  
                  <!-- Show Loading if Data not ready yet -->
                 <div v-if="profileViewLoading" class="row align-items-center justify-content-center" style="height:100vh;background:#fff;">
                     <div class="col-12 text-center">
                         <img src="assets/icon/loadingdot.webp" style="width: 120px;" alt="">
                     </div>
                 </div>

                 <div v-else  class="modal-body justify-content-left d-inline-block mb-5" style="min-height: 75vh;">

                    <div class="row profileBg position-relative m-md-0" :style="globalColor">
   
                      <div class="col-12 card border-0 p-0" :style="globalColor">   
                          <img v-if="globalFriProfile.cv != ''" :src="'profile/'+globalFriProfile.cv" class="card-img-top pt-1 img-thumbnail cvphoto"  alt="">
                          <img v-if="globalFriProfile.cv == ''" src="profile/cp.jpg" class="card-img-top pt-1 img-thumbnail cvphoto"  alt="">

                          <div id="image_profile" class="text-center position-relative text-center" style="bottom: 100px;">
                             <div class="col-6 text-center d-inline-block col-md-5 col-lg-4" style="background:transparent">
                               <img :src="'profile/'+globalFriProfile.pic" class="bg-light w-100 img-thumbnail" style="border-radius: 50%;" alt="">
                             </div>
                             <p class="fs-4 fw-bold text-center mt-2">
                               <i v-if="globalFriProfile.row == 0" class="fa fa-star-half" style="color: #FFFF00;"></i>
                               <i v-if="globalFriProfile.row == 1" class="fa fa-star" style="color: #33ff22;"></i>
                               <i v-if="globalFriProfile.row == 2" class="fa fa-star cf"></i>
                               <i v-if="globalFriProfile.row == 3" class="fa fa-check-circle text-primary"></i>
                                {{globalFriProfile.name}}
                              </p>  
                             <p v-if="globalFriProfile.bio == ''" class="fs-7 text-center text-center">This User is Lazy to write something</p>  
                             <p v-else class="fs-7 text-center">{{globalFriProfile.bio}}</p>  
                          </div>
                      </div>
                     
                    </div>

                    <div class="row position-relative p-2 m-md-0" :style="globalColor">

                      <p class="col-6 small text-start p-1">
                        <i class="fa fa-home"></i>
                         Country <span class="fw-bold">{{globalFriProfile.country}}</span>
                      </p>
                      <p class="col-6 small text-start p-1">
                        <i class="fa fa-street-view"></i>
                         Lives in <span class="fw-bold">{{globalFriProfile.city}}</span>
                      </p>
                      <p class="col-6 small text-start p-1">
                        <i class="fa fa-users"></i>
                         Friends <span class="fw-bold">1.2k</span>
                      </p>
                      <p v-if="globalFriProfile.row == 0" class="col-6 small text-start p-1">
                        <i class=" fa fa-star-half"></i>
                         Normal User
                      </p>
                      <p v-if="globalFriProfile.row == 1" class="col-6 small text-start p-1">
                        <i class="fa fa-star"></i>
                         Advenced User
                      </p>
                      <p v-if="globalFriProfile.row == 2" class="col-6 small text-start p-1">
                        <i class="fa fa-check-circle text-primary"></i>
                         Pro User
                      </p>
                      <p v-if="globalFriProfile.row == 3" class="col-6 small text-start p-1">
                        <i class="fa fa-check-circle"></i> 
                        Pro User
                      </p>
                      <p class="col-6 small text-start p-1">
                        <i class="fa fa-calendar"></i> 
                        Birth <span class="fw-bold">{{globalFriProfile.birth}}</span>
                      </p>
                      <p class="col-6 small text-start p-1">
                        <i class="fa fa-clock"></i> 
                        Joined <span class="fw-bold">{{globalFriProfile.date}}</span>
                      </p>
                      
                    </div>

                    <div v-if="globalFriPosts != null">
                        
                          <!-- Start Looping Array Container  -->
                          <div class="row pt-2 pb-1 mt-lg-1 justify-content-center m-md-0" v-for="(post,index) in globalFriPosts">
      
                              <!-- Post Type Start-->
                              <div v-if="post.type == 'post'" class="card" :id="'sourceslider'+index" :style="globalColor">
      
                                <!-- Card Body Start -->
                                  <div class="card-body p-0">
      
                                    <!-- Post Header Start -->
                                      <div class="row pb-2 pt-2">
                                          <div class="col-10 position-relative text-start">
                                              <img :src="'profile/'+post.pic" class="" style="border-radius: 50px;width:45px;height:45px;" alt="">
                                              <div style="top:0;left:62px;" class="position-absolute mb-0">
                                                  <p class="d-inline" style="font-size: 15px;font-weight:500;cursor:pointer;">
                                                      {{post.name}}</p>
                                                  <small class="text-muted d-block" style="font-size:12px;">{{post.time}}
                                                      <i :class="post.category" class="fa"></i></small>
                                              </div>
                                          </div>
      
                                          <div class="col-2 position-relative">
                                            <b @click="postsetting(post.id,post.save,post.category)" id="dropdownMenuButton1" style="right: 0;cursor:pointer;" >. . .</b> 
                                          </div>
                                      </div>
      
                                    <!-- Post Header End -->

                                    <!-- Post Content Place -->
                                    <readmore-post :post="post.content.toString()" class="text-start" :link="post.link" :index="index+'profile'" ></readmore-post>
    
      
                                   <!-- Post Content End -->
      
                                  </div>
                                <!-- Card Body End -->
      
                                 <!-- Post Images Place Start -->
                                  <div class="row pt-2" v-if="post.images[0] != ''">
      
                                    <div v-if="post.images.length == 1" class="position-relative w-100 p-0">
                                      <div class="col-12 p-0 position-relative">
                                        <img v-for="(img,i) in post.images" class="fullscreen w-100" :id="'image'+img" style="max-height: 75vh;" :src="'uploads/'+post.path+'/'+img" alt="...">
                                      </div>
                                    </div>
      
                                    <!-- Image 2 -->
                                    <div v-if="post.images.length == 2" v-for="(img,i) in post.images" class="col-6 p-0 postImg">
                                        <img class="fullscreen w-100" :id="'image'+img" :src="'uploads/'+post.path+'/'+img" alt="...">
                                    </div>
      
                                    <div v-if="post.images.length == 3" class="row p-0 m-0 w-100">
                                       <div class="p-0 postImg col-6">
                                          <img class="fullscreen w-100" :src="'uploads/'+post.path+'/'+post.images[0]" alt="">
                                        </div>
                                        <div class="p-0 postImg col-6 position-relative">
                                          <img class="fullscreen w-100" :src="'uploads/'+post.path+'/'+post.images[1]" alt="">
                                          <div class="position-absolute" style="bottom:4%;right:6%;border-radius:50%;width:50px;height:50px;background:rgb(0, 0, 0, 0.7);">
                                             <div class="justify-conent-center align-items-center d-flex h-100">
                                               <div v-if="post.images.length >= 2" class="col text-center fw-bold fs-4 text-light">+{{post.images.length - 2}}</div>
                                             </div>
                                          </div>
                                        </div>
      
                                    </div>
      
                                    <!-- Image 4  -->
                                    <div v-if="post.images.length == 4" v-for="(img,i) in post.images" class="col-6 p-0 postImg">
                                     <!-- Remove row element if images does't exist -->
                                        <img class="fullscreen w-100" :id="'image'+img" :src="'uploads/'+post.path+'/'+img" alt="...">
                                    </div>
      
                                    <!-- Image Greater than 4 -->
                                    <div v-if="post.images.length > 4" class="row p-0 m-0 w-100">
                                     <!-- Remove row element if images does't exist -->
                                        <div class="p-0 postImg col-6">
                                          <img class="fullscreen img-thumbnail w-100" :src="'uploads/'+post.path+'/'+post.images[0]" alt="">
                                        </div>
                                        <div class="p-0 postImg col-6">
                                          <img class="fullscreen img-thumbnail w-100" :src="'uploads/'+post.path+'/'+post.images[1]" alt="">
                                        </div>
                                        <div class="p-0 postImg col-6">
                                          <img class="fullscreen img-thumbnail w-100" :src="'uploads/'+post.path+'/'+post.images[2]" alt="">
                                        </div>
                                        <div class="p-0 postImg col-6 position-relative">
                                          <img class="fullscreen img-thumbnail w-100" :src="'uploads/'+post.path+'/'+post.images[3]" alt="">
                                          <div class="position-absolute w-100 h-100" style="top:0;background:rgb(0, 0, 0, 0.3);">
                                             <div class="justify-conent-center align-items-center d-flex h-100">
                                               <div v-if="post.images.length >= 5" class="col text-center fw-bold fs-4 text-light">+{{post.images.length - 4}}</div>
                                             </div>
                                          </div>
                                        </div>
                                        <!-- <img @click="globalViewPostModal(post.id,post.name)" class="fullscreen w-100" :id="'image'+img" :src="'uploads/'+post.path+'/'+img" alt="..."> -->
                                    </div>
      
      
                                  </div>
                                 <!-- Post Images Place End -->
      
                                  <!-- Post Like and Comments -->
                                    <div class="row" :id="post.token">
      
                                      <div class="row border-bottom pt-1 pb-1">
      
                                          <div class="col-5 position-relative" style="padding-right:0!important;">
                                           <!-- Like No Place -->
                                              <span class="text-muted" style="font-size: 12px;">
                                                 <span v-if="post.reactions == 0">Be the first to Like.</span>
                                                 <span style="cursor:pointer;" @click="reactions(post.token)" v-if="(post.like_user == cookieId) && (post.reactions == 1)">
                                                    <i v-if="post.react_no[0] != 0" :class="post.react_name[0]+'IconSmall'" class="likeTypeSmall"></i>
                                                    <i v-if="post.react_no[1] != 0" :class="post.react_name[1]+'IconSmall'" class="likeTypeSmall"></i>
                                                    <i v-if="post.react_no[2] != 0" :class="post.react_name[2]+'IconSmall'" class="likeTypeSmall"></i>
                                                     You {{ cookieName }}</span>
                                                 <span style="cursor:pointer;" @click="reactions(post.token)" v-if="(post.like_user == cookieId) && (post.reactions  > 1)">
                                                    <i v-if="post.react_no[0] != 0" :class="post.react_name[0]+'IconSmall'" class="likeTypeSmall"></i>
                                                    <i v-if="post.react_no[1] != 0" :class="post.react_name[1]+'IconSmall'" class="likeTypeSmall"></i>
                                                    <i v-if="post.react_no[2] != 0" :class="post.react_name[2]+'IconSmall'" class="likeTypeSmall"></i>
                                                     You and {{ post.reactions - 1 }} others</span>
                                                 <span style="cursor:pointer;" @click="reactions(post.token)" v-if="(post.like_user != cookieId) && (post.reactions == 1)">
                                                    <i v-if="post.react_no[0] != 0" :class="post.react_name[0]+'IconSmall'" class="likeTypeSmall"></i>
                                                    <i v-if="post.react_no[1] != 0" :class="post.react_name[1]+'IconSmall'" class="likeTypeSmall"></i>
                                                    <i v-if="post.react_no[2] != 0" :class="post.react_name[2]+'IconSmall'" class="likeTypeSmall"></i>
                                                     {{ post.reactionsnc }} like</span>
                                                 <span style="cursor:pointer;" @click="reactions(post.token)" v-if="(post.like_user != cookieId) && (post.reactions > 1)">
                                                    <i v-if="post.react_no[0] != 0" :class="post.react_name[0]+'IconSmall'" class="likeTypeSmall"></i>
                                                    <i v-if="post.react_no[1] != 0" :class="post.react_name[1]+'IconSmall'" class="likeTypeSmall"></i>
                                                    <i v-if="post.react_no[2] != 0" :class="post.react_name[2]+'IconSmall'" class="likeTypeSmall"></i>
                                                     {{ post.reactionsnc }} likes</span>
                                              </span>
                                          </div>
      
                                          <div class="col-4 position-relative p-0">
                                           <!--Comment No Place  -->
                                              <span v-if="post.comments == 0" class="text-muted position-absolute" style="font-size: 12px;right:0;bottom:2px;"> </span>
                                              <span v-if="post.comments == 1" class="text-muted position-absolute" style="font-size: 12px;right:0;bottom:2px;cursor:pointer;"> {{ post.commentsnc }} Comment</span>
                                              <span v-if="post.comments > 1" class="text-muted position-absolute" style="font-size: 12px;right:0;bottom:2px;cursor:pointer;"> {{ post.commentsnc }} Comments</span>
                                          </div>
      
                                          <div class="col-3 position-relative p-0">
                                           <!--Unlike No Place  -->
                                              <span v-if="post.unlikes == 0" class="text-muted position-absolute" style="font-size: 12px;right:0;bottom:2px;"></span>
                                              <span v-if="post.unlikes > 0" class="text-muted position-absolute" style="font-size: 12px;right:0;bottom:2px;">{{ post.unlikesnc }} Unlike</span>
                                          </div>
      
                                      </div>
                                      <!-- Like   -->
                                      <div class="col-12 p-0">
                                         <button :style="globalColor" v-if="post.like_user == cookieId" :id="'like'+post.token" @click="vueunlikes(post.token)" rel="unlike" class="unLike w-100 text-primary border-0" style="padding:7px 0;background:#fff;min-height:45px;">
                                           <i :class="post.like_emoj+'IconSmall'" class="text-primary likeTypeSmall" aria-hidden="true"></i>
                                           <span style="font-size: 12px;">{{post.like_emoji}}</span>
                                         </button>
     
                                         <button :style="globalColor" v-else  :id="'like'+post.token" rel="like" class="reaction w-100 text-muted border-0" style="padding:7px 0;background:#fff;min-height:45px;">
                                           <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                           <span style="font-size: 12px;">Like</span>
                                         </button>
                                      </div>
                                     
                                    </div>
                                  <!-- Post Like and Comments End -->
  
      
      
      
                              </div>
                              <!-- Post Type End -->
      
                              <!-- Blog Type Start-->
                              <div v-if="post.type == 'blog'" class="card col-lg-6">
                                  <h3>This is Blog Post</h3>
                                  <p>
                                      Lorem ipsum dolor sit amet consectetur adipisicing elit. Animi quibusdam
                                      reprehenderit dicta quas consequuntur nobis perspiciatis rerum delectus voluptas
                                      voluptates aliquid hic quidem impedit officiis, aspernatur totam accusamus soluta
                                      eos?
                                  </p>
                              </div>
                              <!-- Blog Type End -->
      
                              <!-- Share Type Start-->
                              <div v-if="post.type == 'share'" class="card col-lg-6">
                                  <h3>This is Share Post</h3>
                                  <p>
                                      Lorem ipsum dolor sit, amet consectetur adipisicing elit. Velit iste animi nobis
                                      explicabo, necessitatibus et culpa? Sequi, accusamus? Laudantium sunt possimus
                                      voluptate amet. Aperiam quaerat, cupiditate corrupti consectetur ipsa quod?
                                  </p>
                              </div>
                              <!-- Share Type End -->
      
                          </div>     
                     </div>
                    

                 </div>

               <!-- Modal Content End-->
             </div>
          </div>
        </div>

       
        














       <!-- Global Toast Notification -->
       <div v-if="globalToastMsg" id="globalNoti" data-bs-delay="3000" class="toast start-50 translate-middle-x text-white bg-dark border-0 position-fixed" style="bottom:30px;z-index:100003" role="alert" aria-live="assertive" aria-atomic="true">
         <div class="d-flex">
           <div class="toast-body">
              <p class="m-0">{{globalNoti}}</p>
           </div>
           <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
         </div>
       </div>

       <div v-if="addPostToastMsg" id="postUploaded" data-bs-delay="3000" class="toast start-50 translate-middle-x text-white bg-dark border-0 position-fixed" style="bottom:30px;z-index:100003" role="alert" aria-live="assertive" aria-atomic="true">
         <div class="d-flex">
           <div class="toast-body">
              <p class="m-0">Your post was shared.</p>
           </div>
           <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
         </div>
       </div>

       <div v-if="addPostToastMsg" id="postUploadError" data-bs-delay="3000" class="toast start-50 translate-middle-x text-white bg-danger border-0 position-fixed" style="bottom:30px;z-index:100003" role="alert" aria-live="assertive" aria-atomic="true">
         <div class="d-flex">
           <div class="toast-body">
              <p class="m-0">{{globalToastError}}</p>
           </div>
           <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
         </div>
       </div>





        <!-- container end -->
    </div>

    <!-- id authuser end -->
</div>






<script src="https://cdn.jsdelivr.net/npm/vue@2.6.11"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

<script src="assets/js/modal.js" type="text/javascript"></script>
<script src="assets/js/moment.min.js"></script>
<script src="assets/js/datepicker.js"></script>
<script src="assets/js/jquery.livequery.js"></script>
<script src="assets/js/jquery.tooltipsterReaction.js"></script>
<script src="assets/js/vue-loader.js"></script>


<script src="croppie/croppie.min.js" type="text/javascript" charset="utf-8"></script>


<script rel="preload" src="vueTemplate/friRequestBtn.js"></script>
<script rel="preload" src="vueTemplate/friRelationBtn.js"></script>
<script rel="preload" src="vueTemplate/addNewPost.js"></script>
<script rel="preload" src="vueTemplate/readmorePost.js"></script>
<script rel="preload" src="vueTemplate/editPost.js"></script>


<!-- <script src="slick/slick/slick.min.js" type="text/javascript"></script> -->

<!-- <script src="https://cdnjs.deepai.org/deepai.min.js"></script> -->
<!-- <script src="adult.js"></script> -->

<script >

let app     = document.getElementById('authuser');
let loading = document.getElementById('loading');



$(document).ready(function () {
 console.log("Ready")
 loading.style.display = 'none';
 app.style.display = 'block';

 new Vue({
    el: '#authuser',
    data() {
        return {
            zindex: 100000,
            msg1  : 'This user is lazy to post. This user is lazy to postThis user is lazy to post This user is lazy to p',
            msg   : '????????????????????????????????????????????????????????????????????????????????? ???????????????????????????????????????????????????????????????- ???????????????????????????????????????????????????????????? ???????????????????????????????????????????????????????????? nemo mi',
            show: false,
            screenTouch: '',
            screenSlide : '',
            clientR: '',
            tooltip : '',

            // Nav Path
            homePage: true,
            relationPage: false,
            globalPage: false,
            notiPage: false,
            profilePage: false,
            styleCss: {
                transition: 'all 1s ease 1s'
            },
            scroll: 0,


            // Giphy GIFS & STICKERS
            giphyEndPointGif    : 'http://api.giphy.com/v1/gifs/search?',
            giphyApiKey         : '&api_key=oK19YA96XbYKpnjWOxAhAqrKaPz1pAhe&q=',


            giphyEndPointSticker: 'http://api.giphy.com/v1/stickers/search?',
            giphyApiStickerKey  :'&api_key=gXrcVVSftwaLlM9If41mi0LXAaXMvVw2&q=',

            giphySearchString      : 'hello',


            giphysearchgif : '',
            giphysearchsticker: '',
            gifloading  : true,

            giphyStickerModal : '',
            giphyGifModal     : '',




            // Home Post Data Property
            ajaxPostData: [],
            dynamicPostData: [],
            highOrderRanking: [],
            postView: '',
            loading: true,
            offcanvas     : '',
            readmore : true,
            postMsg  : 'Loading . . .',
            postMoreLoading : false,
            noMorePost : false,




            // Get Started
            profilePhoto   : '',
            profile        : '',
            profileImg     : '',
            country        : '',
            city           : 'Yangon',
            coverphoto     : '',
            birth          : '',
            gender         : 'select',
            work           : '',
            getstartFrist  : true,
            getstartSec    : false,
            getstartThird  : false,
            getstartFo     : false,

            // Scroll End Loadmore Data
            publicPostData : 8,
            friPostData    : 2,
            cmLoadMoreLimit: 12,
            scrollLoadMore : false,
            viewPostCase   : false,

            globalcommentId : '',
            modalComments : '',
            modalReply    : '',
            getAllComments:[],
            getAllReplys  : [],
            photoComment : [],
            photoCommentLivePreview : [],
            photoCommentGiphy : [],
            commentGiphyContainer : [],
            commentText : '',

            cmloading    : true,
            saveloading  : false,
            rploading    : true,
            cmreverse    : false,
           



            //Modal comments
            modalCmLikes   : '',
            modalCmComments:'',
            modalCmUnlikes : '',
            modalCmLikeUser: '',
            modalCmToken   : '',
            modalCmrcname  : [],
            modalCmrcno    : [],
            globalCommentPhoto: '',



            // Console
            codefd    : '%c',
            codeColor : 'color: #aa0;font-size:20px;padding:10px 0 10px 0;',


            // HOME POST GLOBAL DATA

            globalsearch    : '',
            global          : '<?=$darkmode?>',
            cookieId        : this.getCookie('id'),
            cookiePic       : this.getCookie('pic'),
            cookieName      : this.getCookie('name').split('+').toString().replace(/,/g,' '),
            access_token    : '<?=$_SESSION['CSRF']?>',
            userrow         : '<?=$userrow?>',
            userDetails     : '',
            friendActive    : '',
            checkbtn        : '',
            globalColor     : '',
            globalComment   : '',

            globalNoti      : 'This is notification',
            globalToastMsg  : false,
            addPostToastMsg : false,
            globalToastError: 'Something went wrong.Try Again . . .',

            globalPostView  : '',
            globalViewPostCase : '',
            globalPostViewContainer: [],
            globalPostName  : '',

            reactionsLoading: false,
            modalReactions  : '',
            reactionsUser   : [],

           



            // Friends & Relation
            friendReq: 0,
            showNewFri: true,
            allDynamicNewUsers: [],
            allDynamicNearYou : [],
            allDynamicFriRequest: [],
            getuserloading : true,
            friRequestNoti : '',

            // Setting & profile

            postSetting : '',
            settingPost : '',
            settingSave : '',

            modalSettingCase : false,

            modalSavedPost: '',
            savepost      : [],

            // Profile    
            modalProfile    : '',
            globalUser      : [],
            globalUserPost      : [],
            profilePostSetting : '',
            profileModalSettingCase : false,
            modalProfileEdit    : '',
            editpost            : [],
            profileEditPostId     : '',

            profileSettingShow   : false,
            profileUpgradeShow   : false,
            profilePostShow      : true,
            profileActive1       : 'active',
            profileActive2       : '',
            profileActive3       : '',


            globalFriProfile     : [],
            globalFriPosts       : [],
            profileViewLoading   : true,

            notiContainer       : [],



        }
    },
    updated() {
      if(this.homePage == true && (this.highOrderRanking != null)){
        this.slick();
      }
      // this.detectImage();
    },
    methods: {
        // The Whole Single Page
        watching() {

        },
        vueCheckDarkMode(){
          if(this.global){
            this.checkbtn = 'checked';
            this.globalColor = 'background:#222!important;color:#eee!important;';
            this.globalComment = 'background:#444!important;color:#fff!important;';
          }else{
            this.checkbtn = '';
            this.globalColor = 'background:#fff!important;color:#222!important;';
            this.globalComment = 'background:#efefef!important;color:#222!important;';
          }
        },
        dbDarkMode(){
          this.global = !this.global;
          this.vueCheckDarkMode();
          $.ajax({
            type: 'post',
            url : 'json-php/darkmode.php',
            data: {
              darkmode : this.global
            }
          })

        },
        slideRight(e) {
            if (this.screenTouch <= -100) {
                switch (e) {
                    case '#home':
                        this.goFriendsPage('friends');
                        break;
                    case '#friends':
                        this.goGlobalPage('global');
                        break;
                    case '#global':
                        this.goNotiPage('noti');
                        break;
                    case '#noti':
                        this.goProfilePage('profile');
                        break;
                    case '#profile':

                        break;
                    default:
                        break;
                }
            }
        },
        slideLeft(e) {
            if (this.screenTouch >= 100) {
                switch (e) {
                    case '#home':

                        break;
                    case '#friends':
                        this.goHomePage('home');
                        break;
                    case '#global':
                        this.goFriendsPage('friends');
                        break;
                    case '#noti':
                        this.goGlobalPage('global');
                        break;
                    case '#profile':
                        this.goNotiPage('noti');
                        break;
                    default:
                        break;
                }
            }
        },
        goHomePage(e) {
            this.homePage = true;
            this.relationPage = false;
            this.globalPage = false;
            this.notiPage = false;
            this.profilePage = false;
            this.createBrowserHistory(e);
            this.routerLinkActive(0);
        },
        goFriendsPage(e) {
            this.homePage = false;
            this.relationPage = true;
            this.globalPage = false;
            this.notiPage = false;
            this.profilePage = false;
            $('#rsnoti').attr('data','');
            this.routerLinkActive(1);
            this.createBrowserHistory(e);
            this.getallRequest();
            this.getAllUsers();
            this.getAllUsersNearYou();
        },
        goGlobalPage(e) {
            this.homePage = false;
            this.relationPage = false;
            this.globalPage = true;
            this.notiPage = false;
            this.profilePage = false;
            this.routerLinkActive(2);
            this.createBrowserHistory(e);
        },
        goNotiPage(e) {
            this.homePage = false;
            this.relationPage = false;
            this.globalPage = false;
            this.notiPage = true;
            this.profilePage = false;
            this.notiread();
            $('#mainoti').attr('data','');

            this.routerLinkActive(3);
            this.createBrowserHistory(e);
        },
        notiread(){
          $.ajax({
              type: 'post',
              url : 'json-php/notiread.php',
              error:(e)=>{console.log(e)},
              success:(res)=>{
                console.log(res);
              }
            });
        },
        goProfilePage(e) {
            this.homePage = false;
            this.relationPage = false;
            this.globalPage = false;
            this.notiPage = false;
            this.profilePage = true;
            this.routerLinkActive(4);
            this.createBrowserHistory(e);
        },
        routerLinkActive(e) {
            // Router Live Active
            var btns = document.getElementsByClassName("router");
            var current = document.getElementsByClassName("active");
            current[0].className = current[0].className.replace(" active", "");
            btns[e].className += " active";
        },
        createHashUrl(e) {
            this.myHistory.push(`#${e}`);
            window.history.replaceState(this.myHistory, null, `#${e}`);
        },
        createBrowserHistory(e) {
            window.history.pushState(null, null, `#${e}`);
        },
        slick(){

          let vm = this;

          // $('#slideruser').not('.slick-initialized').slick({
          //  });

          if (this.homePage == true && window.location.hash != '#addNewPosts') {
            let length = this.highOrderRanking.length;

              //  $(`#slider-for${i}`).not('.slick-initialized').slick({
              //       slidesToShow: 1,
              //       slidesToScroll: 1,
              //       arrows: false,
              //       fade: true,
              //       swipe: false,
              //       mobileFirst: true,

              //   });
              //    $(`#slider-nav${i}`).not('.slick-initialized').slick({
              //       slidesToShow: 6,
              //       slidesToScroll: 1,
              //       asNavFor: `#slider-for${i}`,
              //       centerMode: true,
              //       swipe: false,
              //       arrows: false,
              //       focusOnSelect: true,
              //       mobileFirst: true,
              //   });

              for (let i = 0; i < length; i++) {
                // Register a touchmove listeners for the 'source' element
                this.screenSlide = document.getElementById("sourceslider"+i);
                let clientX, clientY;
                this.screenSlide.addEventListener('touchstart', function(e) {

                    // Cache the client X/Y coordinates
                    clientX = e.touches[0].clientX;
                    clientY = e.touches[0].clientY;
                }, false);

                this.screenSlide.addEventListener('touchend', function(e) {
                    let deltaX, deltaY;
                    deltaX = e.changedTouches[0].clientX - clientX;
                    deltaY = e.changedTouches[0].clientY - clientY;
                    vm.screenTouch = deltaX;
                    // Process the data ...
                }, false);

             }
          }

          if(this.relationPage == true){

            // New User Slider
             if(this.allDynamicNewUsers.length > 0){
                let length = this.allDynamicNewUsers.length;
               for (let i = 0; i < length; i++) {
                 // Register a touchmove listeners for the 'source' element
                 this.screenSlide = document.getElementById("newuserslider"+i);
                 let clientX, clientY;
                 this.screenSlide.addEventListener('touchstart', function(e) {

                     // Cache the client X/Y coordinates
                     clientX = e.touches[0].clientX;
                     clientY = e.touches[0].clientY;
                 }, false);

                 this.screenSlide.addEventListener('touchend', function(e) {
                     let deltaX, deltaY;
                     deltaX = e.changedTouches[0].clientX - clientX;
                     deltaY = e.changedTouches[0].clientY - clientY;
                     vm.screenTouch = deltaX;
                     // Process the data ...
                 }, false);

                }
             }

            // Friend Request Slider
             if(this.allDynamicFriRequest.length > 0){
                let length = this.allDynamicFriRequest.length;
               for (let i = 0; i < length; i++) {
                 // Register a touchmove listeners for the 'source' element
                 this.screenSlide = document.getElementById("frierequser"+i);
                 let clientX, clientY;
                 this.screenSlide.addEventListener('touchstart', function(e) {

                     // Cache the client X/Y coordinates
                     clientX = e.touches[0].clientX;
                     clientY = e.touches[0].clientY;
                 }, false);

                 this.screenSlide.addEventListener('touchend', function(e) {
                     let deltaX, deltaY;
                     deltaX = e.changedTouches[0].clientX - clientX;
                     deltaY = e.changedTouches[0].clientY - clientY;
                     vm.screenTouch = deltaX;
                     // Process the data ...
                 }, false);

                }
             }
         }

        },
        viewprofile(id){
          this.zindex++;
          $.ajax({
            type:"POST",
            url : "json-php/getFriProfile.php",
            dataType: 'JSON',
            cache: false,
            data :{
              pid : id
            },
            beforeSend: e => this.profileViewLoading = true,
            success: res => {
              console.log(res);
              this.profileViewLoading = false;
              this.globalFriProfile = res.info[0];
              this.globalFriPosts  = res.post[0];
              this.modalProfile.show();
              this.createBrowserHistory('profileView');
            },
            error  : e => console.log(e.responseText)
          })
        },
        friprofileUpdate(res){
          const vm = this;
          console.log(res)
          if(res != ''){
            const newId = res.map( id => id.id );
            $.ajax({
              type: 'POST',
              url: 'json-php/postRefresh.php',
              cache:false,
              dataType: 'json',
              data : {
                 res : newId
               },
               error: e => console.log(e.responseText),
               success : res =>{
                vm.globalFriPosts = res;
               }
             });
          }
          
        },


        // Home Post Functions

        // GET STARTED 
        getstarted(){
          this.modalGetStarted.show();
        },
        customFormatter(date) {
         let format = moment(date).format('MMMM Do YYYY');

           if(format.includes("st")){
             this.birth = format.replace('st','');
              console.log("Work");
           }
           if(format.includes("nd")){
             this.birth = format.replace('nd','');
           }
           if(format.includes("rd")){
             this.birth = format.replace('rd','');
           }
           if(format.includes("th")){
             this.birth = format.replace('th','');
           }

          return moment(date).format('MMMM Do YYYY');
        },
        getStartModalClose(){
          this.modalGetStarted.hide();
        },
        getstartCaseOne(){
            this.getstartFrist = true;
            this.getstartSec   = false;
            this.getstartThird = false;
            this.getstartFo    = false;
        },
        getstartCaseTwo(){

            this.getstartFrist = false;
            this.getstartSec   = true;
            this.getstartThird = false;
            this.getstartFo    = false;

            this.profile.croppie('result',{
                 type  : 'base64',
                 size : 'viewport'
               }).then((res)=> {
                   // do something with cropped result
                   this.profileImg = res;
                   console.log(res);
               });
        },
        getstartCaseThree(){
            this.getstartFrist = false;
            this.getstartSec   = false;
            this.getstartThird = true;
            this.getstartFo    = false
        },
        changeGetStartedPhoto(e) {
           let vm = this;
          if (window.File && window.FileList && window.FileReader) {

            this.profile = $('#image_demo').croppie({
                enableExif: true,
                viewport: {
                    width: 300,
                    height: 300,
                    type: 'circle'
                },
                boundary: {
                    width: '300',
                    height: '300'
                }
            });

           // First times File Choose If globalImage Length is 0, Input Whatever files number 1, or 2 or . . .
            if (this.profilePhoto.length == 0) {

              this.profilePhoto = e.target.files || e.dataTransfer.files;
              // Convert Object data to Array format
              this.profilePhoto = Array.prototype.slice.call(this.profilePhoto);
              // Check Invalid Image type

              const check = this.profilePhoto[0];
              const imagesTypeInvalid = [];
              var match = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
              if (!((check.type == match[0]) || (check.type == match[1]) || (check.type == match[2]) || (check.type == match[3]))) {
                  this.profilePhoto = [];
              }
            }

            if (this.profilePhoto.length > 0) {

                 let profileReader = new FileReader();
                 profileReader.onload = ((e) => {
                    vm.profile.croppie('bind',{
                      url :  e.target.result
                    })
                    .then(()=>{
                      console.log("Success Profile")
                    })
                 });
                 profileReader.readAsDataURL(vm.profilePhoto[0]);

            }

          }else {
            alert("Your browser is not supports files format.");
            return null;
          }
        },
        uploadProfile(){
            let vm = this;
            let formData = new FormData();

            if(this.profilePhoto.length > 0){
              formData.append('image',this.profileImg);
            }
            formData.append('city',this.city);
            formData.append('birth',this.birth);
            formData.append('gender',this.gender);
            $.ajax({
             type: 'post',
             url: 'getStarted.php',
             data: formData,
             contentType: false,
             cache: false,
             processData: false,
             error:(e)=>{
               console.log(e);
             },
             success   :(res)=>{
               console.log(res);
               vm.getstartFrist = false;
               vm.getstartSec   = false;
               vm.getstartThird = false;
               vm.getstartFo    = true
              }
            });
            this.profileImg = '';
        },



        // Photo Views Path
        viewPostModal(e) {
          this.zindex++;
            this.postView = new bootstrap.Modal(document.getElementById('readMore' + e));
            this.postView.show();
            this.viewPostCase = true;
            this.createBrowserHistory('view');
        },
        clickPostImg(index, e, img) {

            console.log("Check Length ", e);
            // If image is one View Direct
            if (e == 1) {
                this.postImgView(img);
            } else {
                //  If image is greater than 1
                // Show modal with content and all Photo
                this.viewPostModal(index);
            }
        },
        postImgView(e) {
            var onePhoto = document.getElementById('image' + e);
            if (onePhoto.requestFullscreen) {
                onePhoto.requestFullscreen();
            } else if (onePhoto.msRequestFullscreen) {
                onePhoto.msRequestFullscreen();
            } else if (onePhoto.mozRequestFullScreen) {
                onePhoto.mozRequestFullScreen();
            } else if (onePhoto.webkitRequestFullscreen) {
                onePhoto.webkitRequestFullscreen();
            } else {
                console.log("Fullscreen API is not supported");
            }
        },
        cmImgView(e){
           var onePhoto = document.getElementById('cmimage' + e);
            if (onePhoto.requestFullscreen) {
                onePhoto.requestFullscreen();
            } else if (onePhoto.msRequestFullscreen) {
                onePhoto.msRequestFullscreen();
            } else if (onePhoto.mozRequestFullScreen) {
                onePhoto.mozRequestFullScreen();
            } else if (onePhoto.webkitRequestFullscreen) {
                onePhoto.webkitRequestFullscreen();
            } else {
                console.log("Fullscreen API is not supported");
            }
        },
        modalImgSoloView(e) {
            var onePhoto = document.getElementById('solo' + e);
            if (onePhoto.requestFullscreen) {
                onePhoto.requestFullscreen();
            } else if (onePhoto.msRequestFullscreen) {
                onePhoto.msRequestFullscreen();
            } else if (onePhoto.mozRequestFullScreen) {
                onePhoto.mozRequestFullScreen();
            } else if (onePhoto.webkitRequestFullscreen) {
                onePhoto.webkitRequestFullscreen();
            } else {
                console.log("Fullscreen API is not supported");
            }
        },
        postsetting(id,save,cat){

          if(!this.modalSettingCase){
            setTimeout(() => {
              this.postSetting.show();
            }, 100);
            this.settingPost = id;
            this.settingSave = save;
            this.settingCat  = cat;
          }
          this.modalSettingCase = true;
        },
        dbPostSetting(id,res){
           console.log(id);
           let vm = this;
           if(res == 'save'){
             $.ajax({
               type:'post',
               url : 'includes/class/save.php',
               data : {
                 post : id,
                 cat  : this.settingCat
               },
               error: e =>console.log(e),
               success: res =>{
                 console.log(res);
                 vm.updateDataPost(vm.highOrderRanking);
                 vm.globalToastMsg = true;
                 $(document).ready(()=> $('#globalNoti').toast('show'));
                 vm.globalNoti = 'This post have been saved.';
               }
             })
           }
           if(res == 'hide'){
             const delItem = this.highOrderRanking.find(res => res.id == id );
             setTimeout(() => this.highOrderRanking.remove(delItem), 100);
           }
           if(res == 'report'){
             console.log('Report this post');
           }

           this.postSetting.hide();
           this.profilePostSetting.hide();
        },
        savePostItems(){
          this.modalSavedPost.show();
          this.createBrowserHistory('savepost');
          let vm = this;
          $.ajax({
            type:"GET",
            url :"json-php/getAllSaved.php",
            dataType:'JSON',
            error: e => { 
              if(e.responseText == "empty") console.log("No Save Post right now");
            },
            success: res => vm.savepost = res
          })
        },
        removeSavePost(id,msg){
            let vm = this;   
            $.ajax({
            type:"POST",
            url :"includes/class/removesavepost.php",
            data: {
              post : id
            },
            error: e => console.log(e.responseText),
            success: (res)=>{
              let item = vm.savepost.find(res => res.id == id);
              vm.savepost.remove(item);
              vm.globalToastMsg = true;
              $(document).ready(() => $('#globalNoti').toast('show'));
              vm.globalNoti = 'Unsaved . . .';
              vm.postSetting.hide();
              vm.profilePostSetting.hide();
              vm.updateDataPost(vm.highOrderRanking);
            }
          });

          
    

        },
        globalViewPostModal(id,name){
          let vm = this;
          this.globalPostName = 'Post View';
          this.globalcommentId = id;
            $.ajax({
              type: 'post',
              url : 'json-php/postView.php',
              dataType:'JSON',
              data:{
                id : id
              },
              error:(e)=>{console.log(e)},
              success:(res)=>{
                vm.globalPostViewContainer = res;
              }
            });

            $.ajax({
             type: 'post',
             dataType: 'JSON',
             url: 'json-php/getAllComments.php',
            data:{
              id : id
            },
             beforeSend: function() {},
             error: (e) => {
                 console.log(e);
             },
            success   :(res)=>{
                vm.getAllComments = res.reverse();
            }
          });

           this.zindex++;
           this.globalPostView.show();
           this.globalViewPostCase = true;
           this.createBrowserHistory('postview');

          var element = document.getElementById('postviewId');

          console.log(element);
          //  window.scrollTo(0,element.scrollHeight);
                console.log(element.clientHeight);
               console.log(element.scrollHeight);
               console.log(element.scrollTop);
               element.scrollTop = element.scrollHeight - element.clientHeight;

        },




        // Give Like & Unlike Path
        dblikes(token,emoji){
          let vm = this;
            $.ajax({
             type: 'post',
             url: 'likes-unlikes-comments/update.php',
             cache: false,
             data: {
                user_id    : this.cookieId,
                token   : token,
                emoji   : emoji,
                state   : 'likes'
             },
             success:(res)=>{
                if(res == "deleted"){
                  alert("This post already deleted");
                  vm.updateDataPost(vm.highOrderRanking);
                }
             },
             error : (e)=>{
               console.log(e.responseText);
             }
            });
        },
        dbunlikes(token){
          $.ajax({
           type: 'post',
           url: 'likes-unlikes-comments/update.php',
           cache: false,
           data: {
              user_id    : this.cookieId,
              token      : token,
              state      : 'unlikes'
           },
           success:(res)=>{
                if(res == "deleted"){
                  alert("This post already deleted");
                  vm.updateDataPost(vm.highOrderRanking);
                }
             },
           error : (e)=>{
               console.log(e.responseText);
            }
          });
        },
        dbdangerlikes(token){
            let vm = this;
            this.popSound.play();
            $.ajax({
             type: 'post',
             url: 'likes-unlikes-comments/update.php',
             cache: false,
             data: {
                user_id    : this.cookieId,
                token   : token,
                state   : 'dangerlikes'
             },
             success:(res)=>{
                if(res == "deleted"){
                  alert("This post already deleted");
                  vm.updateDataPost(vm.highOrderRanking);
                }
             },
             error : (e)=>{
               console.log(e.responseText);
             }
            });
        },
        dbundangerlikes(token){
          let vm = this;
          $.ajax({
           type: 'post',
           url: 'likes-unlikes-comments/update.php',
           cache: false,
           data: {
              user_id    : this.cookieId,
              token      : token,
              state      : 'undangerlikes'
           },
           success:(res)=>{
                if(res == "deleted"){
                  alert("This post already deleted");
                  vm.updateDataPost(vm.highOrderRanking);
                }
             },
             error : (e)=>{
               console.log(e.responseText);
             }
          });
        },
        reactions(token){
          let vm = this;
          this.modalReactions.show();
          this.createBrowserHistory('-');
          $.ajax({
            type:'post',
            url : 'json-php/getReaction.php',
            dataType:"json",
            data:{
              token : token
            },
            beforeSend: () => vm.reactionsLoading = true,
            error: e => console.log(e.responseText),
            success:(res)=>{
             if(res == "deleted"){
                alert("This post already deleted");
                vm.updateDataPost(vm.highOrderRanking);
              }else{
                vm.reactionsLoading = false;
                vm.reactionsUser = res;
              }
            },
          })
        },
        cmlikes(id){
            let vm = this;
            this.popSound.play();
            $.ajax({
             type: 'post',
             url: 'likes-unlikes-comments/update.php',
             cache: false,
             data: {
                user_id    : this.cookieId,
                token   : id,
                state   : 'cmlikes'
             },
             success   :(res)=>{
            //  console.log(res)
                if(vm.cmreverse == false){
                    vm.commentsLoadMore('ASC');
                 }
                 if(vm.cmreverse == true){
                    vm.sortcm('DESC');
                 }
              }
            });
        },
        uncmlikes(id){
            let vm = this;
            this.popSound.play();
            $.ajax({
             type: 'post',
             url: 'likes-unlikes-comments/update.php',
             cache: false,
             data: {
                user_id    : this.cookieId,
                token   : id,
                state   : 'cmunlikes'
             },
             success   :(res)=>{
              //    console.log(res)
                if(vm.cmreverse == false){
                    vm.commentsLoadMore('ASC');
                 }
                 if(vm.cmreverse == true){
                    vm.sortcm('DESC');
                 }
              }
            });
        },
        // Vue Custom Data
        vuelike(postId){
            this.popSound.play();
              /*Reaction*/
            this.highOrderRanking.map(res=>{
              if(res.token == postId){
                  res.like_user = this.cookieId;
                  res.reactions++;
                  if(res.reactions == 1){
                    res.react_name.push('like','love','haha');
                    res.react_no.push(1,0,0);
                  }
                  if(res.reactions > 1){
                    res.react_name[2] = 'like';
                    res.react_no[2] = 1;
                  }
                  res.like_emoj = 'like';
                  res.like_emoji = 'Like';
                  this.dblikes(res.token,1);

                  if(res.unlike_user == this.cookieId){
                    this.vueundangerlikes(postId);
                  }
              }
            });
        },
        vueunlikes(postId){
          console.log(postId)
            this.highOrderRanking.map(res=>{
              if(res.token == postId){
                  res.like_user = null;
                  res.reactions--;
                  if(res.reactions == 0){
                    res.react_name = [];
                    res.react_no = [];
                  }
                  if(res.reactions != 0){
                    res.react_name[2] = [];
                    res.react_no[2] = 0;
                  }
                  res.like_emoj = '';
                  res.like_emoji = '';

                  this.dbunlikes(res.token);
              }
            });
            if(this.globalFriPosts != ''){
              this.globalFriPosts.map(res=>{
              if(res.token == postId){
                  res.like_user = null;
                  res.reactions--;
                  if(res.reactions == 0){
                    res.react_name = [];
                    res.react_no = [];
                  }
                  if(res.reactions != 0){
                    res.react_name[2] = [];
                    res.react_no[2] = 0;
                  }
                  res.like_emoj = '';
                  res.like_emoji = '';

                  this.dbunlikes(res.token);
              }
            });
            }
            this.profileUser();
        },
        vuedangerlikes(postId){
          this.highOrderRanking.map(res=>{
              if(res.token == postId){
                  res.unlike_user = this.cookieId;
                  res.unlikes++;
                  res.unlikesnc++;
                  this.dbdangerlikes(res.token);
                  if(res.like_user == this.cookieId){
                    this.vueunlikes(postId);
                  }
              }
          });
          this.profileUser();
        },
        vueundangerlikes(postId){
            this.highOrderRanking.map(res=>{
              if(res.token == postId){
                  res.unlike_user = '';
                  res.unlikes--;
                  res.unlikesnc--;
                  this.dbundangerlikes(res.token);
              }
            });
        },







        // Reloading,Refreshing 
        updateDataPost(res){
          const vm = this;
          const newId = res.map( id => id.id );
          $.ajax({
            type: 'POST',
            url: 'json-php/postRefresh.php',
            cache:false,
            dataType: 'json',
            data : {
               res : newId
             },
             error: e => console.log(e.responseText),
             success : res =>{
              vm.highOrderRanking = res;
              console.log("Refreshed");
             }
           });
        },
        postUpdatedReload() {
            let vm = this;
            $.ajax({
              type: 'POST',
              dataType: 'JSON',
              url: 'json-php/getAllPost.php',
              cache: false,
              data:{
                publicPostData : this.publicPostData,
                friPostData    : this.friPostData
              },
              beforeSend: ()=> vm.loading = true,
              error: (e) => {
                vm.loading = true;
                console.log(e.responseText)
                if(e.responseText == "Empty Array" || e.responseText == "GET STARTED"){
                  vm.highOrderRanking = null
                  vm.loading = false;
                }
              },
              success: res => {
                if(res == "") vm.highOrderRanking = null;
                else vm.highOrderRanking = res;
                vm.loading = false;
              }
            });

        },
        postLoadMore(){
          let vm = this;
          this.publicPostData = this.publicPostData + 8;
          this.friPostData    = this.friPostData + 2;
          $.ajax({
              type: 'POST',
              dataType: 'JSON',
              url: 'json-php/getAllPost.php',
              cache: false,
              data:{
                  publicPostData : this.publicPostData,
                  friPostData    : this.friPostData
              },
              beforeSend: (res)=>{
              },
              error: e => {
                console.log(e.responseText);
                if(e.responseText == "Empty Array") vm.highOrderRanking = null
              },
              success: (res) => {
                const newId = res.map(id=>{ return id.id });
                const oriId = this.highOrderRanking.map(id=>{ return id.id });
                //  Symmetrical Difference
                const Id = newId.filter(x => !oriId.includes(x)).concat(oriId.filter(x => !newId.includes(x)));
                if(Id.length == 0){   
                   vm.noMorePost = true; 
                   vm.scrollLoadMore = false;  
                   vm.postMsg = 'No More Post . . .';
                   vm.highOrderRanking = res;
                }else{
                $.ajax({
                  type: 'POST',
                  url: 'json-php/postRefresh.php',
                  cache:false,
                  dataType: 'json',
                  data : {
                     res : newId
                   },
                   beforeSend:()=> vm.postMoreLoading = true,
                   error: e => console.log(e.responseText),
                   success :(res)=>{
                    vm.postMoreLoading = false;
                    res.filter(data=>{
                      for(let i=0;Id.length > i;i++){
                        if(data.id == Id[i]){
                         //  Add New data
                          vm.highOrderRanking.push(data);
                        }
                      }
                      return null;
                    });
                    console.log("Loading +",Id.length ,"post");
                   }
                });
              }
            }
          });
        },
        commentsLoadMore(sort){
          let vm = this;
          this.cmLoadMoreLimit = this.cmLoadMoreLimit + 12;
          $.ajax({
           type: 'POST',
           dataType: 'JSON',
           url: 'json-php/getAllComments.php',
           cache: false,
           data : {
              id : this.globalcommentId,
              commentloadmore: this.cmLoadMoreLimit,
              sort: sort
            },
            error: e => console.log(e.responseText),
            success   :(res)=>{
              vm.getAllComments = res;
            }
          });
        },
        commentsRefreshDesc(id){
          let vm = this;
          $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: 'json-php/getAllComments.php',
            cache: false,
            data : {
              id : id,
              sort: 'DESC'
            },
            success   :(res)=>{
              vm.getAllComments = res;
               console.log("Comments Updated. . .");
            }
          });
        },
        sortcm(sort){
          this.cmreverse = true;
          let vm = this;
          this.cmLoadMoreLimit = this.cmLoadMoreLimit + 12;
          $.ajax({
           type: 'POST',
           dataType: 'JSON',
           url: 'json-php/getAllComments.php',
           cache: false,
           data : {
              id : this.globalcommentId,
              commentloadmore: this.cmLoadMoreLimit,
              sort: sort
            },
            error: e => console.log(e.responseText),
            success   :(res)=>{
              vm.getAllComments = res;
              console.log("Loading More Comment . . .,");
            }
          });
        },
        commentsRefresh(id){
          // Post Session Data
          let vm = this;
          $.ajax({
            type: 'POST',
            dataType: 'JSON',
            url: 'json-php/getAllComments.php',
            cache: false,
            data : {
              id : id
            },
            success   : res => vm.getAllComments = res
          });
        },
        replyRefresh(id){
          let vm = this;
          $.ajax({
            type: 'post',
            dataType: 'JSON',
            url: 'json-php/getReply.php',
            cache: false,
            data:{
             id : id
            },
           error: e => console.log(e.responseText),
           success : res => {
             // console.log("Reply Refresh");
             vm.getAllReplys = res;
             if(vm.cmreverse == false){
                vm.commentsLoadMore('ASC');
             }
             if(vm.cmreverse == true){
                vm.sortcm('DESC');
             }
           }
          });
        },





        // Write Comment Path
        showModalComments(id,index,l,u,c,lu,t,rcname,rcno){
          let vm = this;

          this.modalCmComments = c;
          this.modalCmLikes    = l;
          this.modalCmUnlikes  = u;
          this.modalCmLikeUser = lu;
          this.modalCmToken    = t;
          this.modalCmrcno     = rcno;
          this.modalCmrcname  = rcname;

          this.globalcommentId = id;

          this.zindex++;
          console.log(this.zindex);
         

          if(this.viewPostCase == true) this.viewPostCase = true;
          else this.viewPostCase = false;
          
           $.ajax({
             type: 'post',
             dataType: 'JSON',
             url: 'json-php/getAllComments.php',
             data:{
              id : id
             },
            beforeSend: () => vm.cmloading = true,
            error: e => console.log(e),
            success : res => {
              vm.cmloading      = false;
              vm.getAllComments = res;
            }
          });
          this.createBrowserHistory('comments');
          this.modalComments.show();
        },
        showModalReply(id){
           let vm = this;
           this.zindex++;
           this.modalReply.show();

           // Need to remove this line to read comment
           // this.globalcommentId = id;

           $.ajax({
             type: 'post',
             dataType: 'JSON',
             url: 'json-php/getReply.php',
            data:{
              id : id
            },
            beforeSend:() => vm.rploading = true,
            error : e => console.log(e.responseText),
            success : res => {
              // console.log(res);
              vm.rploading = false;
              vm.getAllReplys = res;
            }
          });
          this.createBrowserHistory('commentsreply');
        },
        removeImgPreview(e) {
          this.photoComment = [];
          this.photoCommentLivePreview = [];
          this.commentGiphyContainer = [];
        },
        changePhotoComment(e) {
          let vm = this;
          if (window.File && window.FileList && window.FileReader) {

            // First times File Choose If globalImage Length is 0, Input Whatever files number 1, or 2 or . . .
            if (this.photoComment.length == 0) {

              this.photoComment = e.target.files || e.dataTransfer.files;
              // Convert Object data to Array format
              this.photoComment = Array.prototype.slice.call(this.photoComment);

              // Check Invalid Image type
              let check = this.photoComment[0];
              var match = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
              if (!((check.type == match[0]) || (check.type == match[1]) || (check.type == match[2]) || (check.type == match[3]))) this.photoComment = [];
              else this.photoCommentLivePreview.push(this.photoComment[0]); // push data to photoCommentLivePreview
            
              if (this.photoCommentLivePreview.length > 0) {
                let imageReader = new FileReader();
                imageReader.onload = e =>  vm.globalCommentPhoto = e.target.result;
                imageReader.readAsDataURL(this.photoCommentLivePreview[0]);
              }

            }
          }else {
            alert("Your browser is not supports files format.");
            return null;
          }
        },
        uploadComment(postId){
            let vm = this;
            let formData = new FormData();
            if(this.commentText == ''){
              console.log(this.photoCommentLivePreview.length);
              console.log(this.commentGiphyContainer.length);
            }else{

              if(this.commentGiphyContainer.length > 0) formData.append('gif',this.commentGiphyContainer[0].url);
              
              if(this.photoCommentLivePreview.length > 0) formData.append('photo',this.photoCommentLivePreview[0]);

              formData.append('content', this.commentText);
              formData.append('user_id',this.cookieId);
              formData.append('post_id',postId);
              formData.append('state','addcomments');
              $.ajax({
               type: 'post',
               url: 'likes-unlikes-comments/update.php',
               data: formData,
               contentType: false,
               cache: false,
               processData: false,
               error: e => console.log(e.responseText),
               success : res =>{
                  console.log(res);
                  if(res == "deleted") alert("This post already deleted");
                  else  vm.commentsRefreshDesc(postId);
                }
              });
            }

            this.commentText = '';
            this.photoCommentLivePreview = [];
            this.commentGiphyContainer = [];
            this.photoComment = [];
        },
        uploadReply(cmId){
            let vm = this;
            let formData = new FormData();
            if(this.commentText == ''){
              console.log(this.photoCommentLivePreview.length);
              console.log(this.commentGiphyContainer.length);
            }else{

              if(this.commentGiphyContainer.length > 0) formData.append('gif',this.commentGiphyContainer[0].url);
              
              if(this.photoCommentLivePreview.length > 0) formData.append('photo',this.photoCommentLivePreview[0]);
              
              formData.append('content', this.commentText);
              formData.append('user_id',this.cookieId);
              formData.append('cm_id',cmId);
              formData.append('state','reply');
              $.ajax({
               type: 'post',
               url: 'likes-unlikes-comments/update.php',
               data: formData,
               contentType: false,
               cache: false,
               processData: false,
               error: e => console.log(e.responseText),
               success : res => {
                  if(res == "deleted") alert("This post already deleted"); 
                  else vm.replyRefresh(cmId);
                }
              });
            }

            this.commentText = '';
            this.photoCommentLivePreview = [];
            this.commentGiphyContainer = [];
            this.photoComment = [];
        },
        commentScroll(e){
          e.preventDefault();
          let div = e.target;
          // console.log(e.target)
          if(div.scrollTop + div.clientHeight >= div.scrollHeight) {
              // do the lazy loading here
             if(this.cmreverse == false){
                this.commentsLoadMore('ASC');
             }
             if(this.cmreverse == true){
                this.sortcm('DESC');
             }
             console.log("More  Comment");
          }
        },
        // Giphy Path
        loadGiphyCommentPreview(e){
            let vm = this;
            var d = new Date();
            var n = d.getHours();
            if(e == 'gif'){
              if(n >= 5 && n <= 10){
                this.giphySearchString = `Good Morning`;
                console.log(this.codefd+this.giphySearchString, this.codeColor);
              }
              if(n > 10 && n <= 14){
                this.giphySearchString = `Good Afternoon`;
                console.log(this.codefd+this.giphySearchString, this.codeColor);
              }
              if(n > 14 && n <= 18){
                this.giphySearchString = `Good Evening`;
                console.log(this.codefd+this.giphySearchString, this.codeColor);
              }
              if(n > 18 && n <= 24 || n >= 1 && n < 5){
                this.giphySearchString = `Good Night`;
                console.log(this.codefd+this.giphySearchString, this.codeColor);
              }              
              let url = this.giphyEndPointGif + this.giphyApiKey + this.giphySearchString;
              $.ajax({
                type:'GET',
                url: url,
                cache: false,
                beforeSend:()=> vm.gifloading = true,
                error :e => console.log(e.responseText),
                success : res => {
                  vm.gifloading = false;
                  vm.photoCommentGiphy = res.data;
                }
              });
            }
            if(e == 'sticker'){
              this.giphySearchString = "Hello";
              let url = this.giphyEndPointSticker + this.giphyApiStickerKey + this.giphySearchString;
              $.ajax({
                 type:'GET',
                 url: url,
                 cache: false,
                 beforeSend:()=> vm.gifloading = true,
                 error: e => console.log(e.responseText),
                 success : res =>{
                   vm.gifloading = false;
                   vm.photoCommentGiphy = res.data;
                 }
              });
            }
        },
        searchGiphy(e){
          let vm = this;
           if(e == 'gif'){
              if(this.giphysearchgif == ''){
              }else{
                let url = this.giphyEndPointGif + this.giphyApiKey + this.giphysearchgif;
                $.ajax({
                   type:'GET',
                   url: url,
                   beforeSend:() => vm.gifloading = true,
                   success   :(res)=>{
                     vm.gifloading = false;
                     vm.photoCommentGiphy = res.data;
                   }
                });
              }
           }
           if(e == 'sticker'){
              if(this.giphysearchsticker == ''){
              }else{
                 let url = this.giphyEndPointSticker + this.giphyApiStickerKey + this.giphysearchsticker;
                 $.ajax({
                   type:'GET',
                   url: url,
                   beforeSend:() => vm.gifloading = true,
                   success   :(res)=>{
                     vm.gifloading = false;
                     vm.photoCommentGiphy = res.data;
                   }
                 });
              }
           }
        },
        selectGiphyItem(url){
          let object = { url : url};
          this.commentGiphyContainer.push(object);
        },



        // Add New Post Function
        newpost() {
          this.createBrowserHistory('addNewPost');
          this.addPostModal.show();
        },
        addNewPost(e){
          let vm = this;
            this.publicPostData = this.publicPostData + 10;
            this.friPostData    = this.friPostData + 2;
            $.ajax({
                type: 'POST',
                dataType: 'JSON',
                url: 'json-php/getAllPost.php',
                cache: false,
                data:{
                    publicPostData : this.publicPostData,
                    friPostData    : this.friPostData
                },
                beforeSend: () => vm.addPostToastMsg = true,
                error: res => {
                  vm.addPostToastMsg = true;
                  // Check if users doesn't get started
                  // We will not show any post for him
                  if(res.responseText == "Empty Array" || res.responseText == "GET STARTED"){
                    vm.highOrderRanking = null
                    console.log(res.responseText);
                  }
                  // When he try to post or loadmore post without GetStarted, We will show noti to fill information
                  if(e == 'error'){
                    // Error Case will not be come
                    vm.globalToastError = 'Something went wrong.Try Again . . .';
                    $('#postUploadError').toast('show');
                  }
                  if(e == 'success'){
                    // addNewPost is working even you don't getstarted that's why success & response GET STARTED
                    vm.globalToastError = 'Please fill information first. . .';
                    $('#postUploadError').toast('show');
                  }
                  if(e == undefined){
                    $('#postUploadError').toast('hide');
                  }
                  setTimeout(() => {
                    vm.addPostToastMsg = false;
                  }, 3000);
                },
                success: (res) => {
                  vm.addPostToastMsg = true;
                  if(e == 'error'){
                  // Error Case will not be come
                    vm.globalToastError = 'Something went wrong.Try Again . . .';
                    $('#postUploadError').toast('show');
                  }
                  if(e == 'success'){
                    console.log("Upload New Post");
                    vm.highOrderRanking = res;
                    $('#postUploaded').toast('show');
                  }
                  if(e == undefined){
                    $('#postUploaded').toast('hide');
                  }
                  e = '';
                  setTimeout(() => {
                     vm.addPostToastMsg = false;
                  }, 3000);

                }
            });
        },
        async detectImage() {
          var result = await deepai.callStandardApi("content-moderation", {
              image: "https://xxx-cdn.picsxnxx.com/JOQH6nv1VG192Q2jEdXvs%2Fam1TtTUg%3D%3D/11.jpg"
          });
          var resp = await deepai.callStandardApi("nsfw-detector", {
              image: "http://media.zakerxa.com/uploads/yCzRdKWMusi834T/MMwebyCzRdKWMusWhen-You-Miss-Him.jpg",
          });
          console.log(resp);
          console.log("Sex ", result)
        },



         // Friend & Relation
        getAllUsers() {
          let vm = this;
           $.ajax({
            type: 'GET',
            dataType: 'JSON',
            url: 'json-php/getAllNewUsers.php',
            beforeSend: () => vm.getuserloading = true,
            error: e => {
              console.log(e.responseText);
              vm.getuserloading = true;
            },
            success: (res) => {
              if(res == null) vm.allDynamicNewUsers = [];
              else vm.allDynamicNewUsers = res;
              vm.getuserloading = false;
            }
          });
          // someObject = Object.assign({}, this.someObject, this.allDynamicNewUsers);
        },
        getAllUsersNearYou() {
          let vm = this;
           $.ajax({
            type: 'GET',
            dataType: 'JSON',
            url: 'json-php/getUsersNearYou.php',
            beforeSend: () => vm.getuserloading = true ,
            error: e => {
              console.log(e.responseText)
              vm.getuserloading = true;
            },
            success: (res) => {
              // Sort by PostId DESC
              if(res == null) vm.allDynamicNearYou = [];
              else vm.allDynamicNearYou = res;
              vm.getuserloading = false;
            }
          });
        },
        getallRequest() {
          let vm = this;
          $.ajax({
            type: 'GET',
            dataType: 'JSON',
            url: 'json-php/getFriRequest.php',
            beforeSend: () => vm.getuserloading = true ,
            error: e => {
              console.log(e)
              vm.getuserloading = true;
            },
            success: res => {
              // Sort by PostId DESC
              if(res == null) vm.allDynamicFriRequest = [];
              else vm.allDynamicFriRequest = res;
              vm.getuserloading = false;
            }
          });
        },
        requestRefresh(){
          let vm = this;
          $.ajax({
            type: 'GET',
            dataType: 'JSON',
            url: 'json-php/getFriRequest.php',
            error: e => console.log(e.responseText),
            success: res => {
              if(res == null) vm.allDynamicFriRequest = [];
              else vm.allDynamicFriRequest = res;
            }
          });
        },
        friRelation(e){
          if(e.accept == null){
            let removePerson  = this.allDynamicFriRequest.find(res => res.id == e.delete);
            setTimeout(() => $("#frierequser"+removePerson.id).fadeOut(), 2000);
            setTimeout(() => this.allDynamicFriRequest.remove(removePerson), 2300);
          }
          if(e.delete == null){
            let removePerson  = this.allDynamicFriRequest.find(res => res.id == e.accept);
            setTimeout(() => $("#frierequser"+removePerson.id).fadeOut(), 2000);
            setTimeout(() => this.allDynamicFriRequest.remove(removePerson), 2300);
          }
        },



        globalModal(vm){
           // Addnew Post Modal
           this.addPostModal = new bootstrap.Modal(document.getElementById('addPostModal'), {
               keyboard: false,
               backdrop: 'static'
           });

           this.modalProfileEdit = new bootstrap.Modal(document.getElementById('profileEdit'), {
              keyboard: false,
              backdrop: 'static'
           });
          
           this.modalSavedPost = new bootstrap.Modal(document.getElementById('modalSavedPost'), {
              keyboard: false,
              backdrop: 'static'
           });

           this.modalReactions = new bootstrap.Modal(document.getElementById('reactions'), {
              keyboard: false,
              backdrop: 'static'
           });

           this.modalProfile = new bootstrap.Modal(document.getElementById('profile'), {
              keyboard: false,
              backdrop: 'static'
           });

           // Global Comment
           let modalComments = document.getElementById('modalCommentsId');
           this.modalComments = new bootstrap.Modal(modalComments, {
                keyboard: false,
                backdrop: 'static'
           });
           modalComments.addEventListener('hidden.bs.modal', function () {
             console.log("Close Global Comment");
             vm.globalcommentId = '';
             vm.photoCommentLivePreview = [];
             vm.photoComment = [];
             vm.globalCommentPhoto = '';
             vm.updateDataPost(vm.highOrderRanking);
             if(vm.profilePage == true){
              vm.friprofileUpdate(vm.globalFriPosts);
             }
           });

           // Global Reply
           let modalReply = document.getElementById('modalReplyId');
           this.modalReply = new bootstrap.Modal(modalReply, {
              keyboard: false,
              backdrop: 'static'
           });
           modalReply.addEventListener('hidden.bs.modal', function () {
             console.log("Close Global Reply");     
             vm.photoCommentLivePreview = [];
             vm.photoComment = [];
             vm.globalCommentPhoto = '';
           });


           // Global Post View
           let globalPostView = document.getElementById('globalPostView');
           this.globalPostView = new bootstrap.Modal(globalPostView,{
             keyboard: false,
             backdrop: 'static'
           });
           globalPostView.addEventListener('hidden.bs.modal', function () {
             console.log("Close Global Post View");
             vm.globalcommentId = '';
           });


           // GET STARTED PATH
           let modalGetStarted = document.getElementById('modalGetStarted')
           this.modalGetStarted = new bootstrap.Modal(modalGetStarted, {
              keyboard: false,
              backdrop: 'static'
           });
           modalGetStarted.addEventListener('hidden.bs.modal', function () {
             console.log("Cancle Get Started");
             location.reload();
           });
        },
        globalOffcanvas(vm){
          this.giphyGifModal     = new bootstrap.Offcanvas(document.getElementById('offcanvasGif'));
          this.giphyStickerModal = new bootstrap.Offcanvas(document.getElementById('offcanvasSticker'));

          // POST SETTING OFFCANVAS PATH
          let postSettingId = document.getElementById('postsetting');

          this.postSetting = new bootstrap.Offcanvas(postSettingId);
          postSettingId.addEventListener('hidden.bs.offcanvas', () => {
            vm.modalSettingCase = false;
          });

          let profilePostSettingId = document.getElementById('profilepostsetting');

          this.profilePostSetting = new bootstrap.Offcanvas(profilePostSettingId);
          profilePostSettingId.addEventListener('hidden.bs.offcanvas', () => {
            vm.profileModalSettingCase = false;
          });

        },
        getCookie(e) {
          var name = e + "=";
          var decodedCookie = decodeURIComponent(document.cookie);
          var ca = decodedCookie.split(';');
          for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
              c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
              return c.substring(name.length, c.length);
            }
          }
          return "";
        },
        getUserDetails(){
          let vm = this;
          $.ajax({
              type: 'GET',
              dataType: 'JSON',
              url: 'json-php/getUserDetails.php',
              cache: false,
              beforeSend: res => {},
              error: e => console.log(e.responseText),
              success: res => vm.userDetails = res
            });
        },
        getFriActive(){
          let vm = this;
          $.ajax({
              type: 'GET',
              dataType: 'JSON',
              url: 'json-php/getAllFriends.php',
              cache: false,
              beforeSend: res => {},
              error: e => console.log(e.responseText),
              success: res => vm.friendActive = res
            });
        },
        loadMorePost(e){
          // let vm = this;
          // e.preventDefault();
          // if(this.homePage == true){
          //    if($(window).scrollTop() + $(window).height() >= $(document).height()) {
          //       //  this.postLoadMore();
          //    }
          // }
          // console.log($(document).height()); // Now Height Can Change
          //  console.log($(window).height()); //Device Height Format
          //  console.log($(window).scrollTop());// Now Scroll Update Every Time You Scroll
        },
        profileUser(){
          let vm = this;
          $.ajax({
            type:'get',
            url : 'json-php/getUserDetails.php',
            dataType:'json',
            success: res => {
              vm.globalUserPost = res.post;
              vm.globalUser     = res.details[0];
            }
          });
        },
        vueProfileUnlikes(postId){
          this.globalUserPost[0].map(res=>{
           if(res.token == postId){
              res.like_user = null;
              res.reactions--;
              if(res.reactions == 0){
                res.react_name = [];
                res.react_no = [];
              }
              if(res.reactions != 0){
                res.react_name[2] = [];
                res.react_no[2] = 0;
              }
              res.like_emoj = '';
              res.like_emoji = '';
              this.dbunlikes(res.token);
           }
          });
        },
        profileEditPostF(id){    
          this.createBrowserHistory('editPost');
          this.profilePostSetting.hide();
          this.globalUserPost.find(res=>{
           for(let i = 0;res.length > i;i++){
             if(res[i].id == id){
              this.editpost = res[i];
             }
           }
          });
          setTimeout(() => this.modalProfileEdit.show(), 100); 
        },
        profilePostSettingF(id){
          this.profileEditPostId = id;
          if(!this.profileModalSettingCase){
            setTimeout(() => this.profilePostSetting.show(), 100);
          }
          this.profileModalSettingCase = true;
        },
        editProfilePost(e){
         let vm = this;
         $.ajax({
            type: 'POST',
            url: 'includes/profileEditPost.php',
            data: {
              category : e[0].toString(),
              content  : e[1].toString(),
              pid      : e[2].toString()
            },
            cache: false,
            error: e => console.log(e.responseText),
            success:(res)=> {
              vm.profileUser();
              vm.profileEditPost = '';
              vm.editpost = [];
              vm.globalToastMsg = true;
              vm.globalNoti = 'Updated . . .';
              $(document).ready(()=> $('#globalNoti').toast('show'));
              
            }
          });
        },
        profileDelPost(id){
          const delItem = this.globalUserPost[0].find( res => res.id == id );
          this.globalUserPost[0].remove(delItem);
           $.ajax({
             type:'post',
             url :'includes/delPost.php',
             dataType:'json',
             data:{
              id  : id,
              token : delItem.token
             },
             error:e => console.log(e.responseText),
             success:res => console.log(res)
           })
           this.profilePostSetting.hide();  
        },
        activeNow(){
          $.get("active-now.php");
        },

        removeuser(e){
         console.log("removeuser ",e);
         this.allDynamicNearYou.remove(e);
        },

        getnoti(){
          let vm = this;
          $.ajax({
             type:'get',
             url :'json-php/getAllNoti.php',
             dataType:'json',
             error:e => console.log("Error",e.responseText),
             success:res => {
               console.log(res);
              if(res == null){
               vm.notiContainer = null;
              }else{
                vm.notiContainer = res;
              }
              console.log(res);
             }
           })       
         },


        // Profile Path
        changeProfilePhoto(e) {
          let vm = this;
          if (window.File && window.FileList && window.FileReader) {
            this.profile = $('#image_profile').croppie({
              enableExif: true,
              viewport: {
                  width: 300,
                  height: 300,
                  type: 'circle'
              },
              boundary: {
                  width: '300',
                  height: '300'
              }
            });

           // First times File Choose If globalImage Length is 0, Input Whatever files number 1, or 2 or . . .
            if (this.profilePhoto.length == 0) {

              this.profilePhoto = e.target.files || e.dataTransfer.files;
              // Convert Object data to Array format
              this.profilePhoto = Array.prototype.slice.call(this.profilePhoto);

              // Check Invalid Image type
              const check = this.profilePhoto[0];
              var match = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
              if (!((check.type == match[0]) || (check.type == match[1]) || (check.type == match[2]) || (check.type == match[3])))  this.profilePhoto = [];
            }

            if (this.profilePhoto.length > 0) {
              let profileReader = new FileReader();
              profileReader.onload = ( e => {
                 vm.profile.croppie('bind',{
                   url :  e.target.result
                 })
                 .then(() => console.log("Success Profile"))
              });
              profileReader.readAsDataURL(vm.profilePhoto[0]);
            }

          }else { alert("Your browser is not supports files format.");
            return null;
          }
        },
    },
    computed: {
      
    },
    created() {
      this.postUpdatedReload();
      this.vueCheckDarkMode();
      this.getallRequest();
      this.getAllUsers();
      this.getAllUsersNearYou();
      this.profileUser();
      this.getnoti();
    },
    beforeMount(){ 
      // window.addEventListener('scroll', this.loadMorePost);
        $(".reaction").livequery(function() {
            var reactionsCode = '<span class="likeTypeAction" original-title="Like" data-reaction="1"><i class="likeIcon likeType"></i></span>' +
                '<span class="likeTypeAction" original-title="Love" data-reaction="2"><i class="loveIcon likeType"></i></span>' +
                '<span class="likeTypeAction" original-title="Haha" data-reaction="3"><i class="hahaIcon likeType"></i></span>' +
                '<span class="likeTypeAction" original-title="Wow" data-reaction="4"><i class="wowIcon likeType"></i></span>' +
                '<span class="likeTypeAction" original-title="Cool" data-reaction="5"><i class="coolIcon likeType"></i></span>' +
                '<span class="likeTypeAction" original-title="Sad" data-reaction="7"><i class="sadIcon likeType"></i></span>' +
                '<span class="likeTypeAction last" original-title="Angry" data-reaction="8"><i class="angryIcon likeType"></i></span>';
            $(this).tooltipster({
                contentAsHTML: true,
                interactive: true,
                content: $(reactionsCode),
            });
        });
    },
    beforeDestroy() {
      // window.removeEventListener('scroll', this.loadMorePost);
    },
    mounted() {

        let vm = this;

        // this.cookieName = this.getCookie('name').split('+').toString().replace(/,/g,' ');
        // Add History PushState
        window.history.pushState(null, null, '#home');

        this.popSound   = new Audio("assets/sound/pop.wav");
        this.tapSound   = new Audio("assets/sound/tap.mp3");

        this.globalModal(vm);
        this.globalOffcanvas(vm);
        
        this.getFriActive();
        this.getUserDetails();

        

        let noti = '';
        setTimeout(() => {
         if(vm.notiContainer != null){
            vm.notiContainer.map(e=>{   
               if(e.seen == 0){
                noti++;
               }
             });
           $('#mainoti').attr('data',noti);
             console.log(noti)
           }
        }, 500);



        // Scroll Load

        $("body").on("click", ".likeTypeAction", function (e) {
            vm.popSound.play();
            var reactionId = $(this).attr("data-reaction");
            var reactName =  $(this).attr("original-title");
            var react =  reactName.toLowerCase();

            var x = $(this).parent().parent().attr("id");
            var sid = x.split("reaction");
            var postId = sid[1];

            vm.highOrderRanking.map(res=>{

              if(res.token == postId && res.like_user == null){
                  res.like_user = vm.cookieId;
                  res.reactions++;
                  if(res.reactions == 1){
                    res.react_name.push(react,'love','haha');
                    res.react_no.push(1,0,0);
                  }
                  if(res.reactions > 1){
                    res.react_name[2] = react;
                    res.react_no[2] = 1;
                  }
                  res.like_emoj = react;
                  res.like_emoji = reactName;
                  vm.dblikes(res.token,reactionId);

                  if(res.unlike_user == vm.cookieId){
                    vm.vueundangerlikes(postId);
                  }
              }
              // if(res.token == postId && res.like_user == vm.cookieId){
              //    if(res.reactions == 1){
              //       res.react_name[0] = react;
              //       res.react_no[0]   = 1;
              //     }
              //     if(res.reactions > 1){
              //       res.react_name[2] = react;
              //       res.react_no[2] = 1;
              //     }
              //     res.like_emoj = react;
              //     res.like_emoji = reactName;

              //     $.ajax({
              //      type: 'post',
              //      url: 'likes-unlikes-comments/update.php',
              //      cache: false,
              //      data: {
              //         user_id : vm.cookieId,
              //         token   : postId,
              //         emoji   : reactionId,
              //         state   : 'updatelikes'
              //      },
              //      error : (e)=>{
              //        console.log(e);
              //      },
              //      success:(re)=>{
              //       console.log("update reaction");
              //      }
              //     });
              // }
            });

            if(vm.profilePage == true){
              vm.globalUserPost[0].map(res=>{
                if(res.token == postId && res.like_user == null){
                    res.like_user = vm.cookieId;
                    res.reactions++;
                    if(res.reactions == 1){
                      res.react_name.push(react,'love','haha');
                      res.react_no.push(1,0,0);
                    }
                    if(res.reactions > 1){
                      res.react_name[2] = react;
                      res.react_no[2] = 1;
                    }
                    res.like_emoj = react;
                    res.like_emoji = reactName;
                    vm.dblikes(res.token,reactionId);
  
                    // if(res.unlike_user == vm.cookieId){
                    //   vm.vueundangerlikes(postId);
                    // }
                }
                if(res.token == postId && res.like_user == vm.cookieId){
                   if(res.reactions == 1){
                      res.react_name[0] = react;
                      res.react_no[0]   = 1;
                    }
                    if(res.reactions > 1){
                      res.react_name[2] = react;
                      res.react_no[2] = 1;
                    }
                    res.like_emoj = react;
                    res.like_emoji = reactName;
  
                    $.ajax({
                     type: 'post',
                     url: 'likes-unlikes-comments/update.php',
                     cache: false,
                     data: {
                        user_id : vm.cookieId,
                        token   : postId,
                        emoji   : reactionId,
                        state   : 'updatelikes'
                     },
                     error : (e)=>{
                       console.log(e);
                     },
                     success:(re)=>{
                      console.log("update reaction");
                     }
                    });
                }
              });
            }

            if(vm.globalFriPosts != ''){
             vm.globalFriPosts.map(res=>{
              if(res.token == postId && res.like_user == null){
                  res.like_user = vm.cookieId;
                  res.reactions++;
                  if(res.reactions == 1){
                    res.react_name.push(react,'love','haha');
                    res.react_no.push(1,0,0);
                  }
                  if(res.reactions > 1){
                    res.react_name[2] = react;
                    res.react_no[2] = 1;
                  }
                  res.like_emoj = react;
                  res.like_emoji = reactName;
                  vm.dblikes(res.token,reactionId);

                  if(res.unlike_user == vm.cookieId){
                    vm.vueundangerlikes(postId);
                  }
              }
            });
            }

            vm.profileUser();
            // vm.getSessionUpdate();
            $("#" + x).hide();

            return false;
        });

        setInterval(() => {
          $.get("active-now.php");
          vm.getFriActive();
          // vm.getnoti();
          vm.friRequestNoti = vm.allDynamicFriRequest.length;
          let data = '';
          if(vm.friRequestNoti != 0){
             data = vm.friRequestNoti
          }
          $('#rsnoti').attr('data', data);
          
        }, 10000);

        

        //  $(window).on("load", function() { })
        window.addEventListener('load', () => {
            console.log(vm.highOrderRanking); 
            setInterval(() => vm.requestRefresh(),3000);   
        });


        // Array remove Function
        Array.prototype.remove = function() {
            var what, a = arguments,
                L = a.length,
                ax;
            while (L && this.length) {
                what = a[--L];
                while ((ax = this.indexOf(what)) !== -1) {
                    this.splice(ax, 1);
                }
            }
            return this;
        }

        // Check  History Change
        if (window.history && window.history.pushState) {

            $(window).on('popstate', e => {
                // Get Url Href & Hash
                let $hash = window.location.hash;
                let $href = window.location.href;

                if(!$hash.includes('postview')){
                  vm.globalPostView.hide();
                }

                if (!$hash.includes('#addNewPost')) {
                    vm.addPostModal.hide();
                }

                if(!$hash.includes('#editPost')) {
                  vm.modalProfileEdit.hide();
                }

                if(!$hash.includes('#profileView')){
                  vm.modalProfile.hide();
                }

                if(vm.viewPostCase == true){
                  if (!$hash.includes('#view')) {
                     vm.postView.hide();
                  }
                }

                if(!$hash.includes('-')){
                  vm.modalReactions.hide();
                }

                if (!$hash.includes('#comments')) {
                  vm.modalProfile.hide();
                  vm.modalComments.hide();
                  vm.giphyStickerModal.hide();
                  vm.giphyGifModal.hide();
                }

                if(!$hash.includes('#commentsreply')){
                  vm.modalReply.hide();
                  vm.giphyStickerModal.hide();
                  vm.giphyGifModal.hide();
                }

                if(!$hash.includes('savepost')){
                  vm.modalSavedPost.hide();
                }

                if ($hash == '#home') {
                    vm.homePage = true;
                    vm.relationPage = false;
                    vm.globalPage = false;
                    vm.notiPage = false;
                    vm.profilePage = false;
                    vm.routerLinkActive(0);
                    // Refresh GlobalComment Id
                    vm.globalcommentId = '';
                    // Refresh Comment Reverse Porperty
                    vm.cmreverse = false;

                    if(vm.viewPostCase == true){
                      vm.postView.hide();
                    }
                    vm.postSetting.hide();
                    vm.modalSettingCase = false;

                    console.log("Home Back Work");
                    // window.location.hash = '#home';
                }

                if ($hash == '#friends') {
                    vm.homePage = false;
                    vm.relationPage = true;
                    vm.globalPage = false;
                    vm.notiPage = false;
                    vm.profilePage = false;
                    vm.routerLinkActive(1);
                    vm.getallRequest();
                    vm.getAllUsers();
                    vm.getAllUsersNearYou();
                }

                if ($hash == '#global') {
                    vm.homePage = false;
                    vm.relationPage = false;
                    vm.globalPage = true;
                    vm.notiPage = false;
                    vm.profilePage = false;
                    vm.routerLinkActive(2);
                }

                if ($hash == '#noti') {
                    vm.homePage = false;
                    vm.relationPage = false;
                    vm.globalPage = false;
                    vm.notiPage = true;
                    vm.profilePage = false;
                    vm.routerLinkActive(3);
                }

                if ($hash == '#profile') {
                    vm.homePage = false;
                    vm.relationPage = false;
                    vm.globalPage = false;
                    vm.notiPage = false;
                    vm.profilePage = true;
                    vm.routerLinkActive(4);
                }
            });
        }



        // deepai.setApiKey('7d93926e-b78f-4deb-8334-9185431f6d1d');

        // Slide Screen Nav by Hash Url
        setInterval(() => {
            this.slideRight(window.location.hash);
            this.slideLeft(window.location.hash);
            this.screenTouch = "";
        }, 200);

    },
      components: {
       vuejsDatepicker
   }
 })

});


window.addEventListener('DOMContentLoaded',()=>{
 console.log("Loading . . .");
 loading.style.display = 'block';
 app.style.display = 'none';
})

</script>
</body>

</html>