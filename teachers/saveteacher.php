<?php
require_once('../connect.php');
require_once('../api/group.php');
$sf=new Group($pdo);
if(isset($_POST['submit'])) {
	$sf->InsertTeacher($_POST['fname'], $_POST['sname'], $_POST['tname'], $_POST['cmk']);	
}
?>