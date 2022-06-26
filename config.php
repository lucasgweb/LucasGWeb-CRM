<?php
session_start();

date_default_timezone_set('UTC');

$base = 'http://localhost';

$db_name = 'test';
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';

$pdo = new PDO('mysql:dbname='.$db_name.';dbhost='.$db_host, $db_user, $db_pass);