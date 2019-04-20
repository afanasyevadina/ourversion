<?php
require_once('../vendor/autoload.php');
$data=json_decode($_POST['data'], true);
$objPHPExcel = new PHPExcel(); 
$objPHPExcel->setActiveSheetIndex(0); 
$index=0;
foreach ($data as $key => $value) {
    $index++;
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$index, $value[0]); 
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$index, $value[1]); 
} 
$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 
$file='Никому не показывайте.xls';
$objWriter->save($file);
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    // читаем файл и отправляем его пользователю
    readfile($file);
unlink($file);
header('Location: teachers.php');