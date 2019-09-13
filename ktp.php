<?php
require_once('facecontrol.php');
require_once('api/ktp.php');
require_once('api/group.php');
$ktpf=new Ktp($pdo);
$gf=new Group($pdo);
$item=$ktpf->GetKtp($_GET['id']);
$d=$gf->GetName($item);
$end1='';
$end2='';
if($item['zachet']==($kurs-1)*2+1) {
	$end1='зачет';
}
if($item['zachet']==($kurs-1)*2+2) {
	$end2='зачет';
}
if($item['exam']==($kurs-1)*2+1) {
	$end1='экзамен';
}
if($item['exam']==($kurs-1)*2+2) {
	$end2='экзамен';
}
$roman=['', 'I', 'II', 'III', 'IV'];
$topicsarr=$ktpf->GetItems($_GET['id']);
$partids=array_unique(array_column($topicsarr, 'part_id'));
$parts=[];
foreach ($topicsarr as $key => $topic) {
	$index=array_search($topic['part_id'], $partids);
	$parts[$index][]=$topic;
}
$contenteditable = $user['account_type'] == 'admin' ||
($user['account_type'] == 'teacher' && $item['teacher_id'] == $user['person_id']) ?
'contenteditable="true"' : '';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Календарно-тематический план</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/jquery.form.min.js"></script>
	<script src="js/script.js"></script>
</head>
<body>
	<?php require_once('layout.php'); ?>
	<div class="container">
		<div class="main">
			<h2>Календарно-тематический план</h2>
			<div class="links">
				<a href="#" id="saveprogram" class="save">Сохранить КТП</a>
				<a href="ktps/downloadktp.php?id=<?=$_GET['id']?>" class="download">Скачать КТП</a>
				<!--<a href="journal/generatejournal.php?id=<?=$_GET['id']?>" class="generate">Сгенерить журнал</a>-->
			</div>
			<div id="mainsuccess" class="success">
				<h3>Изменения сохранены.</h3>
			</div>
			<div id="mainerror" class="error">
				<h3>Ошибка! Изменения не сохранены.</h3>
			</div>
			<p class="shapka ktptitle">Қазақстан Республикасының Білім және ғылым министрлігі</p>
			<p class="shapka ktptitle">"Павлодар бизнес-колледжі" КМҚК</p>
			<p class="shapka ktptitle">Министерство образования и науки Республики Казахстан</p>
			<p class="shapka ktptitle">КГКП "Павлодарский бизнес-колледж"</p>

			<p class="shapka upper"><u><?=$item['subject_name']?></u><br>
				пәнінің күнтізбелік-тақырыптық жоспары<br>
				<?=$item['kurs_num']?> оқу жылының I, II семестрі</p>

			<p class="shapka upper">Календарно-тематический план по предмету<br>
				<u><?=$item['subject_name']?></u><br>
				на I, II семестр <?=$item['kurs_num']?> учебного года</p>

			<p>Оқытушы/Преподавателя <?=$item['teacher_name']?></p>

			<p>Курс, группа, специальность <u><?=$roman[$kurs]?> курс, гр. <?=$d?> <?=$item['code']?> "<?=$item['specialization_name']?>"</u></p>

			<table>
				<tr>
					<td>Пәнге бөлінген жалпы сағат саны<br>
					Общее количество часов на предмет</td>
					<td><?=$item['totalkurs']?></td>
					<td>о.і. теор.<br>в т.ч. теор.</td>
					<td><?=$item['theory']?></td>
					<td>зерт.тәж.<br>лаб.прак.</td>
					<td><?=$item['lpr']?></td>
				</tr>
				<tr>
					<td>Семестр басталғанға дейін берілді<br>
					Дано до начала семестра</td>
					<td <?=$contenteditable?>>-</td>
					<td>о.і. теор.<br>в т.ч. теор.</td>
					<td <?=$contenteditable?>>-</td>
					<td>зерт.тәж.<br>лаб.прак.</td>
					<td <?=$contenteditable?>>-</td>
				</tr>
				<tr>
					<td>Осы оқу жылына жоспарланды<br>
					Планируется на текущий уч.год</td>
					<td><?=$item['totalkurs']?></td>
					<td>о.і. теор.<br>в т.ч. теор.</td>
					<td><?=$item['theory']?></td>
					<td>зерт.тәж.<br>лаб.прак.</td>
					<td><?=$item['lpr']?></td>
				</tr>
				<tr>
					<td>1 семестрге жоспарланып отыр<br>
					Планируется на 1 семестр</td>
					<td><?=$item['sem1']?></td>
					<td>о.і. теор.<br>в т.ч. теор.</td>
					<td <?=$contenteditable?>><?=$item['theory1']?></td>
					<td>зерт.тәж.<br>лаб.прак.</td>
					<td <?=$contenteditable?>><?=$item['pract1']+$item['lab1']?></td>
				</tr>
				<tr>
					<td>2 семестрге жоспарланып отыр<br>
					Планируется на 2 семестр</td>
					<td><?=$item['sem2']?></td>
					<td>о.і. теор.<br>в т.ч. теор.</td>
					<td <?=$contenteditable?>><?=$item['theory2']?></td>
					<td>зерт.тәж.<br>лаб.прак.</td>
					<td <?=$contenteditable?>><?=$item['lab2']+$item['pract2']?></td>
				</tr>
				<tr>
					<td>I семестр аяғында<br>На конец 1 семестра</td>
					<td><?=$end1?></td>
					<td colspan="4"></td>
				</tr>
				<tr>
					<td>II семестр аяғында<br>На конец 2 семестра</td>
					<td><?=$end2?></td>
					<td colspan="4"></td>
				</tr>
			</table>
			<table border="1">
				<thead>
					<tr>
						<th rowspan="2">Сабақтың реттік №<br>
						Порядковый № урока</th>
						<th rowspan="2">Бөлімдер мен тақырыптардың аттары<br>
						Наименование разделов и тем</th>
						<th colspan="2">Сағат саны<br>Кол-во часов</th>
						<th rowspan="2">Оқудың күнтізбелік мерзімдері<br>Календарные сроки</th>
						<th rowspan="2">Оқу тұрпаты және түрі<br>Тип и вид занятия</th>
						<th rowspan="2">Пәнаралық байланыс<br>Межпредметные связи</th>
						<th rowspan="2">Көрнекі оқу мен техникалық құралдар<br>Учебные, наглядные пособия и ТСО</th>
						<th rowspan="2">Өздік жұмысының түрі<br>Вид самостоятельной работы</th>
						<th rowspan="2">Негізгі және қосымша әдебиеттер көрсетілген үй тапсырмасы<br>Дом. задание с указанием основной и дополнительной литературы</th>
					</tr>
					<tr>
						<th>теор.</th>
						<th>практ.</th>
					</tr>
				</thead>
				<tbody id="ktpitems">
					<?php foreach ($parts as $key => $part) {?>
						<tr class="partitem">
							<td colspan="10"><?=$ktpf->GetPartName($partids[$key])?></td>
						</tr>
						<?php foreach($part as $topic) { ?>
							<tr class="item" id="<?=$topic['ktpitem_id']?>">
								<td class="itemnum"><?=$topic['ktpitem_num']?></td>
								<td><?=$topic['rupitem_name']?></td>
								<td><?=$topic['item_theory']==0?'':$topic['item_theory']?></td>
								<td><?=$topic['item_practice']==0?'':$topic['item_practice']?></td>
								<td class="time-td" <?=$contenteditable?>><?=$topic['time']?></td>
								<td class="type-td" <?=$contenteditable?>><?=$topic['type']==''?(intval($topic['item_practice'])>0?'Лабораторно-практическое занятие':'Комбинированная лекция с элементами беседы'):$topic['type']?></td>
								<td class="connections-td" <?=$contenteditable?>><?=$topic['connections']?></td>
								<td class="helpers-td" <?=$contenteditable?>><?=$topic['helpers']?></td>
								<td class="worktype-td" <?=$contenteditable?>><?=$topic['worktype']?></td>
								<td class="homework-td" <?=$contenteditable?>><?=$topic['homework']?></td>
							</tr>
						<?php }
					} ?>
				</tbody>
				<tr>
					<td></td><td>Всего</td>
					<td><?=$item['totalkurs']?></td>
					<td><?=$item['lpr']==0?'':$item['lpr']?></td>
					<td></td><td></td><td></td><td></td><td></td><td></td>
				</tr>
			</table>
		</div>
	</div>
	<footer></footer>
	<input type="hidden" id="id" value="<?=$main['program_id']?>">
	<script type="text/javascript">
		$('#saveprogram').click(function(){
			var res=[];
			$('#ktpitems').find('tr.item').each(function(i){
				var temp=[];
				temp.push($(this).find('td.time-td').html());
				temp.push($(this).find('td.type-td').html());
				temp.push($(this).find('td.connections-td').html());
				temp.push($(this).find('td.helpers-td').html());
				temp.push($(this).find('td.worktype-td').html());
				temp.push($(this).find('td.homework-td').html());
				temp.push($(this).attr('id'));
				res.push(temp);
			});
			$.ajax({
				url: 'ktps/savektp.php',
				method: 'POST',
				dataType: 'html',
				data: 'data='+JSON.stringify(res),
				success: function(response) {
					console.log(response);
					$('#mainsuccess').css('display', 'block');
					setTimeout(function(){
						$('#mainsuccess').css('display', 'none');
					}, 2000);
				},
				error: function() {
					$('#mainerror').css('display', 'block');
					setTimeout(function(){
						$('#mainerror').css('display', 'none');
					}, 2000);
				}
			})
		});
	</script>
</body>
</html>