<?php

$DB_HOST = 'localhost';
$DB_NAME   = 'camagru';
$DB_USER = 'root';
$DB_PASSWORD = 'helloworld';
$DB_CHARSET = 'utf8';
$DB_DSN_EXISTS = "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=$DB_CHARSET";
$DB_DSN_NOTEXISTS = "mysql:host=$DB_HOST;charset=$DB_CHARSET";
$DB_OPTIONS = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
];

?>