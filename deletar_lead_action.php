<?php
require 'config.php';
require 'dao/LeadDaoMySql.php';

$id = filter_input(INPUT_GET,'id');

if ($id)
{
    $LeadDao = new LeadDaoMySql($pdo);
    $LeadDao->delete($id);

}
header('Location: '.$base.'/leads.php');
exit();

