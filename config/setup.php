<?php

    require_once('database.php');

    function f_create($pdo)
    {
        $pdo->query('CREATE TABLE IF NOT EXISTS `passwd` (`username` VARCHAR(8), `password` VARCHAR(129), `address` VARCHAR(255), `notify` BOOLEAN DEFAULT "1", PRIMARY KEY (`username`))');
        $pdo->query('CREATE TABLE IF NOT EXISTS `posts` (`id` VARCHAR(14), `author` VARCHAR(8), PRIMARY KEY (`id`))');
        $pdo->query('CREATE TABLE IF NOT EXISTS `likes` (`id` VARCHAR(14), `liker` VARCHAR(8))');
        $pdo->query('CREATE TABLE IF NOT EXISTS `comments` (`id` VARCHAR(14), `comment` TEXT, `commenter` VARCHAR(8))');
        $pdo->query('CREATE TABLE IF NOT EXISTS `waitlist` (`username` VARCHAR(8), `password` VARCHAR(129), `address` VARCHAR(255), `confirm` VARCHAR(6), PRIMARY KEY (`username`))');
    }

    function f_connect($DB_DSN, $DB_USER, $DB_PASSWORD, $DB_OPTIONS) {
        try {
            $pdo = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD, $DB_OPTIONS);
        }
        catch (PDOException $ex) {
            throw new PDOException($ex->getMessage(), (int)$ex->getCode());
        }
        return $pdo;
    }

    if ($_GET['option'] === "create") {
        $pdo = f_connect($DB_DSN_NOTEXISTS, $DB_USER, $DB_PASSWORD, $DB_OPTIONS);
        $pdo->query('CREATE DATABASE IF NOT EXISTS ' . $DB_NAME);
        $pdo = f_connect($DB_DSN_EXISTS, $DB_USER, $DB_PASSWORD, $DB_OPTIONS);
        f_create($pdo);
    }
    else if ($_GET['option'] === "recreate") {
        $pdo = f_connect($DB_DSN_EXISTS, $DB_USER, $DB_PASSWORD, $DB_OPTIONS);
        $pdo->query('DROP DATABASE IF EXISTS '. $DB_NAME);
        $pdo = f_connect($DB_DSN_NOTEXISTS, $DB_USER, $DB_PASSWORD, $DB_OPTIONS);
        $pdo->query('CREATE DATABASE IF NOT EXISTS ' . $DB_NAME);
        $pdo = f_connect($DB_DSN_EXISTS, $DB_USER, $DB_PASSWORD, $DB_OPTIONS);
        f_create($pdo);
    }
    else {
        $pdo = f_connect($DB_DSN_EXISTS, $DB_USER, $DB_PASSWORD, $DB_OPTIONS);
    }

?>