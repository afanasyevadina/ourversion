<?php 
$title = 'Расписание';
require_once('layout.php'); ?>
<?php if($user['account_type'] == 'student') {
	require_once 'api/group.php';
	$gf = new Group($pdo);
	$group = $gf->AboutStudent($user['person_id'])['group_id'];
}
?>
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
			<div id="schedule">
			</div>
		</div>
	</div>
	<footer></footer>
	<input type="hidden" id="group" value="<?=@$group?>">
	<script type="text/javascript">
		$(document).ready(function() {
			Load('schedule/forgroup.php?kurs='+$('#courses').val()+'&sem='+$('#sems').val() + '&group='+$('#group').val(), '#schedule');
			$('.filter').change(function(){
				Load('schedule/forgroup.php?kurs='+$('#courses').val()+'&sem='+$('#sems').val() + '&group='+$('#group').val(), '#schedule');
			});
		});
	</script>
</body>
</html>