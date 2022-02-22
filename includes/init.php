<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
session_regenerate_id(true);

require 'class/database.php';
require 'class/user.php';
require 'class/friend.php';
require 'class/likes-comments.php';

// DATABASE CONNECTIONS
$database           = new Database();
$pdo                = $database->dbConnection();


$user_obj           = new User($pdo);
$fri_obj            = new Friend($pdo);
$likesunlike_obj = new LikesAndComments($pdo);


date_default_timezone_set("Asia/Yangon");
$diffWithGMT = 6 * 60 * 60 + 30 * 60; //converting time difference to seconds.
$ygntime = gmdate("Y-m-d H:i:s", time() + $diffWithGMT);
$ygndate = gmdate("Y-F-d", time() + $diffWithGMT);


function escape($html){
    return htmlspecialchars($html, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}

function unescape($html){
    return html_entity_decode($html);
}

if (empty($_SESSION['CSRF'])) {
    if (function_exists('random_bytes')) {
        $_SESSION['CSRF'] = bin2hex(random_bytes(32));
    } else {
        $_SESSION['CSRF'] = bin2hex(openssl_random_pseudo_bytes(32));
    }
}


function jsonArrayFormatPost($InsertArr, $pdo, $id){
    $Container = array();
    $icon = '';
    foreach ($InsertArr as $key => $value) {
  
        preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $value['content'], $match);
  
        if ($value['category'] == 'Friends') {
            $icon = 'fa-users';
        }
        if($value['category'] == 'Region'){
           $icon  = 'fa-map';
        }
        if($value['category'] == 'Anyone'){
            $icon = 'fa-globe';
        }
        $row_array['category']    = $icon;
        $row_array['catname']     = $value['category'];
        $row_array['content']     = htmlspecialchars_decode(trim($value['content']), ENT_QUOTES);
        $row_array['images']      = explode(",pa1@-@th2,", $value['photo']);
        $row_array['token']       = $value['post_token'];
        $row_array['path']        = $value['path'];
        $row_array['link']        = $match[0];
        $row_array['name']        = $value['username'];
        $row_array['pic']         = $value['pic'];
        $row_array['user_id']     = $value['user_id'];
        $row_array['profile']     = $value['profile'];
        $row_array['id']          = $value['p_id'];
        $row_array['row']         = $value['user_row'];
        $row_array['datetime']    = $value['created_date'];
        $row_array['commentTime'] = commentTime($value['created_date']);
        $row_array['time']        = timeZone($value['created_date']);
        $row_array['like_user']   = null;
        $row_array['unlike_user'] = null;
      

        
        $row_array['save'] = null;


        $row_array['share_name'] = null;
        $row_array['share_pic'] = null;
        $row_array['share_images'] = null;
        $row_array['share_time'] = null;
        $row_array['share_user_id'] = null;
        $row_array['share_token'] = null;
        $row_array['share_commentTime'] = null;
        $row_array['share_path'] = null;
        $row_array['share_link'] = null;
        $row_array['share_name'] = null;
        $row_array['share_content'] = null;
        $row_array['share_post']  = null;
        $row_array['share_dis']   = null;

        $row_array['type']        = $value['type'];

        if($value['type'] == 'share'){
           $row_array['share_post'] = $value['share_post'];
        }

        // User Emoji
        $stmt = $pdo->prepare("SELECT name FROM likes LEFT JOIN reactions ON reactions.rid=likes.rid_fk WHERE likes.like_user_id='$id' AND likes.token = ?");
        $stmt->execute([$InsertArr[$key]['post_token']]);
        $stmt->execute();
        $emoji= $stmt->fetch(PDO::FETCH_ASSOC);
  
        // Total Like & Reaction Count Place
        $stmtReaction = $pdo->prepare("SELECT * FROM likes LEFT JOIN reactions ON reactions.rid=likes.rid_fk WHERE token = ?");
        $stmtReaction->execute([$InsertArr[$key]['post_token']]);
        $total_Reaction = $stmtReaction->fetchAll();
  
        // Unlike Count Place
        $stmtDangerLike = $pdo->prepare("SELECT * FROM unlikes WHERE token = ?");
        $stmtDangerLike->execute([$InsertArr[$key]['post_token']]);
        $total_DangerLike = $stmtDangerLike->fetchAll();
  
        // Comments Count Place
        $stmtComments = $pdo->prepare("SELECT cm_id FROM comments WHERE cm_post_id = ?");
        $stmtComments->execute([$InsertArr[$key]['p_id']]);
        $total_Comments = $stmtComments->fetchAll();

        // Hign Ranking Comments One
        $stmtCommentsAtLeastOne = $pdo->prepare("SELECT id,username,pic,cm_id,cm_content,cm_photo,cm_path,cm_created_date FROM comments LEFT JOIN users ON comments.cm_user_id = users.id WHERE cm_post_id = ? ORDER BY cm_id DESC LIMIT 1");
        $commentsAtLeastOne = $stmtCommentsAtLeastOne->execute([$InsertArr[$key]['p_id']]);
        $commentsAtLeastOne = $stmtCommentsAtLeastOne->fetch(PDO::FETCH_ASSOC);


        // Save Post Check
        $stmtSave = $pdo->prepare("SELECT * FROM saveposts WHERE post_id = ?");
        $checkSavePost = $stmtSave->execute([$InsertArr[$key]['p_id']]);
        $checkSavePost = $stmtSave->fetchAll();


        $row_array['reply'] = 0;
        
        // Number of comments
        if($total_Comments){
           foreach ($total_Comments as $key => $value) {
             $stmtReplyFinal = $pdo->prepare("SELECT * FROM replys WHERE cm_id = ?");
             $finalResult = $stmtReplyFinal->execute([$value['cm_id']]);
             $row_array['reply'] += $stmtReplyFinal->rowCount();
           }
        }

        // User Emoji Show
        if($emoji){
            $row_array['like_emoji']  = $emoji['name'];
            $row_array['like_emoj'] = strtolower($emoji['name']);
        }
  

  
        // Number of unlikes
        if($total_DangerLike){
            foreach ($total_DangerLike as $unlikedata) {
                if($unlikedata['unlike_user_id'] == $id){
                   $row_array['unlike_user'] = $unlikedata['unlike_user_id'];
                }
            }
        }
  

        // Check this post is already save or not
        if($checkSavePost){
            foreach ($checkSavePost as $savePost) {
                if($savePost['user_id'] == $id){
                   $row_array['save'] = $savePost['user_id'];
                }
            }
        }

        $row_array['reactions']    = $stmtReaction->rowCount();

        // Number of likes & Reaction
        
        $row_array['react_no']    = [];
        $row_array['react_name']  = [];
        
        $emojiArray = array("love"=>0,"haha"=>0,"like"=>0,"angry"=>0,"wow"=>0,"sad"=>0,"cool"=>0);
        if($total_Reaction){
            
           foreach ($total_Reaction as $key => $data) {
            
              if($data['like_user_id'] == $id){
                 $row_array['like_user'] = $data['like_user_id'];
              }
              
             
                switch(strtolower($data['name'])) {
                   case 'love':
                        $emojiArray['love']++;
                        break;
                   case 'haha':
                        $emojiArray['haha']++;
                        break;
                   case 'like':
                        $emojiArray['like']++;
                        break;
                   case 'angry':
                        $emojiArray['angry']++;
                        break;
                   case 'wow':
                        $emojiArray['wow']++;
                        break;
                   case 'sad':
                        $emojiArray['sad']++;
                        break;
                   case 'cool':
                        $emojiArray['cool']++;
                        break;
                    default:
                      break;
                }     
                
                arsort($emojiArray);
                
           }

           foreach ($emojiArray as $key => $value) {
             # code...
             $row_array['react_name'][] = $key;
             $row_array['react_no'][]   = $value;
           }

           $row_array['react_name'] = array_slice($row_array['react_name'], 0, 3);
           $row_array['react_no'] = array_slice($row_array['react_no'], 0, 3);


        }

        
    
        $row_array['unlikes']  = $stmtDangerLike->rowCount();

        $row_array['comments'] = ($stmtComments->rowCount() + $row_array['reply']);

        $row_array['ranking']  = ($row_array['reactions'] + $stmtComments->rowCount()) - $row_array['unlikes'];

        $row_array['reactionsnc']    = nc($stmtReaction->rowCount());
        $row_array['unlikesnc']      = nc($stmtDangerLike->rowCount());
        $row_array['commentsnc']     = nc($stmtComments->rowCount() + $row_array['reply']);




        if ($commentsAtLeastOne) {

           // Hign Ranking Comments One Count
           $stmtCmLike = $pdo->prepare("SELECT * FROM comment_likes WHERE cm_text_id = ?");
           $stmtCmLike->execute([$commentsAtLeastOne['cm_id']]);

           $row_array['cm_user_pic']     = $commentsAtLeastOne['pic'];
           $row_array['cm_user_name']    = $commentsAtLeastOne['username'];
           $row_array['cm_user_content'] = htmlspecialchars_decode(trim($commentsAtLeastOne['cm_content']), ENT_QUOTES);
           $row_array['cm_user_check_photo'] = $commentsAtLeastOne['cm_photo'];
           $row_array['cm_user_photo']   = "uploads/0acommentPhoto/".$commentsAtLeastOne['cm_path']."/".$commentsAtLeastOne['cm_photo'];
           $row_array['cm_user_time']    = commentTime($commentsAtLeastOne['cm_created_date']);
           $row_array['cm_user_id']    = $commentsAtLeastOne['id'];
           $row_array['cm_likes']    = $stmtCmLike->rowCount();
           
        }else{
           $row_array['cm_user_pic']         = null;
           $row_array['cm_user_name']        = null;
           $row_array['cm_user_check_photo'] = null;
           $row_array['cm_user_photo']       = null;
           $row_array['cm_user_content']     = null;
           $row_array['cm_user_time']        = null;
           $row_array['cm_user_id']    = null;
        }
    
        array_push($Container, $row_array);
  
    }
  
   
    foreach ($Container as $key => $value) {
        $dateTime[] = $value['datetime'];
    }
    foreach ($Container as $key => $value) {
        $rankingPost[] = $value['ranking'];
    }

        
    array_multisort($dateTime, SORT_DESC, $rankingPost, SORT_DESC, $Container);   
        
        
    // array_multisort($likesRankingPost, SORT_DESC, SORT_STRING, $Container);   
    
     return $Container; 
  }


$http = 'http://';

function back(){
    header("location:../index.php");
    exit();
}



if(isset($_COOKIE['id'])){

  $id = $_COOKIE['id'];

  $stmt_user = $pdo->prepare("SELECT pic,username,dark_mode,get_start,city,user_row FROM users WHERE id='$id'");
  $data  = $stmt_user->execute();
  $data  = $stmt_user->fetch(PDO::FETCH_ASSOC);

  if($data){
   
    $authorName = $data['username'];
    $getstarted = $data['get_start'];
    $region     = $data['city'];
    $profile    = $data['pic'];
    $userrow    = $data['user_row'];

    if($data['dark_mode'] == '0'){
        $darkmode = false;
    }else{
        $darkmode = true;
    }

  }


}

