<?php
require_once 'config.php';
require_once 'models/Auth.php';

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$password = filter_input(INPUT_POST, 'password');

if ($email && $password) {
    $auth = new Auth($pdo, $base);
    $userLogin = $auth->validateLogin($email, $password);

    if ($userLogin) {

        header('Location: ' . $base);
        exit();
    }

}
header('Location: ' . $base . '/login.php');
exit();
