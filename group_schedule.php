<?php
require_once('facecontrol.php');
require_once('api/group.php');
$gf=new Group($pdo);
$groups=$gf->GetGroups();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Расписание группы</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/jquery.form.min.js"></script>
	<script src="js/jquery-ui.js"></script>		
	<script src="js/script.js"></script>
	<script src="js/schedule.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			Load('schedule/forgroup.php?kurs='+$('#courses').val()+'&sem='+$('#sems').val()+'&group='+$('#group').val(), '#schedule');
			$('.filter').change(function(){
				Load('schedule/forgroup.php?kurs='+$('#courses').val()+'&sem='+$('#sems').val()+'&group='+$('#group').val(), '#schedule');
			});
		});
	</script>
</head>
<body>
	<?php require_once('layout.php'); ?>
	<div class="container">
		
		<div class="main">
			<h2>Расписание преподавателя</h2>
			<?php if($user['account_type'] == 'student') { ?>
				<input type="hidden" id="group" value="<?=$gf->AboutStudent($user['person_id'])['group_id']?>">				
			<?php } else { ?>
				<select class="filter" id="group">
					<?php foreach ($groups as $group) { ?>
						<option value="<?=$group['group_id']?>"><?=$group['group_name']?></option>
					<?php } ?>
				</select>
			<?php } ?>
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
</body>
</html>