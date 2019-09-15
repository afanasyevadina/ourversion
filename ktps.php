<?php
$title = 'Календарно-тематические планы';
require_once('layout.php');
require_once('api/group.php');
$gf=new Group($pdo);
$groups=$gf->GetGroups();
?>
	<div class="container">
		<div class="main">
			<h2>Календарно-тематические планы</h2>
			<select id="groups" class="filterpr">
				<?php
				foreach($groups as $group) { ?>
					<option value="<?=$group['group_id']?>"><?=$group['group_name']?></option>
				<?php } ?>
			</select>
			<input type="text" id="search" placeholder="Поиск..." class="filterpr">
			<div id="ktps"></div>
		</div>
	</div>
	<footer></footer>
	<script type="text/javascript">
		Load('ktps/getktps.php?group='+$('#groups').val()+'&subject='+$('#search').val(), '#ktps');
		$('.filterpr').on('change input', function(){
			Load('ktps/getktps.php?group='+$('#groups').val()+'&subject='+$('#search').val(), '#ktps');
		});		
	</script>
</body>
</html>