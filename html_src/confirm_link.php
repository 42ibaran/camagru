<?php
    session_start();
    if ($_SESSION['logsuccess'] === TRUE) {
        include("../php_src/pdo_init.php");
        $stmt = $pdo->prepare('SELECT * FROM `passwd` WHERE `username` = ?');
        $stmt->execute(array($_SESSION['username']));
        if ( ! $stmt->fetch() ) {
            header('Location: /php_src/logout.php');
        }
    }
    if ($_SESSION['logsuccess'] === TRUE) {
        header ( 'Location: /html_src/timeline.php' );
        die() ;
    }
?>
<html>
    <head>
        <script src="/js_src/confirm_link.js"></script>
    </head>
    <body>
    </body>
</html>