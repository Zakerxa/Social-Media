<?php

require '../includes/init.php';
require "../assets/php/tnc.php";

$post = array();


if (isset($_POST['id'])) {

    $postId = $_POST['id'];

    $stmtFinal = $pdo->prepare("SELECT * FROM posts LEFT JOIN users ON posts.user_id = users.id WHERE posts.p_id = ?");
    $value = $stmtFinal->execute([$postId]);
    $value = $stmtFinal->fetch(PDO::FETCH_ASSOC);

    $stmtCm = $pdo->prepare("SELECT cm_id FROM comments WHERE cm_post_id = :id");
    $stmtCm->execute(
        array(':id' => $postId)
    );
    $totalComment = $stmtCm->fetchAll();


    if ($value) {
        // $post['post'][] = $finalResult;

        preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $value['content'], $match);

        if ($value['category'] == 'Friends') {
            $icon = 'fa-users';
        } else {
            $icon = 'fa-globe';
        }
        $row_array['category'] = $icon;
        $row_array['content'] = htmlspecialchars_decode(trim($value['content']), ENT_QUOTES);
        $row_array['images'] = explode(",pa1@-@th2,", $value['photo']);
        $row_array['token'] = $value['post_token'];
        $row_array['path'] = $value['path'];
        $row_array['link'] = $match[0];
        $row_array['name'] = $value['username'];
        $row_array['pic'] = $value['pic'];
        $row_array['user_id'] = $value['user_id'];
        $row_array['profile'] = $value['profile'];
        $row_array['id'] = $value['p_id'];
        $row_array['datetime'] = $value['created_date'];
        $row_array['commentTime'] = commentTime($value['created_date']);
        $row_array['time'] = timeZone($value['created_date']);
        $row_array['like_user'] = null;
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
        $row_array['share_post'] = null;
        $row_array['share_dis'] = null;

        $row_array['type'] = $value['type'];

        if ($value['type'] == 'share') {
            $row_array['share_post'] = $value['share_post'];
        }

        // User Emoji
        $stmt = $pdo->prepare("SELECT name FROM likes LEFT JOIN reactions ON reactions.rid=likes.rid_fk WHERE likes.like_user_id='$id' AND likes.token = ?");
        $stmt->execute([$value['post_token']]);
        $stmt->execute();
        $emoji = $stmt->fetch(PDO::FETCH_ASSOC);

        // Total Like & Reaction Count Place
        $stmtReaction = $pdo->prepare("SELECT * FROM likes LEFT JOIN reactions ON reactions.rid=likes.rid_fk WHERE token = ?");
        $stmtReaction->execute([$value['post_token']]);
        $total_Reaction = $stmtReaction->fetchAll();

        // Unlike Count Place

        $stmtDangerLike = $pdo->prepare("SELECT * FROM unlikes WHERE token = ?");
        $stmtDangerLike->execute([$value['post_token']]);
        $total_DangerLike = $stmtDangerLike->fetchAll();

        // Comments Count Place

        $stmtComments = $pdo->prepare("SELECT cm_id FROM comments WHERE cm_post_id = ?");
        $stmtComments->execute([$value['p_id']]);
        $total_Comments = $stmtComments->fetchAll();

        // Save Post Check
        $stmtSave = $pdo->prepare("SELECT * FROM saveposts WHERE post_id = ?");
        $checkSavePost = $stmtSave->execute([$value['p_id']]);
        $checkSavePost = $stmtSave->fetchAll();

        $row_array['reply'] = 0;

        // Number of comments
        if ($total_Comments) {
            foreach ($total_Comments as $key => $value) {
                $stmtReplyFinal = $pdo->prepare("SELECT * FROM replys WHERE cm_id = ?");
                $finalResult = $stmtReplyFinal->execute([$value['cm_id']]);
                $row_array['reply'] += $stmtReplyFinal->rowCount();
            }
        }

        // User Emoji Show
        if ($emoji) {
            $row_array['like_emoji'] = $emoji['name'];
            $row_array['like_emoj'] = strtolower($emoji['name']);
        }

        // Number of unlikes
        if ($total_DangerLike) {
            foreach ($total_DangerLike as $unlikedata) {
                if ($unlikedata['unlike_user_id'] == $id) {
                    $row_array['unlike_user'] = $unlikedata['unlike_user_id'];
                }
            }
        }

        // Check this post is already save or not
        if ($checkSavePost) {
            foreach ($checkSavePost as $savePost) {
                if ($savePost['user_id'] == $id) {
                    $row_array['save'] = $savePost['user_id'];
                }
            }
        }

        $row_array['reactions'] = $stmtReaction->rowCount();

        // Number of likes & Reaction

        $row_array['react_no'] = [];
        $row_array['react_name'] = [];

        $emojiArray = array("love" => 0, "haha" => 0, "like" => 0, "angry" => 0, "wow" => 0, "sad" => 0, "cool" => 0);
        if ($total_Reaction) {

            foreach ($total_Reaction as $key => $data) {

                if ($data['like_user_id'] == $id) {
                    $row_array['like_user'] = $data['like_user_id'];
                }

                switch (strtolower($data['name'])) {
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
                $row_array['react_no'][] = $value;
            }

            $row_array['react_name'] = array_slice($row_array['react_name'], 0, 3);
            $row_array['react_no'] = array_slice($row_array['react_no'], 0, 3);

        }

        $row_array['unlikes'] = $stmtDangerLike->rowCount();

        $row_array['comments'] = ($stmtComments->rowCount() + $row_array['reply']);

        $row_array['ranking'] = ($row_array['reactions'] + $stmtComments->rowCount()) - $row_array['unlikes'];

        $post['post'][] = $row_array;

    }


    if ($totalComment) {

        foreach ($totalComment as $key => $value) {
            $stmtFinal = $pdo->prepare("SELECT id,username,pic,profile,cm_post_id,cm_content,cm_photo,cm_path,cm_created_date,cm_id FROM comments LEFT JOIN users ON comments.cm_user_id = users.id WHERE cm_id = ?");
            $result = $stmtFinal->execute([$value['cm_id']]);
            $result = $stmtFinal->fetch(PDO::FETCH_ASSOC);

            if ($result) {

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
                $row_reply['like_user'] = null;
                

                // Hign Ranking Comments Actually Not Haha :)
                $stmtReplysAtLeastOne = $pdo->prepare("SELECT id,username,pic,profile,rp_content,rp_photo,rp_path,rp_created_date FROM replys LEFT JOIN users ON replys.rp_user_id = users.id WHERE cm_id = ? ORDER BY rp_id ASC LIMIT 3");
                $replysAtLeastOne = $stmtReplysAtLeastOne->execute([$value['cm_id']]);
                $replysAtLeastOne = $stmtReplysAtLeastOne->fetch(PDO::FETCH_ASSOC);


                // Like Count Place
                $stmtCmLike = $pdo->prepare("SELECT * FROM comment_likes WHERE cm_text_id = ?");
                $stmtCmLike->execute([$value['cm_id']]);
                $total_LikeCm = $stmtCmLike->fetchAll();


                if ($replysAtLeastOne) {
                    $row_reply['rp_user_pic'] = $replysAtLeastOne['pic'];
                    $row_reply['rp_user_profile'] = $replysAtLeastOne['profile'];
                    $row_reply['rp_user_name'] = $replysAtLeastOne['username'];
                    $row_reply['rp_user']      = $replysAtLeastOne['id'];
                    $row_reply['rp_user_content'] =  htmlspecialchars_decode(trim($replysAtLeastOne['rp_content']), ENT_QUOTES);
                    $row_reply['rp_user_time'] = commentTime($replysAtLeastOne['rp_created_date']);
                } else {
                    $row_reply['rp_user_pic'] = null;
                    $row_reply['rp_user_profile'] = null;
                    $row_reply['rp_user']      = null;
                    $row_reply['rp_user_name'] = null;
                    $row_reply['rp_user_content'] = null;
                    $row_reply['rp_user_time'] = null;
                }



                if ($total_LikeCm) {
                    foreach ($total_LikeCm as $key => $data) {
                        if ($data['cm_like_user_id'] == $id) {
                            $row_reply['like_user'] = $id;
                        }
                    }
                }

                $row_reply['likes'] = $stmtCmLike->rowCount();
                $row_reply['reply'] = $stmtReplysAtLeastOne->rowCount();

                if($row_reply['reply'] > 2){
                    $row_reply['viewmorereply'] = true;
                }else{
                    $row_reply['viewmorereply'] = false;
                }

                $post['comment'][] = $row_reply;
            }
        }
    }

   echo json_encode($post, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);






}else{
    header("location:../index.php");
}


