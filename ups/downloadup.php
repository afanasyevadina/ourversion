<?php
require_once('../connect.php');
require_once('../vendor/autoload.php');
require_once('../api/group.php');
require_once('../api/subject.php');
require_once('../api/general.php');
$gf=new Group($pdo);
$sf=new Subject($pdo);
$genf=new General($pdo);
$id=(isset($_GET['group']))?$_GET['group'] :1;
$group=$gf->About($id);
$types=$sf->GetTypes();
$objPHPExcel = new PHPExcel(); 
$objPHPExcel->setActiveSheetIndex(0); 
$lps1=$group['lps']==1?'+ЛПС':'';
$lps2=$group['lps']==2?'+ЛПС':'';
$lps3=$group['lps']==3?'+ЛПС':'';
$lps4=$group['lps']==4?'+ЛПС':'';
$lps5=$group['lps']==5?'+ЛПС':'';
$lps6=$group['lps']==6?'+ЛПС':'';
$lps7=$group['lps']==7?'+ЛПС':'';
$lps8=$group['lps']==8?'+ЛПС':'';
$objPHPExcel->getActiveSheet()->SetCellValue('A1', '№ п/п');
$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Наименование учебных дисциплин');
$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Распределение по семестрам');
$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'К-во к/р');
$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Количество часов');
$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Распределение по курсам и семестрам');
$objPHPExcel->getActiveSheet()->SetCellValue('C2', 'экзаменов');
$objPHPExcel->getActiveSheet()->SetCellValue('D2', 'зачет');
$objPHPExcel->getActiveSheet()->SetCellValue('E2', 'курс.проект');
$objPHPExcel->getActiveSheet()->SetCellValue('G2', 'Всего');
$objPHPExcel->getActiveSheet()->SetCellValue('H2', 'Из них');
$objPHPExcel->getActiveSheet()->SetCellValue('K2', '1 курс');
$objPHPExcel->getActiveSheet()->SetCellValue('M2', '2 курс');
$objPHPExcel->getActiveSheet()->SetCellValue('O2', '3 курс');
$objPHPExcel->getActiveSheet()->SetCellValue('Q2', '4 курс');
$objPHPExcel->getActiveSheet()->SetCellValue('K3', $group['s1']==0?'':$group['s1'].$lps1);
$objPHPExcel->getActiveSheet()->SetCellValue('L3', $group['s2']==0?'':$group['s2'].$lps2);
$objPHPExcel->getActiveSheet()->SetCellValue('M3', $group['s3']==0?'':$group['s3'].$lps3);
$objPHPExcel->getActiveSheet()->SetCellValue('N3', $group['s4']==0?'':$group['s4'].$lps4);
$objPHPExcel->getActiveSheet()->SetCellValue('O3', $group['s5']==0?'':$group['s5'].$lps5);
$objPHPExcel->getActiveSheet()->SetCellValue('P3', $group['s6']==0?'':$group['s6'].$lps6);
$objPHPExcel->getActiveSheet()->SetCellValue('Q3', $group['s7']==0?'':$group['s7'].$lps7);
$objPHPExcel->getActiveSheet()->SetCellValue('R3', $group['s8']==0?'':$group['s8'].$lps8);
$objPHPExcel->getActiveSheet()->SetCellValue('H4', 'теорет.');
$objPHPExcel->getActiveSheet()->SetCellValue('I4', 'практ.');
$objPHPExcel->getActiveSheet()->SetCellValue('J4', 'курс.проект');
$objPHPExcel->getActiveSheet()->SetCellValue('K4', 'н');
$objPHPExcel->getActiveSheet()->SetCellValue('L4', 'н');
$objPHPExcel->getActiveSheet()->SetCellValue('M4', 'н');
$objPHPExcel->getActiveSheet()->SetCellValue('N4', 'н');
$objPHPExcel->getActiveSheet()->SetCellValue('O4', 'н');
$objPHPExcel->getActiveSheet()->SetCellValue('P4', 'н');
$objPHPExcel->getActiveSheet()->SetCellValue('Q4', 'н');
$objPHPExcel->getActiveSheet()->SetCellValue('R4', 'н');
$objPHPExcel->getActiveSheet()->SetCellValue('K5', '1 сем');
$objPHPExcel->getActiveSheet()->SetCellValue('L5', '2 сем');
$objPHPExcel->getActiveSheet()->SetCellValue('M5', '3 сем');
$objPHPExcel->getActiveSheet()->SetCellValue('N5', '4 сем');
$objPHPExcel->getActiveSheet()->SetCellValue('O5', '5 сем');
$objPHPExcel->getActiveSheet()->SetCellValue('P5', '6 сем');
$objPHPExcel->getActiveSheet()->SetCellValue('Q5', '7 сем');
$objPHPExcel->getActiveSheet()->SetCellValue('R5', '8 сем');
$objPHPExcel->getActiveSheet()->SetCellValue('A6', '1');
$objPHPExcel->getActiveSheet()->SetCellValue('B6', '2');
$objPHPExcel->getActiveSheet()->SetCellValue('C6', '3');
$objPHPExcel->getActiveSheet()->SetCellValue('D6', '4');
$objPHPExcel->getActiveSheet()->SetCellValue('E6', '5');
$objPHPExcel->getActiveSheet()->SetCellValue('F6', '6');
$objPHPExcel->getActiveSheet()->SetCellValue('G6', '7');
$objPHPExcel->getActiveSheet()->SetCellValue('H6', '8');
$objPHPExcel->getActiveSheet()->SetCellValue('I6', '9');
$objPHPExcel->getActiveSheet()->SetCellValue('J6', '10');
$objPHPExcel->getActiveSheet()->SetCellValue('K6', '11');
$objPHPExcel->getActiveSheet()->SetCellValue('L6', '12');
$objPHPExcel->getActiveSheet()->SetCellValue('M6', '13');
$objPHPExcel->getActiveSheet()->SetCellValue('N6', '14');
$objPHPExcel->getActiveSheet()->SetCellValue('O6', '15');
$objPHPExcel->getActiveSheet()->SetCellValue('P6', '16');
$objPHPExcel->getActiveSheet()->SetCellValue('Q6', '17');
$objPHPExcel->getActiveSheet()->SetCellValue('R6', '18');
$objPHPExcel->getActiveSheet()->mergeCells('A1:A5');
$objPHPExcel->getActiveSheet()->mergeCells('B1:B5');
$objPHPExcel->getActiveSheet()->mergeCells('C1:E1');
$objPHPExcel->getActiveSheet()->mergeCells('C2:C5');
$objPHPExcel->getActiveSheet()->mergeCells('D2:D5');
$objPHPExcel->getActiveSheet()->mergeCells('E2:E5');
$objPHPExcel->getActiveSheet()->mergeCells('F1:F5');
$objPHPExcel->getActiveSheet()->mergeCells('G1:J1');
$objPHPExcel->getActiveSheet()->mergeCells('K1:R1');
$objPHPExcel->getActiveSheet()->mergeCells('G2:G5');
$objPHPExcel->getActiveSheet()->mergeCells('H4:H5');
$objPHPExcel->getActiveSheet()->mergeCells('I4:I5');
$objPHPExcel->getActiveSheet()->mergeCells('J4:J5');
$objPHPExcel->getActiveSheet()->mergeCells('H2:J2');
$objPHPExcel->getActiveSheet()->mergeCells('K2:L2');
$objPHPExcel->getActiveSheet()->mergeCells('M2:N2');
$objPHPExcel->getActiveSheet()->mergeCells('O2:P2');
$objPHPExcel->getActiveSheet()->mergeCells('Q2:R2');
$objPHPExcel->getActiveSheet()->getStyle('C2')->getAlignment()->setTextRotation(90); 
$objPHPExcel->getActiveSheet()->getStyle('D2')->getAlignment()->setTextRotation(90); 
$objPHPExcel->getActiveSheet()->getStyle('E2')->getAlignment()->setTextRotation(90); 

$rowCount = 6; 
$theoryitogo=0; $practiceitogo=0; $projectitogo=0; $s1itogo=0; $s2itogo=0; $s3itogo=0; $s4itogo=0; $s5itogo=0; $s6itogo=0; $s7itogo=0; $s8itogo=0;
$setBold=[];
foreach($types as $type) {
    $rowCount++;
    $items=$genf->GetByType($id, $type['type_id']);
    $exam=0; $zachet=0; $kursach=0; $control=0; $theory=0; $practice=0; $project=0; $s1=0; $s2=0; $s3=0; $s4=0; $s5=0; $s6=0; $s7=0; $s8=0;
    foreach($items as $item) { 
        $exam+=$item['exams']?1:0;
        $zachet+=$item['zachet']?1:0;
        $kursach+=$item['kursach']?1:0;
        $control+=$item['control']==''?0:$item['control'];
        $theory+=$item['theory']==''?:intval($item['theory']);
        $practice+=$item['practice']==''?:intval($item['practice']);
        $project+=$item['project']==''?:intval($item['project']);
        $s1+=$item['s1']==''?:intval($item['s1']);
        $s2+=$item['s2']==''?:intval($item['s2']);
        $s3+=$item['s3']==''?:intval($item['s3']);
        $s4+=$item['s4']==''?:intval($item['s4']);
        $s5+=$item['s5']==''?:intval($item['s5']);
        $s6+=$item['s6']==''?:intval($item['s6']);
        $s7+=$item['s7']==''?:intval($item['s7']);
        $s8+=$item['s8']==''?:intval($item['s8']);
    }
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $type['short_name']);
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $type['type_name']);
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $exam==0?'':($exam.'э'));
    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $zachet==0?'':($zachet.'з'));
    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $kursach==0?'':($kursach.'к'));
    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $control);
    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, '=H'.$rowCount.'+I'.$rowCount.'+J'.$rowCount);
    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $theory);
    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $practice);
    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $project);
    $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $s1);
    $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $s2);
    $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $s3);
    $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $s4);
    $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $s5);
    $objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $s6);
    $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $s7);
    $objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $s8);
    $setBold[]=$rowCount;
    foreach($items as $row) { 
        $rowCount++;
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $type['short_name']);
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row['subject_name']);
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row['exams']==0?'':$row['exams']);
        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row['zachet']==0?'':$row['zachet']);
        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row['kursach']==0?'':$row['kursach']);
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row['control']==0?'':$row['control']);
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, '=H'.$rowCount.'+I'.$rowCount.'+J'.$rowCount);
        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row['theory']==0?'':$row['theory']);
        $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row['practice']==0?'':$row['practice']);
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row['project']==0?'':$row['project']);
        $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row['s1']==0?'':$row['s1']);
        $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row['s2']==0?'':$row['s2']);
        $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $row['s3']==0?'':$row['s3']);
        $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row['s4']==0?'':$row['s4']);
        $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $row['s5']==0?'':$row['s5']);
        $objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $row['s6']==0?'':$row['s6']);
        $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $row['s7']==0?'':$row['s7']);
        $objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $row['s8']==0?'':$row['s8']);
    } 
    $theoryitogo+=$theory;
    $practiceitogo+=$practice;
    $projectitogo+=$project;
    $s1itogo+=$s1;
    $s2itogo+=$s2;
    $s3itogo+=$s3;
    $s4itogo+=$s4;
    $s5itogo+=$s5;
    $s6itogo+=$s6;
    $s7itogo+=$s7;
    $s8itogo+=$s8;
}
$rowCount++;
$setBold[]=$rowCount;
$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Итого');
$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, '=H'.$rowCount.'+I'.$rowCount.'+J'.$rowCount);
$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $theoryitogo);
$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $practiceitogo);
$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $projectitogo);
$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $s1itogo);
$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $s2itogo);
$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $s3itogo);
$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $s4itogo);
$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $s5itogo);
$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $s6itogo);
$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $s7itogo);
$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $s8itogo);
$styleArray = array(
     'borders' => array(
      'allborders' => array(
       'style' => PHPExcel_Style_Border::BORDER_THIN 
     ) 
    ),
    'font'  => array(
        'bold'  => false,
        'color' => array('rgb' => '000'),
        'size'  => 10,
        'name'  => 'Times New Roman'
    ));
$styleItogo=array(
    'font'  => array(
        'bold'  => true,
        'color' => array('rgb' => '000'),
        'size'  => 8,
        'name'  => 'Times New Roman'
));
$objPHPExcel->getActiveSheet()->getStyle('A1:R'.$rowCount)->applyFromArray($styleArray);
foreach ($setBold as $key => $value) {
    $objPHPExcel->getActiveSheet()->getStyle('A'.$value.':R'.$value)->applyFromArray($styleItogo);
}
$objPHPExcel->getActiveSheet()->getStyle('A1:R5')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:R5')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:R5')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 
$file=$group['group_name'].' План УП.xls';
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
header('Location: up.php?group='.$id);