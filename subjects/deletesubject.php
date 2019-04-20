<?php
require_once('../connect.php');
require_once('../api/subject.php');
$sf=new Subject($pdo);
if(isset($_REQUEST['id'])) {
	$sf->Delete($_REQUEST['id']);
}
?>