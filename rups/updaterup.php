<?php
require_once('../connect.php');
require_once('../api/subject.php');
require_once('../api/item.php');
$sf=new Subject($pdo);
$it=new Item($pdo);
if(!empty($_POST)) {
	$list=json_decode($_POST['data'], true);
	$cont=$sf->GetSubjects();
	$names=array_column($cont, 'subject_name');
	$ids=array_column($cont, 'subject_id');
	foreach ($list as $row) {
        unset($row[17]);
        unset($row[20]);
        unset($row[27]);
        $row[0]=$_POST['group'];
        $sid=array_search($row[3], $names);
		$row[3]=$ids[$sid];
    	$it->Update(array_values($row));
	}
}
?>