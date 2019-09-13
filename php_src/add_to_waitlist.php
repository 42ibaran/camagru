<?php

session_start();

if ( $_SESSION['logsuccess'] === TRUE ) {
    header ( 'Location: /index.php?status=none' );
    return ;
}

if (! $_POST['username'] )
    die() ;

$username = $_POST['username'];
$password = hash('whirlpool' ,$_POST['password']);
$address = $_POST['address'];

include("pdo_init.php");

$stmt = $pdo->prepare('SELECT * FROM `waitlist` WHERE `username` = ? OR `address` = ?');
$stmt->execute(array($username, $address));

if ( $stmt->fetch() ) {
    echo "";
    return ;
}

$confirm = str_pad(mt_rand(10000, 999999), 6, "0", STR_PAD_LEFT);

$stmt = $pdo->prepare('INSERT INTO `waitlist` (`username`, `address`, `password`, `confirm`) VALUES (?, ?, ?, ?)');
$stmt->execute(array($username, $address, $password, $confirm));

$link = "http://localhost:8080/html_src/confirm_link.php?username=".$username."&code=".$confirm;
$message = "Hello. To finish registration click the link ".$link." or enter the following code on 'Confirm' page: " . $confirm;

$_SESSION['logsuccess'] = FALSE;
$_SESSION['username'] = $username;


if (mail($address, "Camagru - Registration", $message))
    echo "OK";
else
    echo "KO";

?>