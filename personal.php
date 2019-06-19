<?php
require_once('facecontrol.php');
require_once('api/group.php');
$gf=new Group($pdo);
$teachers=$gf->GetTeachers();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Нагрузка преподавателя</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/jquery.form.min.js"></script>
	<script src="js/script.js"></script>
	<style type="text/css">
		.main {
			width: 100%;
			margin: 0;
		}
	</style>
</head>
<body>
	<?php require_once('layout.php'); ?>
	<div class="container">
		<div class="main">
			<h2>Нагрузка преподавателя</h2>
			<div class="options">
				<select id="teacherselect">
					<?php foreach($teachers as $teacher) { ?>}
					<option value="<?=$teacher['teacher_id']?>"><?=$teacher['teacher_name']?></option>
				<?php } ?>
				</select>
				<select id="tkursselect">
					<option>2019-2020</option>
					<option>2018-2019</option>
					<option>2017-2018</option>
					<option>2016-2016</option>
					<option>2015-2016</option>
				</select>
			</div>
			<div class="links">
		    	<a href="" id="downloadnagr" class="download">Скачать нагрузку</a>
		    	<a href="" id="downloadform3" class="download">Скачать Форму 3</a>
		    </div>
			<table class="rup hasitog" id="personal" border="1">
				<thead id="headgroup">
					<tr>
						<th rowspan="2">Группа</th>
						<th rowspan="2">Преподаватели</th>
						<th rowspan="2">Наименование предмета</th>
						<th colspan="3">Распределение по семестрам</th>
						<th rowspan="2"><div>Контрольные работы</div></th>
						<th colspan="3">по РУП</th>
						<th rowspan="2"><div>Всего часов на учебный год</div></th>
						<th rowspan="2"><div>Снятие на ПД</div></th>
						<th rowspan="2"><div>Из них теоретических</div></th>
						<th rowspan="2"><div>Из них ЛПР</div></th>
						<th rowspan="2"><div>Из них курсовые работы</div></th>
						<th colspan="3">1 семестр</th>
						<th colspan="3">2 семестр</th>
						<th rowspan="2"><div>Консультации</div></th>
						<th rowspan="2"><div>Экзамены</div></th>
						<th rowspan="2"><div>Всего за год</div></th>
						<th rowspan="2">кол-во уч-ся ХР</th>
						<th rowspan="2">всего часов ХР</th>
						<th rowspan="2">всего часов МБ</th>
					</tr>
					<tr>
						<th><div>экзамены</div></th>
						<th><div>зачеты</div></th>
						<th><div>курсовые работы</div></th>
						<th><div>всего по РУП</div></th>
						<th><div>теоретические занятия</div></th>
						<th><div>лабораторно-практ. занятия</div></th>
						<th><div>Количество нед.</div></th>
						<th><div>часов в нед.</div></th>
						<th><div>часов в семестр</div></th>
						<th><div>Количество нед.</div></th>
						<th><div>часов в нед.</div></th>
						<th><div>часов в семестр</div></th>
					</tr>
				</thead>
				<tbody>
		</tbody>
			</table>
		</div>
	</div>
	<footer></footer>
	<script type="text/javascript">
		$(document).ready(function() {
		$('#menucheck').attr('checked', 'checked');
			$.ajax({
			url: 'personal/getpersonal.php?teacher='+$('#teacherselect').val()+'&kurs='+$('#tkursselect').val(),
			dataType: 'html',
			success: function(response) {
				$('#personal tbody').html(response);
				$('#downloadnagr').attr('href', 'personal/downloadnagr.php?teacher='+$('#teacherselect').val()+'&kurs='+$('#tkursselect').val());
				$('#downloadform3').attr('href', 'personal/downloadform3.php?kurs='+$('#tkursselect').val());
			},
			error: function() {
				alert('error');
			}
		});
		})
	</script>
</body>
</html>