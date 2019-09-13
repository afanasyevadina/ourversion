<?php
require_once('../connect.php');
require_once('../api/schedule.php');
$sf=new Schedule($pdo, '../config.json');
$data=json_decode(file_get_contents('php://input'), true);
$sf->Clear($data);
?>