<?php
$title = 'Расписание группы';
require_once('layout.php');
require_once('api/group.php');
$gf=new Group($pdo);
$groups=$gf->GetGroups();
$id = $user['account_type'] == 'student' ? $gf->AboutStudent($user['person_id'])['group_id'] : 0;
?>
	<div class="container">
		
		<div class="main">
			<h2>Расписание группы</h2>
			<select class="filter" id="group">
				<?php foreach ($groups as $group) { ?>
					<option value="<?=$group['group_id']?>" <?=$id == $group['group_id'] ? 'selected': ''?>>
						<?=$group['group_name']?>							
					</option>
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
			<div id="schedule">
			</div>
		</div>
	</div>
	<footer></footer>
	<script type="text/javascript">
		$(document).ready(function() {
			Load('schedule/forgroup.php?kurs='+$('#courses').val()+'&sem='+$('#sems').val()+'&group='+$('#group').val(), '#schedule');
			$('.filter').change(function(){
				Load('schedule/forgroup.php?kurs='+$('#courses').val()+'&sem='+$('#sems').val()+'&group='+$('#group').val(), '#schedule');
			});
		});
	</script>
</body>
</html>