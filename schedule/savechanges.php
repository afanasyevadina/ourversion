<?php
require_once('../connect.php');
require_once('../api/schedule.php');
$sf=new Schedule($pdo);
$data=json_decode($_POST['data'], true);
$sf->SaveChanges($_POST['group'], $_POST['date'], $data);
?>