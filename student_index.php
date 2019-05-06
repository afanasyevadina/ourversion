<?php
require_once('facecontrol.php');
require_once('api/schedule.php');
require_once('api/journal.php');
$sf=new Schedule($pdo);
$jf=new Journal($pdo);
$subjects=$jf->StudentSubjects($user['person_id']);

$date=date('N');
$week=date('W');
$changes=$sf->LessonsToday($_REQUEST['group'], date('Y-m-d H:i:s'));
$items=$sf->MainToday(array($_REQUEST['group'], $_REQUEST['kurs'], $_REQUEST['sem'], $date));
$days=['Понедельник','Вторник','Среда','Четверг','Пятница', 'Суббота'];
$chindex=0;
$index=0;
