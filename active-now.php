<?php

include "./includes/init.php";

$sql = "UPDATE `users` SET `last_login` = '$ygntime' WHERE id = '$id'";

$stmt = $pdo->prepare($sql);
$stmt->execute();