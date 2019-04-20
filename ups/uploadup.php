<?php
require_once('../connect.php');
require_once('../vendor/autoload.php');
require_once('../api/group.php');
require_once('../api/subject.php');
require_once('../api/general.php');
require_once('../api/clear.php');
$gf=new Group($pdo);
$sf=new Subject($pdo);
$genf=new General($pdo);
$clear=new Clear($pdo);
if(!empty($_FILES&&isset($_POST['group']))) {
    $filename=$_FILES['upload']['tmp_name'];
    $list = array();
    // получаем тип файла (xls, xlsx), чтобы правильно его обработать
    $file_type = PHPExcel_IOFactory::identify( $filename );
    // создаем объект для чтения
    $objReader = PHPExcel_IOFactory::createReader( $file_type );
    $objPHPExcel = $objReader->load( $filename ); // загружаем данные файла в объект
    $list = $objPHPExcel->getActiveSheet()->toArray(); // выгружаем данные из объекта в массив
    $list=array_slice($list, 7);
    $output=array();
    $count=0;
    $group=$_POST['group'];
    $base=$gf->About($group)['base'];
    $clear->ClearGeneral($group);
    $types=$sf->GetTypes();
    $names=$sf->GetSubjects();
    foreach ($list as $row) {
        $filtered=array_filter($row);
        if($filtered) {
        	$low_name=mb_strtolower($row[1]);
            if((!$row[0]&&!in_array($row[1], array_column($names, 'subject_name')))||
            	(in_array($low_name, array_column($types, 'type_name'))&&$row[0])||
            	!$row[1]) {
                continue;
            }
            $row=array_slice($row, 0, 18);
            /*if($row[6]!=$row[7]+$row[8]+$row[9]) {
                echo 'Распределение часов неверно в строке ';
                echo $count+7;
                exit;
            }
            if($row[6]!=$row[10]+$row[11]+$row[12]+$row[13]+$row[14]+$row[15]+$row[16]+$row[17]) {
                echo 'Распределение по семестрам неверно в строке ';
                echo $count+7;
                exit;
            }*/            
            if(!isset($row[0]))
            	$row[0]='';
            $res=$sf->CheckIndex($row[1], $row[0]);
            if($res===false) {
                echo 'Неизвестный предмет "'.$row[1].'" в строке ';
                echo $count+7;
                exit;
            }
            $row[1]=$res['subject_id'];
            unset($row[0]);
            unset($row[6]);
            $row[]=$group;
            $output=array_merge($output,array_values($row));   
            $count++;         
        }
    }
    $result=$genf->Upload($output, $count);
    if ($result) {
    	header('Location: /up.php');
    }
   }
?>