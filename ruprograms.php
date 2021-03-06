<?php
$title = 'Рабочие учебные программы';
require_once('layout.php');
require_once('api/group.php');
$gf=new Group($pdo);
$groups=$gf->GetGroups();
?>
	<div class="container">
		<div class="main">
			<h2>Рабочие учебные программы</h2>
			<select id="groups" class="filterpr">
				<?php
				foreach($groups as $group) { ?>
					<option value="<?=$group['group_id']?>"><?=$group['group_name']?></option>
				<?php } ?>
			</select>
			<input type="text" id="search" placeholder="Поиск..." class="query" autocomplete="off">
			<div id="ruprograms"></div>			
		</div>
	</div>
	<footer></footer>
	<input type="hidden" id="id" value="<?=$user['account_type'] == 'teacher' ? $user['person_id'] : ''?>">
	<script src="js/search.js"></script>
	<script type="text/javascript">
		Load('ruprogram/getprograms.php?group='+$('#groups').val()+'&subject='+$('#search').val()+'&id='+$('#id').val(), '#ruprograms');
	</script>
</body>
</html>