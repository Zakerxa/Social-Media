<?php

require "../includes/init.php";
require "../assets/php/tnc.php";

// Final State Get All Post Data By ID

if (!empty($_POST['id'])) {


    $commentsreply = array();

    $cm_id = escape($_POST['id']);

    $stmtReplyFinal = $pdo->prepare("SELECT id,username,pic,profile,cm_id,rp_content,rp_photo,rp_path,rp_created_date,rp_id FROM replys LEFT JOIN users ON replys.rp_user_id = users.id WHERE cm_id = ? ORDER BY rp_id ASC");
    $finalResult = $stmtReplyFinal->execute([$cm_id]);
    $finalResult = $stmtReplyFinal->fetchAll();

  
    if ($finalResult) {

        foreach ($finalResult as $key => $value) {
            preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $value['rp_content'], $match);

            $row_arr['uname'] = $value['username'];
            $row_arr['pic'] = $value['pic'];
            $row_arr['profile'] = $value['profile'];
            $row_arr['content'] = htmlspecialchars_decode(trim($value['rp_content']), ENT_QUOTES);
            $row_arr['check_photo'] = $value['rp_photo'];
            $row_arr['photo'] = "uploads/0areplyPhoto/" . $value['rp_path'] . "/" . $value['rp_photo'];
            $row_arr['link'] = $match[0];
            $row_arr['user'] = $value['id'];
            $row_arr['path'] = $value['rp_path'];
            $row_arr['post_id'] = $value['cm_id'];
            $row_arr['time'] = commentTime($value['rp_created_date']);
            $row_arr['id'] = $value['rp_id'];
            $row_arr['like_user']   = null;


            // // Like Count Place

            // $stmtCmLike = $pdo->prepare("SELECT * FROM comment_likes WHERE cm_text_id = ?");
            // $stmtCmLike->execute([$finalResult[$key]['cm_id']]);
            // $total_Like = $stmtCmLike->fetchAll();


            // if($total_Like){
            //     foreach ($total_Like as $key => $data) {
            //         if($data['cm_like_user_id'] == $id){
            //            $row_arr['like_user'] = $id;
            //         }
            //     }
            // }

            // $row_arr['likes']    = $stmtCmLike->rowCount();


            $commentsreply['reply'][] = $row_arr;
        }


        
    } else {
        $commentsreply['reply'][] = null;
    }



    $stmtFinal = $pdo->prepare("SELECT id,username,pic,profile,cm_post_id,cm_content,cm_photo,cm_path,cm_created_date,cm_id FROM comments LEFT JOIN users ON comments.cm_user_id = users.id WHERE cm_id = ?");
    $result = $stmtFinal->execute([$cm_id]);
    $result = $stmtFinal->fetch(PDO::FETCH_ASSOC);
    
    if($result){

        preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $result['cm_content'], $match);

        $row_reply['uname'] = $result['username'];
        $row_reply['pic'] = $result['pic'];
        $row_reply['profile'] = $result['profile'];
        $row_reply['content'] = htmlspecialchars_decode($result['cm_content'], ENT_QUOTES);
        $row_reply['check_photo'] = $result['cm_photo'];
        $row_reply['photo'] = "uploads/0acommentPhoto/" . $result['cm_path'] . "/" . $result['cm_photo'];
        $row_reply['link'] = $match[0];
        $row_reply['path'] = $result['cm_path'];
        $row_reply['post_id'] = $result['cm_id'];
        $row_reply['user'] = $result['id'];
        $row_reply['time'] = commentTime($result['cm_created_date']);
        $row_reply['id'] = $result['cm_id'];
        $row_reply['like_user']   = null;


         // Like Count Place
         $stmtCmLike = $pdo->prepare("SELECT * FROM comment_likes WHERE cm_text_id = ?");
         $stmtCmLike->execute([$cm_id]);
         $total_LikeCm = $stmtCmLike->fetchAll();


         if($total_LikeCm){
            foreach ($total_LikeCm as $key => $data) {
                if($data['cm_like_user_id'] == $id){
                   $row_reply['like_user'] = $id;
                }
            }
        }

         $row_reply['likes']    = $stmtCmLike->rowCount();

        $commentsreply['comment'][] = $row_reply;
    }


    echo json_encode($commentsreply, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);


} else {
    header("location:../index.php");
}
