<?php
$title = 'Журналы';
require_once('layout.php');
require_once 'api/group.php';
$gf = new Group($pdo);
?>
	<div class="container">
		<div class="main">
			<h2>Журналы</h2>
			<select class="filter" id="courses">
				<option>2019-2020</option>
				<option>2018-2019</option>
				<option>2017-2018</option>
				<option>2016-2017</option>
				<option>2015-2016</option>
			</select>
			<select class="filter" id="groups">
				<?php foreach($gf->GetGroups() as $group) { ?>
					<option value="<?=$group['group_id']?>"><?=$group['group_name']?></option>
				<?php } ?>
			</select>
			<div id="journals"></div>
		</div>
	</div>
	<input type="hidden" id="id" value="<?=$user['account_type'] == 'teacher' ? $user['person_id'] : ''?>">
	<script type="text/javascript">
		Load('journal/getjournal.php?kurs='+$('#courses').val()+'&group='+$('#groups').val()+'&id='+$('#id').val(), '#journals');
		$('.filter').change(function() {
			Load('journal/getjournal.php?kurs='+$('#courses').val()+'&group='+$('#groups').val()+'&id='+$('#id').val(), '#journals');
		});
	</script>
</body>
</html>