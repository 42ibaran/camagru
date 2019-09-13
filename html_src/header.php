<html>
    <head>
        <link rel="stylesheet" type="text/css" href="/css_src/header.css">
    </head>
    <div id="header">
        <div>
            <div class='box link'><a href="/html_src/timeline.php">TIMELINE</a></div>
            <?php
                session_start();
                if ($_SESSION['logsuccess'] === TRUE) {
                    echo "<div class='box link'><a href='/html_src/main.php'>CAMERA</a></div>" . PHP_EOL;
                    echo "<div class='box link'><a href='/html_src/modify.php'>SETTINGS</a></div>" . PHP_EOL;
                    echo "<div class='box link'><a href='/php_src/logout.php'>LOG OUT</a></div>" . PHP_EOL;
                }
                else {
                    echo "<div class='box link'><a href='/index.php'>LOG IN</a></div>" . PHP_EOL;
                    echo "<div class='box link'><a href='/html_src/confirm.php'>CONFIRM</a></div>" . PHP_EOL;
                    echo "<div class='box link'><a href='/html_src/register.php'>REGISTER</a></div>" . PHP_EOL;
                }
            ?>
        </div>
    </div>
</html>