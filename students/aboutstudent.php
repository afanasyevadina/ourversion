<?php
require_once('../connect.php');
require_once('../api/group.php');
$gf=new Group($pdo);
$student=$gf->AboutStudent($_POST['id']);
echo json_encode($student);
?>
