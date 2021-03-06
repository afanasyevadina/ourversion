<?php
$title = 'Изменения в расписании';
require_once('layout.php');
require_once('api/group.php');
$gf=new Group($pdo);
$groups=$gf->GetGroups();
?>
	<div class="modal"></div>
	<div id="teachers_list"></div>
	<div id="cabs_list"></div>
	<div class="container">
		
		<div class="main">
			<h2>Изменения в расписании</h2>
			<select class="filter" id="groups">
				<?php foreach($groups as $group) { ?>
					<option value="<?=$group['group_id']?>"><?=$group['group_name']?></option>
				<?php } ?>
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
				<div class="table_c">
					<table border="1" class="schedule_table changes">		
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
			document.getElementById("date").valueAsDate = new Date();
			Load('schedule/loadsubjects.php?group='+$('#groups').val()+'&date='+$('#date').val(), '#subjects_list');
			Load('schedule/loadchanges.php?group='+$('#groups').val()+'&date='+$('#date').val(), '.schedule_table');
			$('.filter').change(function(){
				Load('schedule/loadsubjects.php?group='+$('#groups').val()+'&date='+$('#date').val(), '#subjects_list');
				Load('schedule/loadchanges.php?group='+$('#groups').val()+'&date='+$('#date').val(), '.schedule_table');
			});
		});
	</script>
</body>
</html>