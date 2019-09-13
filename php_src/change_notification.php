<?php

    session_start();

    if ($_SESSION['logsuccess'] === FALSE || ! $_SESSION['logsuccess']) {
        die() ;
    }
    if ( $_POST['en_dis'] === "")
        die() ;

    $username = $_SESSION['username'];

    include("pdo_init.php");

    echo $_POST['en_dis'];

    if ($_POST['en_dis'] === "0")
        $pdo->query('UPDATE `passwd` SET `notify` = "1" WHERE `username` = "'.$username.'"');
    else
        $pdo->query('UPDATE `passwd` SET `notify` = "0" WHERE `username` = "'.$username.'"');

?>