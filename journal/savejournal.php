<?php
require_once('../connect.php');
$data=json_decode($_POST['data'], true);
foreach ($data as $item) {
	$res=$pdo->prepare("UPDATE `ratings` SET `rating_value`=? WHERE `rating_id`=?");
	$res->execute(array_values($item));
}
?>