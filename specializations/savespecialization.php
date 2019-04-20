<?php
require_once('../connect.php');
require_once('../api/group.php');
$gf=new Group($pdo);
$gf->InsertSpecialization($_POST['name'],$_POST['code'],$_POST['courses']);
?>