<?php

session_start();

if ($_SESSION['logsuccess'] === FALSE || ! $_SESSION['logsuccess']) {
    header ( 'Location: /html_src/index.php?status=none' );
    return ;
}

if (! $_POST['file'] && ! $_POST['data'])
    die() ;

if (! file_exists("../private/posts"))
    mkdir("../private/posts");

$filename = microtime(true) * 10000;

if ($_POST['file'])
    copy($_POST['file'], "../private/posts/".$filename.".png");
else {
    $trimed = substr($_POST['data'], 22);
    $data = base64_decode($trimed);
    $image = imagecreatefromstring($data);
    imagepng($image, "../private/posts/".$filename.".png");
}

include("pdo_init.php");
$stmt = $pdo->prepare('INSERT INTO `posts` (`id`, `author`) VALUES (?, ?)');
$stmt->execute(array($filename, $_SESSION['username']));

if ($_SESSION['tmp']) {
    $filename = '../private/tmp/'.$_SESSION['tmp'].'.png';
    unlink($filename);
}

?>