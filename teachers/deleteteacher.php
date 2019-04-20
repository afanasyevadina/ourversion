<?php
require_once('../connect.php');
require_once('../api/group.php');
$tf=new Group($pdo);
if(isset($_GET['id'])) {
	$tf->DeleteTeacher($_GET['id']);
}
?>