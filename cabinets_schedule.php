<?php
require_once('facecontrol.php');
require_once('api/schedule.php');
$sf=new Schedule($pdo, 'config.json');
$cabinets=$sf->GetCabinets();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Расписание кабинетов</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/jquery.form.min.js"></script>
	<script src="js/jquery-ui.js"></script>		
	<script src="js/script.js"></script>
	<script src="js/schedule.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			Load('schedule/forcabinet.php?kurs='+$('#courses').val()+'&sem='+$('#sems').val()+'&cabinet='+$('#cabinet').val(), '#schedule');
			$('.filter').change(function(){
				Load('schedule/forcabinet.php?kurs='+$('#courses').val()+'&sem='+$('#sems').val()+'&cabinet='+$('#cabinet').val(), '#schedule');
			});
		});
	</script>
</head>
<body>
	<?php require_once('layout.php'); ?>
	<div class="container">
		
		<div class="main">
			<h2>Расписание</h2>
			<select class="filter" id="cabinet">
				<?php foreach ($cabinets as $cabinet) { ?>
					<option value="<?=$cabinet['cabinet_id']?>"><?=$cabinet['cabinet_name']?></option>
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
</body>
</html>