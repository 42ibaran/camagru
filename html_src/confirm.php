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
        <title>Confirm your email</title>
        <link rel="icon" href="/private/masks/britney.png">
        <link rel="stylesheet" type="text/css" href="/css_src/confirm.css">
        <script src="/js_src/confirm.js"></script>
    </head>
    <body id="content">
        <?php
            include("header.php");
        ?>
        <div id="login">
            <div id="window">
                <form id="form">
                    <div class="field" id="code">
                        <label>Confirmation code</label>
                        <input class="field" id="code" type="text" name="code" value required>
                    </div>
                    <br>
                    <?php
                        if (! $_SESSION['username']) {
                            echo "<div class='field' id='username'>";
                            echo "<label>Login</label>";
                            echo "<input class='field' id='input_username' type='text' name='code' value required>";
                            echo "</div>";
                            echo "<br>";
                        }
                    ?>
                    <div class="field">
                        <button class="field button" id="send">Send</button>
                    </div>
                </form>
            </div>
        </div>
        <?php
            include("footer.php");
        ?>
    </body>
</html>