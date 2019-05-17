<?php
require_once('../connect.php');
require_once('../api/group.php');
$gf=new Group($pdo);
if(isset($_POST['submit'])) {
	$gf->UpdateStudent($_POST['fname'], $_POST['sname'], $_POST['tname'], $_POST['group'], $_POST['subgroup'], $_POST['id']);
}
?>