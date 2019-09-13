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
?>
<html>
    <head>
        <title>Timeline</title>
        <link rel="icon" href="/private/masks/britney.png">
        <link rel="stylesheet" type="text/css" href="/css_src/timeline.css">
        <script type="text/javascript" src="/js_src/timeline.js"></script>
    </head>
    <body id="content">
        <?php
            include("header.php");
        ?>
        <div id="timeline">
        </div>
        <div id="number_of_pages"></div>
        <?php
            include("footer.php");
        ?>
    </body>
</html>