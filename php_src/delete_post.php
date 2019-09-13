<?php

session_start();

if ($_SESSION['logsuccess'] === FALSE || ! $_SESSION['logsuccess']) {
    die() ;
}

if (! $_POST['delete_id'] )
    die() ;

include("pdo_init.php");

$stmt = $pdo->prepare('DELETE FROM `posts` WHERE `id` = ?');
$stmt->execute(array($_POST['delete_id']));
$stmt = $pdo->prepare('DELETE FROM `likes` WHERE `id` = ?');
$stmt->execute(array($_POST['delete_id']));
$stmt = $pdo->prepare('DELETE FROM `comments` WHERE `id` = ?');
$stmt->execute(array($_POST['delete_id']));

unlink("../private/posts/". $_POST['delete_id'] .".png");

?>