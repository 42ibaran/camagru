<?php

    session_start();

    if ($_SESSION['logsuccess'] === FALSE || ! $_SESSION['logsuccess']) {
        header ( 'Location: /index.php?status=none' );
        die() ;
    }

    if ( ! $_POST['passwd'])
        die() ;

    $username = $_SESSION['username'];
    $passwd = hash('whirlpool', $_POST['passwd']);

    include("pdo_init.php");


    $stmt = $pdo->prepare('SELECT * FROM `passwd` WHERE `username` = ? AND `password` = ?');
    $stmt->execute(array($username, $passwd));
    
    if ( ! $stmt->fetch() ) {
        echo "KO";
        die() ;
    }

    $stmt = $pdo->prepare('DELETE FROM `passwd` WHERE `username` = ?');
    $stmt->execute(array($username));
    $stmt = $pdo->prepare('DELETE FROM `likes` WHERE `liker` = ?');
    $stmt->execute(array($username));
    $stmt = $pdo->prepare('DELETE FROM `comments` WHERE `commenter` = ?');
    $stmt->execute(array($username));

    $stmt = $pdo->prepare('SELECT * FROM `posts` WHERE `author` = ?');
    $stmt->execute(array($username));
    while ($row = $stmt->fetch()) {
        unlink("../private/posts/". $row['id'] .".png");
    }

    $stmt = $pdo->prepare('DELETE FROM `posts` WHERE `author` = ?');
    $stmt->execute(array($username));

    $_SESSION['logsuccess'] = FALSE;
    $_SESSION['username'] = "";

    echo "OK";

?>