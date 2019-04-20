<?php
require_once('../connect.php');
$data=json_decode($_POST['data'], true);
$res=$pdo->prepare("UPDATE `general` SET `theory`=?, `practice`=? WHERE `general_id`=?");
foreach ($data as $key => $value) {
	$res->execute($value);
}
?>