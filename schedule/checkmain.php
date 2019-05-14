<?php
require_once('../connect.php');
require_once('../api/schedule.php');
$sf=new Schedule($pdo, '../config.json');
$data=json_decode($_POST['data'], true);
$intersection=$sf->MatchMain($data);
if($intersection) {
	echo 'Наложение у '.$intersection['teacher_name'].', предмет '.$intersection['subject_name'].', группа '.$intersection['group_name'];
}
?>