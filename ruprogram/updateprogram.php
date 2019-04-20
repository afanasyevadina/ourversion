<?php
require_once('../connect.php');
require_once('../api/ruprogram.php');
$rf=new Ruprogram($pdo);
if(!empty($_POST)) {
	$parts=json_decode($_POST['parts'], true);
	$items=json_decode($_POST['items'], true);
	$rf->UpdateParts($parts);
	$rf->UpdateItems($items);
}
?>