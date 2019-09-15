<?php
require_once('facecontrol.php');
$menu = [
	"index.php" => 'Главная',
	"groups.php" => 'Группы',
	"teachers.php" => 'Преподаватели',
	"students.php" => 'Студенты',
	"subjects.php" => 'Дисциплины',
	"ruprograms.php" => 'Рабочая учебная программа',
	"rup.php" => 'Рабочий учебный план',
	"ktps.php" => 'КТП',
	"up.php" => 'План УП',
	"personal.php" => 'Нагрузка преподавателя',
	"journals.php" => 'Журналы',
	"schedule.php" => 'Редактор расписания',
	"changes.php" => 'Редактор изменений',
	"settings.php" => 'Настройки',
	"student_schedule.php" => 'Мое расписание',
	"public_changes.php" => 'Изменения в расписании',
	"myrating.php" => 'Мои оценки',
	"teacher_schedule.php" => 'Мое расписание',
]
?>
<!DOCTYPE html>
<html>
<head>
	<title><?=$title?></title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/jquery.form.min.js"></script>
	<script src="js/script.js"></script>
</head>
<body>
<div class="fixed-top">
		<label for="menucheck">
			<div id="menuicon">
				<img src="img/menu.svg" alt="menu">
			</div>
		</label>
		<div>
			<div class="lang">
				<!--<a href="#">RU </a><a href="#">KZ</a>-->
			</div>
			<div class="separator"></div>
			<div class="auth">
				<a href="" class="a_name"><?=$name?><img src="img/down-arrow.svg" alt=""></a>
				<a href="login.php" class="logout"><img src="img/logout.svg" alt="">Выход</a>
			</div>
		</div>
	</div>
	<input type="checkbox" id="menucheck">
		<div class="menu">
			<?php foreach ($menu as $route => $item) {
				if(in_array('*', array_column($permissions, 'route')) || in_array($route, array_column($permissions, 'route'))) { ?>
					<div class="menuitem">
						<a href="<?=$route?>"><?=$item?></a>
					</div>
			<?php }
			} ?>
		</div>