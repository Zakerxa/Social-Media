<?php

require "../includes/init.php";
require "../assets/php/tnc.php";

// Final State Get All Post Data By ID

if (!empty($_POST['id'])) {

    $limit = 15;

    if (isset($_POST['commentloadmore'])) {
        $limit = $_POST['commentloadmore'];
    }

    $sort = 'ASC';

    if (isset($_POST['sort'])) {
        $sort = $_POST['sort'];
    }

    $cm_post_id = escape($_POST['id']);
    $stmtFinal = $pdo->prepare("SELECT username,pic,profile,cm_post_id,cm_user_id,cm_content,cm_photo,cm_path,cm_created_date,cm_id FROM comments LEFT JOIN users ON comments.cm_user_id = users.id WHERE cm_post_id = ? ORDER BY cm_id $sort LIMIT $limit");
    $finalResult = $stmtFinal->execute([$cm_post_id]);
    $finalResult = $stmtFinal->fetchAll();

    $comments = array();

    if ($finalResult) {
        foreach ($finalResult as $key => $value) {
            preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $value['cm_content'], $match);

            $row_arr['uname'] = $value['username'];
            $row_arr['pic'] = $value['pic'];
            $row_arr['profile'] = $value['profile'];
            $row_arr['content'] = htmlspecialchars_decode(trim($value['cm_content']), ENT_QUOTES);
            $row_arr['check_photo'] = $value['cm_photo'];
            $row_arr['photo'] = "uploads/0acommentPhoto/" . $value['cm_path'] . "/" . $value['cm_photo'];
            $row_arr['link'] = $match[0];
            $row_arr['path'] = $value['cm_path'];
            $row_arr['post_id'] = $value['cm_post_id'];
            $row_arr['time'] = commentTime($value['cm_created_date']);
            $row_arr['id'] = $value['cm_id'];
            $row_arr['user'] = $value['cm_user_id'];
            $row_arr['like_user']   = null;
            $row_arr['viewmorereply'] = false;

            // Hign Ranking Comments Actually Not Haha :)
            $stmtReplysAtLeastOne = $pdo->prepare("SELECT id,username,pic,profile,rp_content,rp_photo,rp_path,rp_created_date FROM replys LEFT JOIN users ON replys.rp_user_id = users.id WHERE cm_id = ? ORDER BY rp_id ASC LIMIT 3");
            $replysAtLeastOne = $stmtReplysAtLeastOne->execute([$finalResult[$key]['cm_id']]);
            $replysAtLeastOne = $stmtReplysAtLeastOne->fetch(PDO::FETCH_ASSOC);

            // Like Count Place

            $stmtCmLike = $pdo->prepare("SELECT * FROM comment_likes WHERE cm_text_id = ?");
            $stmtCmLike->execute([$finalResult[$key]['cm_id']]);
            $total_Like = $stmtCmLike->fetchAll();

            if ($replysAtLeastOne) {
                $row_arr['rp_user_pic'] = $replysAtLeastOne['pic'];
                $row_arr['rp_user_profile'] = $replysAtLeastOne['profile'];
                $row_arr['rp_user_name'] = $replysAtLeastOne['username'];
                $row_arr['rp_user']      = $replysAtLeastOne['id'];
                $row_arr['rp_user_content'] =  htmlspecialchars_decode(trim($replysAtLeastOne['rp_content']), ENT_QUOTES);
                $row_arr['rp_user_time'] = commentTime($replysAtLeastOne['rp_created_date']);
            } else {
                $row_arr['rp_user_pic'] = null;
                $row_arr['rp_user_profile'] = null;
                $row_arr['rp_user']      = null;
                $row_arr['rp_user_name'] = null;
                $row_arr['rp_user_content'] = null;
                $row_arr['rp_user_time'] = null;
            }

            if($total_Like){
                foreach ($total_Like as $key => $data) {
                    if($data['cm_like_user_id'] == $id){
                       $row_arr['like_user'] = $id;
                    }
                }
            }

            $row_arr['likes']    = $stmtCmLike->rowCount();

            $row_arr['reply'] = $stmtReplysAtLeastOne->rowCount();

            

            if($row_arr['reply'] > 2){
                $row_arr['viewmorereply'] = true;
            }else{
                $row_arr['viewmorereply'] = false;
            }


            array_push($comments, $row_arr);
        }

        echo json_encode($comments, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);

    } else {
        echo "null";
    }

} else {
    header("location:../index.php");
}

// foreach ($Container as $key => $value) {
//     $dateTime[] = $value['datetime'];
// }
// foreach ($Container as $key => $value) {
//     $rankingPost[] = $value['ranking'];
// }

// array_multisort($dateTime, SORT_DESC, $rankingPost, SORT_DESC, $Container);
