<?php
require_once('../connect.php');
require_once('../api/schedule.php');
$sf=new Schedule($pdo, '../config.json');
$sf->DeleteCabinet($_POST['id']);
?>