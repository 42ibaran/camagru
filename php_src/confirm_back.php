<?php

    function remove_from_wl($pdo, $username) {

        $stmt = $pdo->prepare('INSERT INTO `passwd` (`username`, `password`, `address`) SELECT `username`, `password`, `address` FROM `waitlist` WHERE `username` = ?');
        $stmt->execute(array($username));

        $stmt = $pdo->prepare('DELETE FROM `waitlist` WHERE `username` = ?');
        $stmt->execute(array($username));

    }

    session_start();

    if (! $_POST['username'] && ! $_SESSION['username'])
        die() ;

    $code = $_POST['code'];

    if (! $_SESSION['username'])
        $username = $_POST['username'];
    else
        $username = $_SESSION['username'];

    include("pdo_init.php");

    $stmt = $pdo->prepare('SELECT `username`, `confirm` FROM `waitlist` WHERE `username` = ? LIMIT 1');
    $stmt->execute(array($username));

    $confirm = $stmt->fetch()['confirm'];
    if ( ! $confirm )
        die();

    if ( $confirm === $code) {
        echo "OK";
        $_SESSION['logsuccess'] = TRUE;
        $_SESSION['username'] = $username;
        remove_from_wl($pdo, $username);
        return ;
    }
    else {
        echo "KO";
        return ;
    }

?>