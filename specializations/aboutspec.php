<?php
require_once('../connect.php');
require_once('../api/group.php');
$gf=new Group($pdo);
$spec=$gf->AboutSpecialization($_POST['id']);
echo json_encode($spec);
?>