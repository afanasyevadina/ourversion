<?php
require_once('../connect.php');
require_once('../api/schedule.php');
$sf=new Schedule($pdo, '../config.json');
$data=json_decode($_POST['data'], true);
$delete=json_decode($_POST['delete'], true);
foreach ($delete as $item) {
	$sf->DeleteItem($item);
}
$sf->SaveMain($_POST['group'], $data);
?>