<?php
require_once('../connect.php');
require_once('../vendor/autoload.php');
require_once('../api/item.php');
require_once('../api/teacher.php');
require_once('../api/schedule.php');
$sf=new Schedule($pdo, '../config.json');
$it=new Item($pdo);
$tf=new Teacher($pdo);
$objPHPExcel = new PHPExcel(); 
$index=0;
$kurs=(isset($_GET['kurs']))?$_GET['kurs']:'2018-2019';
$cols=['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
	   'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ',
	   'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK', 'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BU', 'BV', 'BW', 'BX', 'BY', 'BZ'];
$months=[
	10 => '09',
	11 => '10',
	12 => '11',
	13 => '12',
	14 => '01',
	15 => '02',
	16 => '03',
	17 => '04',
	18 => '05',
	19 => '06',
];
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
$teachers=$tf->GetNames();
foreach($teachers as $teacher) {
	$objPHPExcel->createSheet($index);
	$objPHPExcel->setActiveSheetIndex($index);
	$index++;
	$objPHPExcel->getActiveSheet()->setTitle($teacher['teacher_name']);
	$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Министерство образования и науки РК');
	$objPHPExcel->getActiveSheet()->setCellValue('A3', 'Ведомость учета учебного времени преподавателя  КГКП "ПБК"');
	$objPHPExcel->getActiveSheet()->setCellValue('A5', 'Годовой учет часов, данных преподавателем в '.$kurs.' учебном году');
	$objPHPExcel->getActiveSheet()->setCellValue('A6', 'ФИО преподавателя: '.$teacher['teacher_name']);
	$objPHPExcel->getActiveSheet()->setCellValue('A8', 'Группы');
	$objPHPExcel->getActiveSheet()->setCellValue('A9', "Предмет/Месяцы");
	$objPHPExcel->getActiveSheet()->setCellValue('A10', 'Сентябрь');
	$objPHPExcel->getActiveSheet()->setCellValue('A11', 'Октябрь');
	$objPHPExcel->getActiveSheet()->setCellValue('A12', 'Ноябрь');
	$objPHPExcel->getActiveSheet()->setCellValue('A13', 'Декабрь');
	$objPHPExcel->getActiveSheet()->setCellValue('A14', 'Январь');
	$objPHPExcel->getActiveSheet()->setCellValue('A15', 'Февраль');
	$objPHPExcel->getActiveSheet()->setCellValue('A16', 'Март');
	$objPHPExcel->getActiveSheet()->setCellValue('A17', 'Апрель');
	$objPHPExcel->getActiveSheet()->setCellValue('A18', 'Май');
	$objPHPExcel->getActiveSheet()->setCellValue('A19', 'Июнь');
	$objPHPExcel->getActiveSheet()->setCellValue('A20', 'Консультации');
	$objPHPExcel->getActiveSheet()->setCellValue('A21', 'Экзамены');
	$objPHPExcel->getActiveSheet()->setCellValue('A22', 'Курс.проект');
	$objPHPExcel->getActiveSheet()->setCellValue('A23', 'Дипл.проект');
	$objPHPExcel->getActiveSheet()->setCellValue('A24', 'Практика');
	$objPHPExcel->getActiveSheet()->setCellValue('A25', 'Участие в ГКК');
	$objPHPExcel->getActiveSheet()->setCellValue('A26', 'Всего дано часов');
	$objPHPExcel->getActiveSheet()->setCellValue('A27', 'Всего часов по плану');
	$objPHPExcel->getActiveSheet()->setCellValue('A28', 'Не выполнено часов');
	$objPHPExcel->getActiveSheet()->setCellValue('A29', 'Дано часов сверх плана');
	$objPHPExcel->getActiveSheet()->setCellValue('A30', 'Всего часов за год');
	$objPHPExcel->getActiveSheet()->setCellValue('AJ9', 'ВСЕГО');
	for($i=10;$i<=30;$i++) {
		$objPHPExcel->getActiveSheet()->setCellValue('AJ'.$i, '=SUM(B'.$i.':AI'.$i.')');
	}
	$items=$it->GetTeacherItems($teacher['teacher_id'], $kurs);
	$lessons = $sf->TeacherLessons($teacher['teacher_id'], $kurs);
	/*echo "<pre>";
	echo $teacher['teacher_name'];
	print_r($items);
	print_r($lessons);
	echo "</pre>";
	continue;*/
	$i=0;
	foreach($items as $item) {		
		$temp=[];
		foreach($lessons as $key => $lesson) {
			if($lesson['item_id'] == $item['item_id']) {
				$temp[] = $lesson;
				unset($lessons[$key]);
			}
		}
		$pos=0;
		$i++;
		$objPHPExcel->getActiveSheet()->setCellValue($cols[$i].'8', $item['group_name']);
		$objPHPExcel->getActiveSheet()->setCellValue($cols[$i].'9', $item['subject_name']);
		for($j=10;$j<=19;$j++) {
			$hours_per_month = 0;
			while ($pos<count($temp)) {
				if(date('m', strtotime($temp[$pos]['lesson_date'])) == $months[$j]) {
					$hours_per_month += max($temp[$pos]['item_theory'], $temp[$pos]['item_practice']);
				}
				$pos++;		
			};
			$objPHPExcel->getActiveSheet()->setCellValue($cols[$i].$j, $hours_per_month);
		}
		$objPHPExcel->getActiveSheet()->setCellValue($cols[$i].'20', $item['consul']);
		$objPHPExcel->getActiveSheet()->setCellValue($cols[$i].'21', $item['examens']);
		$objPHPExcel->getActiveSheet()->setCellValue($cols[$i].'26', '=SUM('.$cols[$i].'10:'.$cols[$i].'25)');
		$objPHPExcel->getActiveSheet()->setCellValue($cols[$i].'27', $item['totalkurs']);
		$objPHPExcel->getActiveSheet()->setCellValue($cols[$i].'28', '='.$cols[$i].'27-'.$cols[$i].'26');
		$objPHPExcel->getActiveSheet()->setCellValue($cols[$i].'30', '='.$cols[$i].'26+'.$cols[$i].'29');
	}
	$objPHPExcel->getActiveSheet()->getStyle('A8:AJ30')->applyFromArray($styleArray);
	$objPHPExcel->getActiveSheet()->getStyle('B8:AI9')->getAlignment()->setTextRotation(90);
	$objPHPExcel->getActiveSheet()->mergeCells('A2:AJ2');
	$objPHPExcel->getActiveSheet()->mergeCells('A3:AJ3');
	$objPHPExcel->getActiveSheet()->mergeCells('A5:AJ5');
	$objPHPExcel->getActiveSheet()->mergeCells('A6:AJ6');
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
	$objPHPExcel->getActiveSheet()->getRowDimension('8')->setRowHeight(50);
	$objPHPExcel->getActiveSheet()->getRowDimension('9')->setRowHeight(200);
	$objPHPExcel->getActiveSheet()->getStyle('A8:AJ9')->getAlignment()->setWrapText(true);
}
$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel); 
$file='Form3.xls';
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
header('Location: personal.php');