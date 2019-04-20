<?php
require_once('../connect.php');
$date=date('Y-m-d');
$day_of_week=date('N');
$res=$pdo->prepare("SELECT `day_of_week`, `num_of_lesson`, `item_id`, `group_id` FROM `schedule_items` WHERE `day_of_week`=?");
$res->execute(array($day_of_week));
while ($lsn=$res->fetch()) {
	$lesnres=$pdo->prepare("SELECT COUNT(*) FROM `lessons` WHERE `group_id`=? AND `lesson_date`=? AND `lesson_num`=?");
	$lesnres->execute(array($lsn['group_id'], $date, $lsn['num_of_lesson']));
	if(!$lesnres->fetchColumn()) {
		$ins=$pdo->prepare("UPDATE `lessons` SET `lesson_date`=?, `lesson_num`=? WHERE `group_id`=? AND `item_id`=?");
		$ins->execute(array($date, $lsn['num_of_lesson'], $lsn['group_id'], $lsn['item_id']));
	}
}
//переделать по-другому завтра
//you are idiot
$groups=$pdo->query("SELECT `group_id` FROM `groups");
while ($group=$groups->fetch()) {
	$lesnres=$pdo->prepare("SELECT COUNT(*) FROM `lessons` WHERE `group_id`=? AND `lesson_date`=?");
	$lesnres->execute(array($group['group_id'], $date));
	if(!$lesnres->fetchColumn()) {
		$sh=$pdo->prepare("SELECT * FROM `schedule_items` WHERE `day_of_week`=? AND `group_id`=?");
		$sh->execute(array($day_of_week, $group['group_id']));
		while ($s=$sh->fetch()) {
			$ins=$pdo->prepare("UPDATE `lessons` SET `lesson_date`=?, `lesson_num`=?, `was`=1 WHERE `group_id`=? AND `item_id`=? AND `was`=0 LIMIT 1");
			$ins->execute(array($date, $s['num_of_lesson'], $s['group_id'], $s['item_id']));
		}		
	}
}