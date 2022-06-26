<?php
require 'config.php';
require 'dao/LeadDaoMySql.php';


$name = filter_input(INPUT_POST, 'name');
$course = filter_input(INPUT_POST, 'course');
$user = filter_input(INPUT_POST, 'user');
$phone = filter_input(INPUT_POST, 'phone');
$email = filter_input(INPUT_POST, 'email');
$canal = filter_input(INPUT_POST, 'canal');
$comments = filter_input(INPUT_POST, 'comments');


if ($name && $course && $user && $phone && $email && $canal) {
    $leadDao = new LeadDaoMySql($pdo);

    $today = date("Y-m-d H:i:s");
    $status = 1;
    $user = intval($user);

    $lead = new Lead();

    $lead->setDate($today);
    $lead->setEmail($email);
    $lead->setName($name);
    $lead->setCourse($course);
    $lead->setIdUser($user);
    $lead->setCanal($canal);
    $lead->setPhone($phone);
    $lead->setComment($comments);
    $lead->setStatus($status);


    $leadDao->insert($lead);

}
header('Location: ' . $base . '/leads.php');
exit();
