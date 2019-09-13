<?php

session_start();

if ($_SESSION['logsuccess'] === FALSE || ! $_SESSION['logsuccess']) {
    header ( 'Location: /index.php?status=none' );
    die() ;
}

$_SESSION['logsuccess'] = FALSE;
$_SESSION['username'] = "";

if ($_SESSION['tmp']) {
    $filename = '../private/tmp/'.$_SESSION['tmp'].'.png';
    unlink($filename);
}
$_SESSION['tmp'] = "";

header ( 'Location: /html_src/timeline.php' );

?>