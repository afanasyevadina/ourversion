<?php
require_once('../connect.php');
require_once('../api/subject.php');
$sf=new Subject($pdo);
if(isset($_POST['id'])) {
	$subject=$sf->About($_POST['id']);
	echo json_encode($subject);
}
?>