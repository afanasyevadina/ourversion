<?php
require_once('../connect.php');
require_once('../api/ktp.php');
require_once('../api/clear.php');
require_once('../api/item.php');
require_once('../api/group.php');
$ktpf=new Ktp($pdo);
$it=new Item($pdo);
$gf=new Group($pdo);
$clear=new Clear($pdo);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
//если были данные, надо удалить
$items=$clear->ClearProgram($_GET['id']);

$kurs_nums=array_column($items, 'kurs_num');
$total_hours=array_column($items, 'totalkurs');
$t_ids=array_column($items, 'teacher_id');

//подготавливаем счетчик и массив для вставки
$count=0;
$offset=0;
$group='';
$ready=[];
$tids=[];
$help=[];

//все пункты рупа
$topics=$ktpf->GetTopics($_GET['id']);

//погнали по годам
foreach($items as $item) {
	if($item['totalkurs']==0) {
		continue;
	}
	//счетчик часов
	$hours=0;
	$max=$item['totalkurs'];
	foreach ($kurs_nums as $key => $value) {

		if($value==$item['kurs_num']) {

			if($total_hours[$key]>=$item['totalkurs']) {
				$max=$total_hours[$key];
			}
		}
	}
	if($help[$item['kurs_num']]==$item['teacher_id']&&$max>=$item['totalkurs']) {
		continue;
	}
	//создаем ктп
	$ktpid=$ktpf->Insert($_GET['id'], $item['item_id']);

	//погнали по темам, пока не вычитаем часы
	$num=0;
	$offset=isset($tids[$item['teacher_id']]) ? $tids[$item['teacher_id']] : 0;
	foreach (array_slice($topics, $offset) as $key => $topic) {		
		if($hours==intval($max)) {
			break;
		}

		if((intval($item['theory'])>0)||intval($topic['item_practice'])>0) {
			
			$num++;
			$ready=array_merge($ready, array($ktpid, $num, $topic['rupitem_id'], $_GET['id']));
			$hours+=intval($topic['item_practice']);
			$hours+=intval($topic['item_theory']);
			$count++;
		}
		
		$offset++;

		if($hours>intval($max)) {
			echo "Ошибка в плане! ".$item['totalkurs'].' '.$hours;
			exit;
		}
	}
	
	$tids[$item['teacher_id']]=$offset;
	$help[$item['kurs_num']]=$item['teacher_id'];
	$group=$item['group_id'];
}
//если набралось, вставляем
if($count) {
	$ktpf->InsertItems($ready, $count);

	$ktps=$ktpf->GetGeneralItems($general_id);
	$students=$gf->GetStudentIds($group);
	$count=count($students);

	$teachers=array_column($ktps, 'teacher_id');
	$courses=array_column($ktps, 'kurs_num');

	$thesame=false;
	$lessons=[];
	$lc=0;

	foreach ($ktps as $key => $ktp) {
		foreach ($courses as $k => $course) {
			if($ktp['kurs_num']==$course) {
				if($teachers[$k]==$ktp['teacher_id']) {
					$thesame=true;
				}
			}
		}
		$items=$ktpf->GetItems($ktp['ktp_id']);
		foreach($items as $item) {
			$lessons=array_merge($lessons, array($ktp['item_id'], $item['rupitem_id'], $ktp['group_id']));
			$lc++;
		}
		if($ktp['theory']==0&&$ktp['divide']==1&&$count>24&&$thesame) {
			//additional lessons
			$lessons=array_merge($lessons, array($ktp['item_id'], $item['rupitem_id'], $ktp['group_id']));
			$lc++;
		}
	}
	if($lc) {
		$ktpf->CreateLessons($lessons, $lc, $general_id);
	}
	
	//все вставилось, расходимся
	header('Location: /ktps.php');
}
?>