<?php
require_once('../connect.php');
require_once('../api/journal.php');
$jf=new Journal($pdo);
$data=json_decode($_POST['data'], true);
$jf->Save($data);
?>