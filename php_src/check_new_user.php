<?php

if (! $_POST['username'] )
    die() ;

$username = $_POST['username'];

$password_1 = $_POST['password_1'];
$password_2 = $_POST['password_2'];

$address = $_POST['address'];

include("pdo_init.php");

$stmt = $pdo->prepare('SELECT * FROM `passwd` WHERE `username` = ?');
$stmt->execute(array($username));

if ( $stmt->fetch() || $username === "noone") {
    echo "1";
    die() ;
}
if ( ! preg_match('/^[A-Za-z0-9._-]{3,8}$/', $username ) ) {
    echo "2";
    die() ;
}
if ($password_1 !== $password_2) {
    echo "3";
    die() ;
}
if ( ! preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/', $password_1 ) ) {
    echo "4";
    die() ;
}
if ( ! preg_match('/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-z]{2,}$/', $address) ) {
    echo "5";
    die() ;
}

$passwd = $pdo->prepare('SELECT * FROM `passwd` WHERE `address` = ?');
$passwd->execute(array($address));
$waitlist = $pdo->prepare('SELECT * FROM `waitlist` WHERE `address` = ?');
$passwd->execute(array($address));

if ( $passwd->fetch() || $waitlist->fetch() ) {
    echo "6";
    die() ;
}

?>