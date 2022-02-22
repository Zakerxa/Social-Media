<?php

$stmt = $pdo->prepare("SELECT * FROM friends WHERE user_one = :my_id OR user_two = :my_id");
$stmt->bindValue(':my_id',$id, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll();

$total_fri = $stmt->rowCount();

$friends = array();

if($result){
    foreach ($result as $key => $value) {
        if($value['user_one'] == $id){
            $row_array = $value['user_two'];
        }
        if($value['user_two'] == $id){
            $row_array = $value['user_one'];
        }
        array_push($friends,$row_array);
    }
}

// Insert myid to $friList_Arr to see Frien Only Place
array_push($friends,$id);

// Create Empty Arr the name call $FriPost_Arr
$Friend_Post = array();
$Public_Post = array();
$Limit_Post  = array();
$Total_Post  = array();


// SECOND STATE GET MY FRI POST ID LIMIT 50
// If Friend exist
if ($friends) {
    // Loop $FriList_Arr & GET Fri Post user_id
    foreach ($friends as $key => $value) {
        $stmtPostUser = $pdo->prepare("SELECT p_id FROM posts WHERE user_id = ? ORDER BY p_id DESC LIMIT $friLimit");
        $result = $stmtPostUser->execute([$value]);
        $result = $stmtPostUser->fetchAll();
        // FriPost Data Push to Empty Arr the name call $Friend_Post
        if ($result) {
            foreach ($result as $key => $value) {
                array_push($Friend_Post, $value['p_id']);
            }
        }
    }
}




// THIRD STATE GET ID BY PUBLIC POST & GLOBAL POST
$stmtPublicPost = $pdo->prepare("SELECT p_id FROM posts WHERE user_id NOT IN ( '" . implode("', '", $friends) . "' ) AND category='Global' || region='$region' AND category='Public' ORDER BY p_id DESC");
// $stmtPublicPost = $pdo->prepare("SELECT p_id FROM posts WHERE user_id NOT IN ( '" . implode("', '", $friends) . "' ) AND category='Public' AND region='$region' || category='Region' ORDER BY p_id DESC");
$result = $stmtPublicPost->execute();
$result = $stmtPublicPost->fetchAll();

// echo $stmtPublicPost->rowCount();

// Public Post
if ($result) {
    foreach ($result as $key => $value) {
        array_push($Friend_Post, $value['p_id']);
    }
}

 




// LIMIT POST TO SHOW USER SCREEN
$stmtLimitPost = $pdo->prepare("SELECT p_id FROM posts WHERE p_id IN ( '" . implode("', '", $Friend_Post) . "' ) ORDER BY p_id DESC LIMIT $postLimit");
$limitPost     = $stmtLimitPost->execute();
$limitPost     = $stmtLimitPost->fetchAll();

if($limitPost){
    foreach ($limitPost as $key => $value) {
        array_push($Limit_Post, $value['p_id']);
    }
}





// JOIN users ON posts.user_id = users.id
foreach ($Limit_Post as $key => $value) {
    // Final State Get All Post Data By ID
    $stmtFinal = $pdo->prepare("SELECT * FROM posts LEFT JOIN users ON posts.user_id = users.id WHERE posts.p_id = ?");
    $finalResult = $stmtFinal->execute([$value]);
    $finalResult = $stmtFinal->fetchAll();
    if ($finalResult) {
        foreach ($finalResult as $key => $value) {
            array_push($Total_Post, $value);
        }
    }
}

