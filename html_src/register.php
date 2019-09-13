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
        return ;
    }
?>
<html>
    <head>
        <title>Register</title>
        <link rel="icon" href="/private/masks/britney.png">
        <link rel="stylesheet" type="text/css" href="/css_src/register.css">
        <script src="/js_src/register.js"></script>
    </head>
    <body id="content">
        <?php
            include("header.php");
        ?>
        <div id="login">
            <div id="window">
                <form id="form">
                    <div class="field" id="div_username">
                        <label>Chose user name</label>
                        <input class="field" id="username" type="text" type="text" name="username" value required>
                    </div>
                    <br>
                    <br>
                    <div id="div_passwords">
                        <div class="field">
                            <label>Enter password</label>
                            <input class="field" id="password" type="password" name="passwd" value required>
                        </div>
                        <br>
                        <div class="field">
                            <label>Re-enter password</label>
                            <input class="field" id="repete_passwd" type="password" name="repete_passwd" value required>
                        </div>
                        <br>
                    </div>
                    <br>
                    <div class="field" id="div_address">
                        <label>Enter email address</label>
                        <input class="field" id="email" type="text" name="email" value required>
                    </div>
                    <br>
                    <div class="field">
                        <button class="field button" id="register">Register</button>
                    </div>
                </form>
            </div>
        </div>
        <?php
            include("footer.php");
        ?>
    </body>
</html>