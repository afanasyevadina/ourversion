<?php
require_once('../connect.php');
require_once('../api/group.php');
$tf=new Group($pdo);
if(isset($_POST['submit'])) {
	$tf->UpdateTeacher($_POST['fname'], $_POST['sname'], $_POST['tname'], $_POST['cmk'], $_POST['id']);
}
?>