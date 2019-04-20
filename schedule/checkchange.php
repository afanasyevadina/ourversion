<?php
require_once('../connect.php');
require_once('../api/schedule.php');
require_once('../api/group.php');
$sf=new Schedule($pdo);
$gf=new Group($pdo);

//////////////////////////

$data=json_decode($_POST['data'], true);
$groups=$gf->GetIds();
foreach($groups as $group) {
	$lessons=$sf->LessonsToday($group['group_id'], $data[0]);
	$flag=false;
	foreach($lessons as $lesson) {
		$flag=true;
		if($lesson['teacher_id']==$data[3]&&$lesson['lesson_num']==$data[1]) {
			echo 'Наложение у '.$lesson['teacher_name'].', предмет '.$lesson['subject_name'].', группа '.$lesson['group_name'];
		}
	}
	if(!$flag) {
		$intersection=$sf->MatchMain(array(date('N', strtotime($data[0])), $data[1], $data[2], $data[4], $data[3]));
		if($intersection) {
			echo 'Наложение у '.$intersection['teacher_name'].', предмет '.$intersection['subject_name'].', группа '.$intersection['group_name'];
		}
	}
}
?>