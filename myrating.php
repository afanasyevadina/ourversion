<!DOCTYPE html>
<html>
<head>
	<title>Расписание</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/jquery.form.min.js"></script>
	<script src="js/jquery-ui.js"></script>		
	<script src="js/script.js"></script>
	<script src="js/schedule.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			Load('journal/forstudent.php?kurs='+$('#courses').val()+'&sem='+$('#sems').val(), '#rating');
			$('.filter').change(function(){
				Load('journal/forstudent.php?kurs='+$('#courses').val()+'&sem='+$('#sems').val(), '#rating');
			});
		});
	</script>
</head>
<body>
	<?php require_once('layout.php'); ?>
	<div class="container">
		
		<div class="main">
			<h2>Расписание</h2>
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
			<table border="1" id="rating" class="journal">
				<thead>
					<thead>
						<th>Предмет</th>
						<th>Средний балл</th>
						<th>Экзамен</th>
					</thead>
				</thead>
			</table>
		</div>
	</div>
	<footer></footer>
</body>
</html>