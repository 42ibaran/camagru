<?php
    session_start();
    if ($_SESSION['logsuccess'] === TRUE) {
        header ( 'Location: /html_src/timeline.php' );
        return ;
    }
?>
<html>
    <head>
        <title>Welcome to Camagru</title>
        <link rel="icon" href="/private/masks/britney.png">
        <link rel="stylesheet" type="text/css" href="/css_src/index.css">
        <script src="/js_src/index.js"></script>
    </head>
    <body id="content">
        <?php
            include("html_src/header.php");
        ?>
        <div id="login">
            <div id="window">
                <form method="POST" action="/php_src/login.php">
                    <div class="field">
                        <label for="username">Login name</label>
                        <br>
                        <input class="field" id="username" type="text" type="text" name="username" value required>
                    </div>
                    <br>
                    <div class="field">
                        <label for="password">Password</label>
                        <br>
                        <input class="field" id="password" type="password" name="passwd" value required>
                        <?php
                            if ($_GET['status'] === "KO")
                                echo "<p id='error'>Wrong login and/or password</p>";
                            if ($_GET['status'] === "none")
                                echo "<p id='error'>You have to be logged in</p>";
                            if ($_GET['status'] === "deleted")
                                echo "<p id='success'>Your account has been deleted</p>";
                            if ($_GET['status'] === "password_sent")
                                echo "<p id='success'>Instruction was sent to your email</p>";
                            if ($_GET['status'] === "old_link")
                                echo "<p id='error'>Link is invalid or has been used</p>";
                        ?>
                    </div>
                    <br>
                    <div class="field">
                        <button class="field button" type="submit" value="OK">Login</button>
                    </div>
                </form>
                <div class="field">
                    <button class="field button" id="register">Register</button>
                </div>
                <br>
                <div id="forgot"><a id="forgot" href="/html_src/forgot.php">Forgot password?</a></div>

            </div>
        </div>
        <?php
            include("html_src/footer.php");
        ?>
    </body>
</html>