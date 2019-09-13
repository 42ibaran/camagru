<?php

session_start();

if ($_SESSION['logsuccess'] === FALSE || ! $_SESSION['logsuccess']) {
    die() ;
}

if (! $_POST['id'] )
    die() ;

$username = $_SESSION['username'];

include("pdo_init.php");

$stmt = $pdo->prepare('SELECT * FROM `likes` WHERE `id` = ? AND `liker` = ?');
$stmt->execute(array($_POST['id'], $username));

if ($stmt->fetch()) {
    $stmt = $pdo->prepare('DELETE FROM `likes` WHERE `id` = ? AND `liker` = ?');
    $stmt->execute(array($_POST['id'], $username));
    echo "-1";
}
else {
    $stmt = $pdo->prepare('INSERT INTO `likes` (`id`, `liker`) VALUES (?, ?)');
    $stmt->execute(array($_POST['id'], $username));
    echo "1";
}

?>