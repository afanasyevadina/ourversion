<?php
require_once('../connect.php');
require_once('../api/ktp.php');
$ktpf=new Ktp($pdo);
$data=json_decode($_POST['data'], true);
foreach ($data as $key => $value) {
	$ktpf->Update($value);
}
?>