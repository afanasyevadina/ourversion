<?php
require_once('../connect.php');
$main=$pdo->prepare("SELECT `items`.`group_id` FROM `ktps` INNER JOIN `items` ON `items`.`item_id`=`ktps`.`item_id` WHERE `ktps`.`ktp_id`=?");
$main->execute(array($_GET['id']));
$item=$main->fetch();

$res=$pdo->prepare("SELECT `ktpitem_id` FROM `ktpitems` WHERE `ktp_id`=?");
$res->execute(array($_GET['id']));
$lessons=array_column($res->fetchAll(), 'ktpitem_id');

$students=$pdo->prepare("SELECT * FROM `students` WHERE `group_id`=?");
$students->execute(array($item['group_id']));

$ready=[];
$count=0;
while ($student=$students->fetch()) {
	foreach ($lessons as $lesson) {
		$ready[]=$student['student_id'];
		$ready[]=$lesson;
		$count++;
	}
}
if($count) {
	$sql="INSERT INTO `ratings` (`student_id`, `ktpitem_id`) VALUES ".str_repeat("(?,?),", $count-1)." (?,?)";
	$insert=$pdo->prepare($sql);
	$insert->execute(array_values($ready));
}