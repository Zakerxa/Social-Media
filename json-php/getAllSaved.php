<?php

include "../includes/init.php";
include "../assets/php/tnc.php";

// Scroll End Load More Data

$savePostId = array();
$totalSavePost = array();

if (!empty($id)) {
    $stmtPublicPost = $pdo->prepare("SELECT post_id FROM saveposts WHERE user_id='$id' ORDER BY id DESC");
    $result = $stmtPublicPost->execute();
    $result = $stmtPublicPost->fetchAll();

// Public Post
    if ($result) {
        foreach ($result as $key => $value) {
            array_push($savePostId, $value);
        }
    }

    foreach ($savePostId as $key => $value) {
        // Final State Get All Post Data By ID
        $stmtFinal = $pdo->prepare("SELECT * FROM posts LEFT JOIN users ON posts.user_id = users.id WHERE posts.p_id = ?");
        $finalResult = $stmtFinal->execute([$value['post_id']]);
        $finalResult = $stmtFinal->fetchAll(); // SECOND STATE GET MY FRI POST ID LIMIT 50
        // If Friend exist
        if ($finalResult) {
            foreach ($finalResult as $key => $value) {
                array_push($totalSavePost, $value);
            }
        }
    }

// Final Result

    if ($totalSavePost == []) {
        echo "empty";
    } else {
        echo json_encode(jsonArrayFormatPost($totalSavePost, $pdo, $id), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
    }

}else{
    header("location:../index.php");
}
