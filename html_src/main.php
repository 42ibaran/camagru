<?php
    session_start();
    /*if ($_SESSION['logsuccess'] === TRUE) {
        include("../php_src/pdo_init.php");
        $stmt = $pdo->prepare('SELECT * FROM `passwd` WHERE `username` = ?');
        $stmt->execute(array($_SESSION['username']));
        if ( ! $stmt->fetch() ) {
            header('Location: /php_src/logout.php');
        }
    }*/
    if ($_SESSION['logsuccess'] === FALSE || ! $_SESSION['logsuccess']) {
        header ( 'Location: /index.php?status=none' );
        return ;
    }
?>
<html>
    <head>
        <title>Create your photo</title>
        <link rel="icon" href="/private/masks/britney.png">
        <link rel="stylesheet" type="text/css" href="/css_src/main.css">
        <script src="/js_src/webcam.js"></script>
    </head>
    <body id="content">
        <?php
            include("header.php");
        ?>
        <div id="window">
            <div id="main">
                <div class="output" id="video_output">
                    <video id="video">Video unavailable</video>
                    <button id="startbutton">Take photo</button>
                    <form id="file_form" enctype="multipart/form-data">
                        <input type="file" name="files" accept="image/png">
                        <button id="upload_button">Upload file</button>
                    </form>
                </div>
                <div class="output" id="photo_output">
                    <img id="photo">
                    <button id="gotocamera">Open camera</button>
                    <br>
                    <button id="share">Share</button>
                </div>
                <canvas id="canvas"></canvas>
            </div>
            <div id="menu">
                <?php
                    foreach ( glob('../private/masks/*.png') as $filename ) {
                        echo "<div class='div_mask'><img class='mask' src='".$filename."'></div>";
                    }
                ?>
                <br>
                <input type="range" id="range" name='mask_size' min='10' max='100'>
            </div>
        </div>
        <br>
        <div id="gallery"></div>
        <br>
        <?php
            include("footer.php");
        ?>
    </body>
</html>