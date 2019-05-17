<?php
require_once('../connect.php');
require_once('../api/group.php');
$gf=new Group($pdo);
if(isset($_REQUEST['id'])) {
	$gf->DeleteStudent($_REQUEST['id']);
}
?>