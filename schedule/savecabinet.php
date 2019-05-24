<?php
require_once('../connect.php');
require_once('../api/schedule.php');
$sf=new Schedule($pdo, '../config.json');
$data=json_decode($_POST['data'], true);
foreach ($data as $item) {
	$sf->SaveCabinet($item);
}
?>