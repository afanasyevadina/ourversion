<?php
require_once('../connect.php');
require_once('../api/group.php');
$tf=new Group($pdo);
if(isset($_POST['id'])) {
	$teacher=$tf->AboutTeacher($_POST['id']);
	echo json_encode($teacher);
}
?>