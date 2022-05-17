<?php
include_once 'src/bootstrap.php';

$database=new \PhpApi\Db\Database();

$controller= new \PhpApi\Api\GroupController($database->getConnection());
$controller->getGroupById(5);