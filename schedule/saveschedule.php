<?php
require_once('../connect.php');
require_once('../api/schedule.php');
$sf=new Schedule($pdo);
$data=json_decode($_POST['data'], true);
$sf->SaveMain($_POST['group'], $data);
?>