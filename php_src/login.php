<?php

session_start();

if (! $_POST['username'] )
    die() ;

$username = $_POST['username'];
$password = hash( "whirlpool", $_POST['passwd'] );

include("pdo_init.php");

$stmt = $pdo->prepare('SELECT * FROM `passwd` WHERE `password` = "'.$password.'" AND `username` = ? LIMIT 1');
$stmt->execute(array($username));

if ( $stmt->fetch() ) {
    $_SESSION['logsuccess'] = TRUE;
    $_SESSION['username'] = $username;
}

if ( $_SESSION['logsuccess'] === TRUE )
    header ( 'Location: /html_src/timeline.php' );
else
    header ( 'Location: /index.php?status=KO' );

?>