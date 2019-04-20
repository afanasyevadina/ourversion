<?php
require_once('../connect.php');
require_once('../api/group.php');
$gf=new Group($pdo);
$gf->DeleteSpecialization($_GET['id']);
?>