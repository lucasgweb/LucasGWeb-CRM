<?php
require 'config.php';
require 'dao/UserDaoMySql.php';

$name = filter_input(INPUT_POST, 'name');
$email = filter_input(INPUT_POST, 'email');
$level = filter_input(INPUT_POST, 'selective');
$password = filter_input(INPUT_POST, 'password');


if ($name && $email && $level && $password) {

    $userDao = new UserDaoMySql($pdo);

    $user = $userDao->findByEmail($email);

    if (!$user) {

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $user = new User();
        $user->setName($name);
        $user->setEmail($email);
        $user->setLevel(intval($level));
        $user->setPassword($hash);


        $userDao->insert($user);


    }

}

header('Location: ' . $base . '/usuarios.php');
exit();