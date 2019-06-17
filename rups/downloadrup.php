<?php
require_once('../connect.php');
require_once('../vendor/autoload.php');
$id=(isset($_GET['group']))?$_GET['group']:1;
$kurs=(isset($_GET['kurs']))?$_GET['kurs']:'2018-2019';
$items=$pdo->prepare("SELECT * FROM `items` INNER JOIN `subjects` ON `subjects`.`subject_id`=`items`.`subject_id` INNER JOIN `groups` ON `groups`.`group_id`=`items`.`group_id` LEFT JOIN `teachers` ON `teachers`.`teacher_id`=`items`.`teacher_id` WHERE `items`.`group_id`=? AND `kurs_num`=? GROUP BY `item_id`");
$items->execute(array($id, $kurs));
$res=$pdo->prepare("SELECT * FROM `groups` WHERE `group_id`=?");
$res->execute(array($id));
if($res) $group=$res->fetch();
$objPHPExcel = new PHPExcel(); 
$objPHPExcel->setActiveSheetIndex(0); 

$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'группа');
$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'преподаватели');
$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Наименование предмета');
$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Распределение по семестрам');
$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Контрольные работы');
$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'По РУП');
$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Всего часов на учебный год');
$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Снятие на ПД');
$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'из них теоретических');
$objPHPExcel->getActiveSheet()->SetCellValue('N1', 'из них ЛПР');
$objPHPExcel->getActiveSheet()->SetCellValue('O1', 'Из них курсовые работы');
$objPHPExcel->getActiveSheet()->SetCellValue('P1', '1 семестр');
$objPHPExcel->getActiveSheet()->SetCellValue('S1', '2 семестр');
$objPHPExcel->getActiveSheet()->SetCellValue('V1', 'Консультации');
$objPHPExcel->getActiveSheet()->SetCellValue('W1', 'Экзамены');
$objPHPExcel->getActiveSheet()->SetCellValue('X1', 'Всего за год');
$objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'кол-во уч-ся ХР');
$objPHPExcel->getActiveSheet()->SetCellValue('Z1', 'кол-во часов ХР');
$objPHPExcel->getActiveSheet()->SetCellValue('AA1', 'всего часов МБ');
$objPHPExcel->getActiveSheet()->SetCellValue('D2', 'экзамены');
$objPHPExcel->getActiveSheet()->SetCellValue('E2', 'зачеты');
$objPHPExcel->getActiveSheet()->SetCellValue('F2', 'Курсовые работы');
$objPHPExcel->getActiveSheet()->SetCellValue('H2', 'всего по РУП');
$objPHPExcel->getActiveSheet()->SetCellValue('I2', 'теоретические занятия');
$objPHPExcel->getActiveSheet()->SetCellValue('J2', 'лабораторно-практ. занятия');
$objPHPExcel->getActiveSheet()->SetCellValue('P2', 'Количество нед.');
$objPHPExcel->getActiveSheet()->SetCellValue('Q2', 'часов в нед.');
$objPHPExcel->getActiveSheet()->SetCellValue('R2', 'часов в семестр');
$objPHPExcel->getActiveSheet()->SetCellValue('S2', 'Количество нед.');
$objPHPExcel->getActiveSheet()->SetCellValue('T2', 'часов в нед.');
$objPHPExcel->getActiveSheet()->SetCellValue('U2', 'часов в семестр');
$objPHPExcel->getActiveSheet()->mergeCells('A1:A2');
$objPHPExcel->getActiveSheet()->mergeCells('B1:B2');
$objPHPExcel->getActiveSheet()->mergeCells('C1:C2');
$objPHPExcel->getActiveSheet()->mergeCells('D1:F1');
$objPHPExcel->getActiveSheet()->mergeCells('G1:G2');
$objPHPExcel->getActiveSheet()->mergeCells('H1:J1');
$objPHPExcel->getActiveSheet()->mergeCells('K1:K2');
$objPHPExcel->getActiveSheet()->mergeCells('L1:L2');
$objPHPExcel->getActiveSheet()->mergeCells('M1:M2');
$objPHPExcel->getActiveSheet()->mergeCells('N1:N2');
$objPHPExcel->getActiveSheet()->mergeCells('O1:O2');
$objPHPExcel->getActiveSheet()->mergeCells('P1:R1');
$objPHPExcel->getActiveSheet()->mergeCells('S1:U1');
$objPHPExcel->getActiveSheet()->mergeCells('V1:V2');
$objPHPExcel->getActiveSheet()->mergeCells('W1:W2');
$objPHPExcel->getActiveSheet()->mergeCells('X1:X2');
$objPHPExcel->getActiveSheet()->mergeCells('Y1:Y2');
$objPHPExcel->getActiveSheet()->mergeCells('Z1:Z2');
$objPHPExcel->getActiveSheet()->mergeCells('AA1:AA2');
$objPHPExcel->getActiveSheet()->getStyle('D2:F2')->getAlignment()->setTextRotation(90); 
$objPHPExcel->getActiveSheet()->getStyle('G1')->getAlignment()->setTextRotation(90); 
$objPHPExcel->getActiveSheet()->getStyle('H2:J2')->getAlignment()->setTextRotation(90);
$objPHPExcel->getActiveSheet()->getStyle('K1:O1')->getAlignment()->setTextRotation(90);
$objPHPExcel->getActiveSheet()->getStyle('P2:U2')->getAlignment()->setTextRotation(90);
$objPHPExcel->getActiveSheet()->getStyle('V1:X1')->getAlignment()->setTextRotation(90); 
$objPHPExcel->getActiveSheet()->getStyle('Y2:AA2')->getAlignment()->setWrapText(true);

$rowCount = 2; 

$group=''; $totalrup=0; $theory=0; $lpr=0; $totalkurs=0; $theoryrup=0; $lprrup=0; 
$week1=0; $hoursperweek1=0; $sem1=0;
$week2=0; $hoursperweek2=0; $sem2=0;
$totalyear=0; $hourxp=0; $res=0;
while($row = $items->fetch()){     
    $rowCount++;
    $group=$row['group_name'];
    $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $row['group_name']);
    $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $row['teacher_name']);
    $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $row['subject_name']);
    $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $row['exam']==0?'':$row['exam']);
    $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $row['zachet']==0?'':$row['zachet']);
    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $row['kursach']==0?'':$row['kursach']);
    $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $row['control']==0?'':$row['control']);
    $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $row['totalrup']==0?'':$row['totalrup']);
    $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $row['theoryrup']==0?'':$row['theoryrup']);
    $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $row['lprrup']==0?'':$row['lprrup']);
    $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $row['totalkurs']==0?'':$row['totalkurs']);
    $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $row['pd']==0?'':$row['pd']);
    $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $row['theory']==0?'':$row['theory']);
    $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $row['lpr']==0?'':$row['lpr']);
    $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $row['kurs']==0?'':$row['kurs']);
    $objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $row['week1']==0?'':$row['week1']);
    $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, (($row['week1']==0?0:
    	floor($row['sem1']/$row['week1']))==0)?'':floor($row['sem1']/$row['week1']));
    $objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $row['sem1']);
    $objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $row['week2']==0?'':$row['week2']);
    $objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, (($row['week2']==0?0:
    	floor($row['sem2']/$row['week2']))==0)?'':floor($row['sem2']/$row['week2']));
    $objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $row['sem2']);
    $objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, $row['consul']==0?'':$row['consul']);
    $objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, $row['examens']==0?'':$row['examens']);
    $objPHPExcel->getActiveSheet()->SetCellValue('X'.$rowCount, $row['totalyear']==0?'':$row['totalyear']);
    $objPHPExcel->getActiveSheet()->SetCellValue('Y'.$rowCount, $row['stdxp']==0?'':$row['stdxp']);
    $objPHPExcel->getActiveSheet()->SetCellValue('Z'.$rowCount, $row['hourxp']==0?'':$row['hourxp']);
    $objPHPExcel->getActiveSheet()->SetCellValue('AA'.$rowCount, '=X'.$rowCount.'-Z'.$rowCount);
} 
$rowCount++;
$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $group);
$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Итого');
$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, "=SUM(H3:H".($rowCount-1).")");
$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, "=SUM(I3:I".($rowCount-1).")");
$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, "=SUM(J3:J".($rowCount-1).")");
$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, "=SUM(K3:K".($rowCount-1).")");
$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, "=SUM(M3:M".($rowCount-1).")");
$objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, "=SUM(P3:P".($rowCount-1).")");
$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, "=SUM(Q3:Q".($rowCount-1).")");
$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, "=SUM(R3:R".($rowCount-1).")");
$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, "=SUM(S3:S".($rowCount-1).")");
$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, "=SUM(T3:T".($rowCount-1).")");
$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, "=SUM(U3:U".($rowCount-1).")");
$objPHPExcel->getActiveSheet()->SetCellValue('X'.$rowCount, "=SUM(X3:X".($rowCount-1).")");
$objPHPExcel->getActiveSheet()->SetCellValue('Z'.$rowCount, "=SUM(Z3:Z".($rowCount-1).")");
$objPHPExcel->getActiveSheet()->SetCellValue('AA'.$rowCount, "=SUM(AA3:AA".($rowCount-1).")");
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
$objPHPExcel->getActiveSheet()->getStyle('A1:AA'.$rowCount)->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('A1:AA2')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A'.$rowCount.':AA'.$rowCount)->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1:AA2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->getStyle('A1:AA2')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 
$file=$group.' ('.$kurs.') РУП.xls';
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
header('Location: rup.php?group='.$id);