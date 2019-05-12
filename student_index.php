<?php
require_once('facecontrol.php');
require_once('api/journal.php');
$jf=new Journal($pdo);
$subjects=$jf->StudentSubjects($user['person_id']);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Главная</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<style type="text/css">
		body {
			background-color: #ddd;
		}
		.main {
			padding: 0;
		}
	</style>
</head>
<body>
	<?php require_once('layout.php'); ?>
	<div class="container">
		<div class="main">
			<section class="section">
				<h2>Расписание на сегодня</h2>
				<div class="table_c changes">
					<table border="1" class="schedule_table">		
					</table>
				</div>
			</section>
			<section class="section">
			<h2>Средний балл по предметам</h2>
				<div class="rating_wrap">
					<?php foreach ($subjects as $key => $subject) {
						$rat=$jf->GetRating($student, $subject['item_id']); ?>
						<div class="rating_item">
							<div class="gistogram" style="height: <?=$rat['avg']*20?>%"></div>
							<div class="legend"><?=$subject['subject_name']?></div>
						</div>
					<?php } ?>
				</div>
			</section>
			<section class="section">
				<div class="overlay">
					<h1 class="section_header">Добро пожаловать,<br> <?=$name?>!</h1>
				</div>
				<img src="img/hello.jpg">
			</section>
			<section class="section">
				<h1 class="section_title">Что умеет данная АИС?</h1>
				<div class="section_container">
					<div class="section_item">
						<img src="img/plan.png">
						<h4>Загрузка и редактирование Плана УП</h4>
						<p>Загружайте Ваши планы в формате электронных таблиц или создавайте онлайн.</p>
					</div>
					<div class="section_item">
						<img src="img/get.png">
						<h4>Генерация Рабочих учебных планов</h4>
						<p>На основе планов создаются РУПы на каждый год. Вам остается только определить преподавателей и скорректировать распределние часов при необходимости.</p>
					</div>
					<div class="section_item">
						<img src="img/edit.jpg">
						<h4>Редактор РУП и КТП</h4>
						<p>Создавайте онлайн рабочие учебные программы на основе плана и генерируйте КТП в один клик!</p>
					</div>
					<div class="section_item">
						<img src="img/wordexcel.jpg">
						<h4>Скачивание готовых документов в формате Word и Excel</h4>
						<p>Учебные планы, РУП и КТП можно скачать к себе на компьютер.</p>
					</div>	
				</div>			
			</section>
				<p class="p_s">P.S. Не судите строго, этот искусственный интеллект не так умен, как ожидалось.</p>
		</div>
	</div>
	<footer></footer>
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/jquery.form.min.js"></script>
	<script src="js/jquery-ui.js"></script>	
	<script src="js/script.js"></script>
	<script src="js/schedule.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			Load('schedule/loadchanges.php?group='+$('#groups').val()+'&date='+new Date(), '.schedule_table');
		});
	</script>
</body>
</html>