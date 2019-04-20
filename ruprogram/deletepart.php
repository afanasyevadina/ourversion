<?php
require_once('../connect.php');
require_once('../api/ruprogram.php');
$rf=new Ruprogram($pdo);
if(!empty($_POST)) {
	$rf->DeletePart($_POST['id']);
}
?>