<?php
$title = 'Средний балл';
require_once('layout.php'); ?>
	<div class="container">
		
		<div class="main">
			<h2>Средний балл</h2>
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
			<table border="1">
				<thead>
					<thead>
						<th>Предмет</th>
						<th>Средний балл</th>
						<th>Экзамен</th>
					</thead>
				</thead>
				<tbody id="rating"></tbody>
			</table>
		</div>
	</div>
	<footer></footer>
	<input type="hidden" id="student" value="<?=$user['person_id']?>">
	<script type="text/javascript">
		$(document).ready(function() {
			Load('journal/forstudent.php?kurs='+$('#courses').val()+'&sem='+$('#sems').val()+'&student='+$('#student').val(), '#rating');
			$('.filter').change(function(){
				Load('journal/forstudent.php?kurs='+$('#courses').val()+'&sem='+$('#sems').val()+'&student='+$('#student').val(), '#rating');
			});
		});
	</script>
</body>
</html>