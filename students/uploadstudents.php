<?php
require_once('../connect.php');
require_once('../vendor/autoload.php');
require_once('../api/group.php');
$sf=new Group($pdo);
if(!empty($_FILES)) {
    $filename=$_FILES['upload']['tmp_name'];
    $list = array();
    // получаем тип файла (xls, xlsx), чтобы правильно его обработать
    $file_type = PHPExcel_IOFactory::identify( $filename );
    // создаем объект для чтения
    $objReader = PHPExcel_IOFactory::createReader( $file_type );
    $objPHPExcel = $objReader->load( $filename ); // загружаем данные файла в объект
    $list = $objPHPExcel->getActiveSheet()->toArray(); // выгружаем данные из объекта в массив
    $output=array();
    $count=0;
    
    foreach ($list as $row) {
        $filtered=array_filter($row);
        if($filtered) {
            $row=array_slice($row, 0, 3);
            $row[]=$sf->GetShortName($row[0], $row[1], $row[2]);
            $row[]=$_POST['group'];
            $output=array_merge($output,array_values($row));   
            $count++;         
        }
    }
    if($count) {
        $result=$sf->Upload($output, $count);
    }    
    if ($result) {
    	header('Location: /students.php');
    }
   }
?>