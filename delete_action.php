<?php
require 'config.php';
require 'dao/UserDaoMySql.php';

$id = filter_input(INPUT_GET,'id');

if ($id)
{
    $userDao = new UserDaoMySql($pdo);
    $userDao->delete($id);

}
header('Location: '.$base.'/usuarios.php');
exit();
