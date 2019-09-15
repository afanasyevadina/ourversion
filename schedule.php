<?php
$title = 'Расписание';
require_once('layout.php');
require_once('api/group.php');
$gf=new Group($pdo);
$groups=$gf->GetGroups();
?>
	<div class="modal"></div>
	<div id="cabs_list"></div>
	<div class="container">		
		<div class="main">
			<h2>Расписание</h2>
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
			<div class="links">
			    <a href="teacher_schedule.php" class="generate">Расписание преподавателя</a>
			    <a href="cabinets_schedule.php" class="generate">Расписание кабинетов</a>
			    <a href="group_schedule.php" class="generate">Расписание групп</a>
				<a href="#" class="save" id="saverasp">Сохранить</a>
				<a href="#" class="clear" id="clearrasp">Очистить расписание</a>
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
				</ul>
				<div class="table_c">
					<table border="1" class="schedule_table">		
					</table>
				</div>
			</div>
		</div>
	</div>
	<footer></footer>
	<script src="js/jquery-ui.js"></script>
	<script src="js/schedule.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			Load('schedule/list.php?group='+$('#groups').val()+'&kurs='+$('#courses').val()+'&sem='+$('#sems').val(), '#subjects_list');
			Load('schedule/loadmain.php?group='+$('#groups').val()+'&kurs='+$('#courses').val()+'&sem='+$('#sems').val(), '.schedule_table');
			$('.filter').change(function(){
				Load('schedule/list.php?group='+$('#groups').val()+'&kurs='+$('#courses').val()+'&sem='+$('#sems').val(), '#subjects_list');
				Load('schedule/loadmain.php?group='+$('#groups').val()+'&kurs='+$('#courses').val()+'&sem='+$('#sems').val(), '.schedule_table');
			});
		});
	</script>
</body>
</html>