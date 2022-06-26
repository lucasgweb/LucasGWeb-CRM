<?php

require 'config.php';
require 'dao/LeadDaoMySql.php';

$idUser = filter_input(INPUT_POST,'idUser');
$name = filter_input(INPUT_POST, 'name');
$id = filter_input(INPUT_POST, 'id');
$course = filter_input(INPUT_POST, 'course');
$phone = filter_input(INPUT_POST, 'phone');
$email = filter_input(INPUT_POST, 'email');
$canal = filter_input(INPUT_POST, 'canal');
$comments = filter_input(INPUT_POST, 'comments');

$asesor = filter_input(INPUT_POST,'asesor');
$idLead = filter_input(INPUT_POST,'idlead');


if ($id && $name && $course && $phone && $email && $canal) {
    $leadDao = new LeadDaoMySql($pdo);



    $lead = new Lead();

    $lead->setId($id);
    $lead->setEmail($email);
    $lead->setIdUser($idUser);
    $lead->setName($name);
    $lead->setCourse($course);
    $lead->setCanal($canal);
    $lead->setPhone($phone);
    $lead->setComment($comments);


    $leadDao->update($lead);

}


if($asesor && $idLead)
{
    $leadDao = new LeadDaoMySql($pdo);


    $asesor = intval($asesor);
    $idLead = intval($idLead);

    $lead = new Lead();

    $lead->setId($idLead);
    $lead->setIdUser($asesor);

    $leadDao->editAsesor($lead);
}
header('Location: ' . $base . '/leads.php');
exit();