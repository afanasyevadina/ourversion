<?php
require_once('../connect.php');
require_once('../api/general.php');
$gf=new General($pdo);
if(!empty($_POST)) {
	$gf->DeleteItem($_POST['id']);
}
?>