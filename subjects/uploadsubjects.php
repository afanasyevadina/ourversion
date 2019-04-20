<?php
require_once('../connect.php');
require_once('../vendor/autoload.php');
require_once('../api/subject.php');
$sf=new Subject($pdo);
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

    $types=$sf->GetTypes();

    $type_names=array_column($types, 'short_name');
    $type_ids=array_column($types, 'type_id');
    
    foreach ($list as $row) {
        $filtered=array_filter($row);
        if($filtered) {
            $short=explode(' ', $row[0]);
            if(count($short)<=1) {
                $short=explode('.', $row[0]);
            }
            $index=array_search($short[0], $type_names);
            if($index==-1&&$row[0]) {
                echo "Неизвестная ПЦК в строке".$count+1;
                exit;
            }
            $row[2]=$row[0] ? $type_ids[$index] : 0;
            $row=array_slice($row, 0, 3);
            $output=array_merge($output,array_values($row));   
            $count++;         
        }
    }
    if($count) {
        $result=$sf->Upload($output, $count);
    }    
    if ($result) {
    	header('Location: /subjects.php');
    }
   }
?>