<?php

    session_start();

    $array = array();

    include("../php_src/pdo_init.php");

    $stmt = $pdo->query('SELECT * FROM `posts` ORDER BY `id` DESC');
    $i = 0;
    while (($row = $stmt->fetch()) && $i < $_POST['number_of_posts'] ) {
        $i++;
    }
    if (! $row) {
        echo json_encode($array);
        die();
    }

    $i = 0;
    while ($i < 5 && $row) {
        $array[$i]['id'] = $row['id'];
        $array[$i]['author'] = $row['author'];

        $likes_query = $pdo->query('SELECT * FROM `likes` WHERE `id` = "'. $row['id'] .'"');
        $likes = 0;
        while ($row_likes = $likes_query->fetch() ) {
            $likes++;
        }

        $array[$i]['likes'] = $likes;
        $array[$i]['comments'] = array();

        $comments_query = $pdo->query('SELECT * FROM `comments` WHERE `id` = "'. $row['id'] .'"');
        while ($row_comments = $comments_query->fetch() ) {
            $array[$i]['comments'][] = array($row_comments['commenter'] => $row_comments['comment']);
        }

        if ($_SESSION['logsuccess'] === TRUE
                && $row['author'] === $_SESSION['username'])
            $array[$i]['delete_right'] = true;
        else
            $array[$i]['delete_right'] = false;
        $i++;
        $row = $stmt->fetch();
    }

    echo json_encode($array);

?>