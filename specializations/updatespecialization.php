<?php
require_once('../connect.php');
require_once('../api/group.php');
$gf=new Group($pdo);
$gf->UpdateSpecialization($_POST['name'],$_POST['code'],$_POST['courses'], $_POST['id']);
?>