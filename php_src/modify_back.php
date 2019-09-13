<?php

    function f_email() {
        if ( ($_POST['new_email'] && 
        ! preg_match('/^[A-Za-z0-9._%+-]+@[A-z0-9.-]+\.[A-Za-z]{2,}$/', $_POST['new_email']) )) {
            echo "-1";
            die();
        }

        $username = $_SESSION['username'];
        $new_email = $_POST['new_email'];

        include("pdo_init.php");
        $stmt = $pdo->prepare('SELECT * FROM `passwd` WHERE `address` = ?');
        $stmt->execute(array($new_email));
        
        if ( $stmt->fetch() ) {
            echo "";
            die() ;
        }
        
        $stmt = $pdo->prepare('UPDATE `passwd` SET `address` = ? WHERE `username` = ?');
        $stmt->execute(array($new_email, $username));
        echo "OK";
    }

    function f_username() {

        if ( ! preg_match('/^[A-Za-z0-9._-]{3,8}$/', $_POST['new_username'])
        || $_POST['new_username'] == "noone") {
            echo "-1";
            die();
        }

        $username = $_SESSION['username'];
        $new_username = $_POST['new_username'];

        include("pdo_init.php");
        $stmt = $pdo->prepare('SELECT * FROM `passwd` WHERE `username` = ?');
        $stmt->execute(array($new_username));
        
        if ( $stmt->fetch() ) {
            echo "";
            die() ;
        }

        $stmt = $pdo->prepare('UPDATE `passwd` SET `username` = ? WHERE `username` = ?');
        $stmt->execute(array($new_username, $username));
        $stmt = $pdo->prepare('UPDATE `likes` SET `liker` = ? WHERE `liker` = ?');
        $stmt->execute(array($new_username, $username));
        $stmt = $pdo->prepare('UPDATE `comments` SET `commenter` = ? WHERE `commenter` = ?');
        $stmt->execute(array($new_username, $username));
        $stmt = $pdo->prepare('UPDATE `posts` SET `author` = ? WHERE `author` = ?');
        $stmt->execute(array($new_username, $username));

        $_SESSION['username'] = $new_username;
        echo "OK";
    }

    function f_password() {

        $username = $_SESSION['username'];
        $old_passwd = hash('whirlpool', $_POST['old_passwd']);
        $new_passwd = $_POST['new_passwd'];
        $repeat_passwd = $_POST['repeat_passwd'];

        include("pdo_init.php");
        $stmt = $pdo->prepare('SELECT * FROM `passwd` WHERE `username` = ? AND `password` = ?');
        $stmt->execute(array($username, $old_passwd));

        if ( ! $stmt->fetch() ) {
            echo "1";
            die() ;
        }
        if ($new_passwd !== $repeat_passwd) {
            echo "2";
            die() ;
        }
        if ( ! preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{8,})/', $new_passwd ) ) {
            echo "3";
            die() ;
        }

        $new_passwd = hash('whirlpool', $new_passwd);

        $stmt = $pdo->prepare('UPDATE `passwd` SET `password` = ? WHERE `username` = ?');
        $stmt->execute(array($new_passwd, $username));

        echo "OK";

    }

    session_start();

    if ($_SESSION['logsuccess'] === FALSE || ! $_SESSION['logsuccess']) {
        header ( 'Location: /index.php?status=none' );
        die() ;
    }

    if ( ! $_POST['new_username'] && ! $_POST['new_email'] 
            && ! $_POST['old_passwd'] && ! $_POST['new_passwd'] 
            && ! $_POST['repeat_passwd'])
        die() ;

    if ( $_POST['new_username'] && ! $_POST['new_email'] 
            && (! $_POST['old_passwd'] && ! $_POST['new_passwd'] 
            && ! $_POST['repeat_passwd']))
        f_username();
    else if ( ! $_POST['new_username'] && $_POST['new_email'] 
            && (! $_POST['old_passwd'] && ! $_POST['new_passwd'] 
            && ! $_POST['repeat_passwd']))
        f_email();
    else if ( ! $_POST['new_username'] && ! $_POST['new_email'] 
            && ( $_POST['old_passwd'] && $_POST['new_passwd'] 
            && $_POST['repeat_passwd']))
        f_password();

?>