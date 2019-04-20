<?php
require_once('../connect.php');
require_once('vendor/autoload.php');
if(!empty($_FILES&&isset($_POST['kurs']))) {
    require_once('vendor/autoload.php');
    $filename=$_FILES['upload']['tmp_name'];
    $list = array();
    // получаем тип файла (xls, xlsx), чтобы правильно его обработать
    $file_type = PHPExcel_IOFactory::identify( $filename );
    // создаем объект для чтения
    $objReader = PHPExcel_IOFactory::createReader( $file_type );
    $objPHPExcel = $objReader->load( $filename ); // загружаем данные файла в объект
    $list = $objPHPExcel->getActiveSheet()->toArray(); // выгружаем данные из объекта в массив
    array_shift($list);
    array_shift($list);
    $output=array();
    $count=0;
    $groupres=$pdo->prepare("SELECT `group_id` FROM `groups` WHERE `group_name` LIKE ?");
    $groupres->execute(array('%'.$list[0][0].'%'));
    $group=$groupres->fetch()['group_id'];
    foreach ($list as $row) {
        $filtered=array_filter($row);
        if($filtered) {
            $row=array_slice($row, 0, 27);
            unset($row[11]);
            unset($row[17]);
            unset($row[20]);
            unset($row[26]);
            $row[0]=$group;
        	$subjectres=$pdo->prepare("SELECT `subject_id` FROM `subjects` WHERE `subject_name`=?");
		    $subjectres->execute(array($row[2]));
		    $subject=$subjectres->fetch()['subject_id'];
		    $row[2]=$subject;
		    $teacherres=$pdo->prepare("SELECT `teacher_id` FROM `teachers` WHERE `teacher_name`=?");
		    $teacherres->execute(array($row[1]));
		    $teacher=$teacherres->fetch()['teacher_id'];
		    $row[1]=$teacher;
		    $row[]=$_POST['kurs'];
            $output=array_merge($output,array_values($row));   
            $count++;         
        }
    }
    $sql='INSERT INTO `items` (`group_id`, `teacher_id`, `subject_id`, `exam`, `zachet`, `kursach`, `control`,`totalrup`, `theory`, `lpr`, `totalkurs`,`theorypd`, `lprpd`, `kurspd`, `week1`, `hoursperweek1`, `week2`, `hoursperweek2`, `consul`, `examens`, `totalyear`, `stdxp`, `hourxp`, `kurs_num`) VALUES '.str_repeat('(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?), ', $count-1).'(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
    $result=$pdo->prepare($sql);
    $result->execute($output);
    if ($result) {
    	header('Location: rup.php');
    }
   }
?>