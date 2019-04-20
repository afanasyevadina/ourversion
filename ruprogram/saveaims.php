<?php
require_once('../connect.php');
require_once('../api/ruprogram.php');
$rf=new Ruprogram($pdo);
$data=json_decode($_POST['data'], true);
$rf->UpdateAims($data);
?>