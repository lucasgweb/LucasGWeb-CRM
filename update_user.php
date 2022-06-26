<?php
require 'config.php';
require 'dao/UserDaoMySql.php';


$id = filter_input(INPUT_POST,'id');
$estado = filter_input(INPUT_POST,'selective');


if ($id && $estado)
{
    $id = intval($id);


    $userDao = new UserDaoMySql($pdo);

    $user = $userDao->findById($id);

    if ($user)
    {
        $user->setEstado(intval($estado));
        $userDao->update($user);
    }
}
header('Location: '.$base.'/usuarios.php');
exit();
