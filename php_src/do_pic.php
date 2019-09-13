<?php

session_start();

if ($_SESSION['logsuccess'] === FALSE || ! $_SESSION['logsuccess']) {
    header ( 'Location: /html_src/index.php?status=none' );
    die() ;
}

if (! $_POST['pic'] ) {
    die() ;
}

if ($_SESSION['tmp']) {
    $filename = '../private/tmp/'.$_SESSION['tmp'].'.png';
    unlink($filename);
}

if (! file_exists("../private/tmp"))
    mkdir("../private/tmp");

$trimed = substr($_POST['pic'], 22);
$data = base64_decode( $trimed );
$image = imagecreatefromstring($data);

$mask = imagecreatefrompng($_POST['mask']);
$mask = imagescale($mask, intval($_POST['size']) * imagesx($image) / 100);
$mask_x = imagesx($mask);
$mask_y = imagesy($mask);

imagecolortransparent ( $mask );
imagecopy($image, $mask, $_POST['x'] - $mask_x / 2,
    $_POST['y'] - $mask_y / 2, 0, 0, $mask_x, $mask_y);

$filename = microtime(true) * 10000;

imagepng($image, "../private/tmp/".$filename.".png");

$_SESSION['tmp'] = $filename;

echo "../private/tmp/".$filename.".png";

?>