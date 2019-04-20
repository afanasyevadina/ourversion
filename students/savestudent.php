<?php
require_once('../connect.php');
require_once('../api/group.php');
$gf=new Group($pdo);
$gf->InsertStudent($_POST['fname'], $_POST['sname'], $_POST['tname'], $_POST['group']);
?>