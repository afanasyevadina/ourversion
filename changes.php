<?php
require_once('facecontrol.php');
require_once('api/group.php');
$gf=new Group($pdo);
if($user['account_type']!='dispetcher') {
	//header('Location: /');
}
$groups=$gf->GetGroups();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Изменения в расписании</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/jquery.form.min.js"></script>
	<script src="js/jquery-ui.js"></script>	
	<script src="js/script.js"></script>
	<script src="js/schedule.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			document.getElementById("date").valueAsDate = new Date();
			Load('schedule/loadsubjects.php?group='+$('#groups').val()+'&kurs='+$('#courses').val()+'&sem='+$('#sems').val(), '#subjects_list');
			Load('schedule/loadchanges.php?group='+$('#groups').val()+'&kurs='+$('#courses').val()+'&sem='+$('#sems').val()+'&date='+$('#date').val(), '.schedule_table');
			$('.filter').change(function(){
				Load('schedule/loadsubjects.php?group='+$('#groups').val()+'&kurs='+$('#courses').val()+'&sem='+$('#sems').val(), '#subjects_list');
				Load('schedule/loadchanges.php?group='+$('#groups').val()+'&kurs='+$('#courses').val()+'&sem='+$('#sems').val()+'&date='+$('#date').val(), '.schedule_table');
			});
		});
	</script>
</head>
<body>
	<?php require_once('layout.php'); ?>
	<div class="modal"></div>
	<div class="container">
		
		<div class="main">
			<h2>Изменения в расписании</h2>
			<select class="filter" id="groups">
				<?php foreach($groups as $group) { ?>
					<option value="<?=$group['group_id']?>"><?=$group['group_name']?></option>
				<?php } ?>
			</select>
			<select class="filter" id="courses">
				<option>2019-2020</option>
				<option>2018-2019</option>
				<option>2017-2018</option>
				<option>2016-2017</option>
				<option>2015-2016</option>
			</select>
			<select class="filter" id="sems">
				<option>1</option>
				<option>2</option>
			</select>
			<input type="date" id="date" class="filter">
			<div class="links">
				<a href="#" class="save" id="savechanges">Сохранить</a>
			</div>
			<div id="droppable">Убрать</div>
			<div id="success" class="success">
				<h3>Изменения сохранены.</h3>
			</div>
			<div id="error" class="error">
				<h3>Ошибка! Изменения не сохранены.</h3>
			</div>
			<div class="container sch_c">
				<ul id="subjects_list" class="draggable">
					<li>1</li>
					<li>2</li>
					<li>3</li>
					<li>4</li>
					<li>5</li>
					<li>6</li>
				</ul>
				<div class="table_c changes">
					<table border="1" class="schedule_table">		
					</table>
				</div>
			</div>
		</div>
	</div>
	<footer></footer>
</body>
</html>