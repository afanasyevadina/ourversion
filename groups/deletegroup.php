<?php
require_once('../connect.php');
require_once('../api/group.php');
$gf=new Group($pdo);
if(isset($_GET['id'])) {
	$gf->Delete($_GET['id']);
}
?>