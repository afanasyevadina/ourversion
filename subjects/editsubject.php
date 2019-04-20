<?php
require_once('../connect.php');
require_once('../api/subject.php');
$sf=new Subject($pdo);
if(isset($_POST['submit'])) {
	$div=isset($_POST['divide'])?$_POST['divide']:0;
	$sf->Update($_POST['name'], $_POST['index'], $_POST['pck'], $div, $_POST['id']);
}
?>