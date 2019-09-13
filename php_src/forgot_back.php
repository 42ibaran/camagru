<?php

    function randomstring($length) {
        $capitals = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $lowers = "abcdefghijklmnopqrstuvwxyz";
        $specials = "!#$%&()*<>?@[]";
        $all = $capitals . $lowers . $specials . "0123456789";
        $result = "";

        $index = rand(0, strlen($capitals) - 1); 
        $result .= $capitals[$index];
        $index = rand(0, strlen($lowers) - 1); 
        $result .= $capitals[$index];
        $index = rand(0, strlen($specials) - 1); 
        $result .= $capitals[$index];
        $index = rand(0, 9); 
        $result .= "$index";

        while ($length > 4) {
            $index = rand(0, strlen($all) - 1); 
            $result .= $all[$index];
            $length--;
        }

        return str_shuffle($result);
    }

    session_start();

    if (! $_POST['email_username'] )
        die() ;

    $email_username = $_POST['email_username'];

    include("pdo_init.php");

    $stmt = $pdo->prepare('SELECT * FROM `passwd` WHERE `username` = ? OR `address` = ?');
    $stmt->execute(array($email_username, $email_username));

    if (! ($row = $stmt->fetch()) ) {
        echo "KO";
        die();
    }

    $address = $row['address'];

    $new_passwd = randomstring(16);
    $new_passwd_hash = hash('whirlpool', $new_passwd);

    $stmt = $pdo->prepare('UPDATE `passwd` SET `password` = ? WHERE `username` = ? OR `address` = ? LIMIT 1');
    $stmt->execute(array($new_passwd_hash, $email_username, $email_username));

    $message = "Your temporary password: $new_passwd";
    mail($address, "Camagru - Forgot password", $message);

    echo "OK";

?>