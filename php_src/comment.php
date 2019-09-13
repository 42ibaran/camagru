<?php

    session_start();

    if ($_SESSION['logsuccess'] === FALSE || ! $_SESSION['logsuccess']) {
        die() ;
    }
    if (! $_POST['id'] )
        die() ;

    $username = $_SESSION['username'];

    include("pdo_init.php");

    $stmt = $pdo->prepare('INSERT INTO `comments` (`id`, `comment`, `commenter`) VALUES (?, ?, ?)');
    $stmt->execute(array($_POST['id'], $_POST['msg'], $username));

    echo $username;

    $result = $pdo->query('SELECT * FROM `posts` WHERE `id` = "'.$_POST['id'].'"');
    $row = $result->fetch();
    $author = $row['author'];
    $result = $pdo->query('SELECT * FROM `passwd` WHERE `username` = "'.$author.'"');
    $row = $result->fetch();

    if ($row['notify'] == "1") {
        $message = $author." commented your photo: ".$_POST['msg'];
        mail($row['address'], "Camagru - New comment", $message);
    }

?>