<?php
require_once('../connect.php');
require_once('../api/general.php');
$gf=new General($pdo);
if(!empty($_POST)) {
	$list=json_decode($_POST['data'], true);
	foreach ($list as $row) {
		unset($row[0]);
		unset($row[6]);
        $gf->Update(array_values($row));
	}
}
?>