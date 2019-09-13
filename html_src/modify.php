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
    if ($_SESSION['logsuccess'] === FALSE || ! $_SESSION['logsuccess']) {
        header ( 'Location: /index.php?status=none' );
        return ;
    }
?>
<html>
    <head>
        <title>Settings</title>
        <link rel="icon" href="/private/masks/britney.png">
        <link rel="stylesheet" type="text/css" href="/css_src/modify.css">
        <script src="/js_src/modify.js"></script>
    </head>
    <body id="content">
        <?php
            include("header.php");
        ?>
        <div id="login">
            <div id="window">
                <div class="div_form">
                    <form id="form_username">
                        <div class="field" id="div_username">
                            <label>Change username</label>
                            <input class="field" id="username" type="text" type="text" name="username" value required>
                        </div>
                        <div class="field">
                            <button class="field button" id="username_button">Change username</button>
                        </div>
                    </form>
                </div>
                <br>
                <br>
                <div class="div_form">
                    <form id="form_email">
                        <div class="field" id="div_email">
                            <label>Change email</label>
                            <input class="field" id="email" type="text" type="text" name="email" value required>
                        </div>
                        <div class="field">
                            <button class="field button" id="email_button">Change email</button>
                        </div>
                    </form>
                </div>
                <br>
                <br>
                <div class="div_form">
                    <form id="form_password">
                        <div id="div_passwords">
                            <div class="field">
                                <label>Old password</label>
                                <input class="field" id="old_password" type="password" name="old_passwd" value required>
                            </div>
                            <br>
                            <div class="field">
                                <label>New password</label>
                                <input class="field" id="new_password" type="password" name="new_passwd" value required>
                            </div>
                            <br>
                            <div id="div_reenter" class="field">
                                <label>Re-enter new password</label>
                                <input class="field" id="repete_passwd" type="password" name="repeat_passwd" value required>
                            </div>
                        </div>
                        <div class="field">
                            <button class="field button" id="password_button">Change password</button>
                        </div>
                    </form>
                </div>
                <br>
                <br>
                <div class="div_form">
                    <form id="form_delete">
                        <div class="field" id="div_delete">
                            <label>Enter password</label>
                            <input class="field" id="delete_passwd" type="password" name="delete_passwd" value required>
                        </div>
                        <div class="field">
                            <button class="field button" id="delete_button">Delete account</button>
                        </div>
                    </form>
                </div>
                <br>
                <br>
                <div class="div_form">
                    <form id="form_notify">
                        <div id="div_notify">
                            <div class="field">
                                <label>Enable notifications?</label>
                                <div id="notify_setting">
                                <?php
                                    echo "</div>";
                                    echo "<select id='notification' name='operation'>";
                                    include("/php_src/pdo_init.php");
                                    $result = $pdo->prepare('SELECT * FROM `passwd` WHERE `username` = ? LIMIT 1');
                                    $result->execute(array($_SESSION['username']));
                                    $row = $result->fetch();
                                    if ($row['notify'] == true) {
                                        echo "<option value='enable' selected='selected'>enable</option>";
                                        echo "<option value='disable'>disable</option>";
                                    }
                                    else {
                                        echo "<option value='enable'>enable</option>";
                                        echo "<option value='disable' selected='selected'>disable</option>";
                                    }
                                    echo "</select>";
                                ?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
            include("footer.php");
        ?>
    </body>
</html>