<?php
require_once('../connect.php');
require_once('../api/group.php');
$gf=new Group($pdo);
if(isset($_POST['id'])) {
	$group=$gf->About($_POST['id']);
	$count=$gf->StudentsCount($_POST['id']);
	$group['count']=$count;
	echo json_encode($group);
}
?>