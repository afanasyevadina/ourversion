<?php
require_once('facecontrol.php');
require_once('api/group.php');
$gf=new Group($pdo);
$groups=$gf->GetGroups();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Рабочие учебные программы</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/jquery.form.min.js"></script>
	<script src="js/script.js"></script>
</head>
<body>
	<?php require_once('layout.php'); ?>
	<div class="container">
		<div class="main">
			<h2>Рабочие учебные программы</h2>
			<select id="groups" class="filterpr">
				<?php
				foreach($groups as $group) { ?>
					<option value="<?=$group['group_id']?>"><?=$group['group_name']?></option>
				<?php } ?>
			</select>
			<input type="text" id="search" placeholder="Поиск..." class="filterpr">
			<div id="ruprograms"></div>			
		</div>
	</div>
	<footer></footer>
	<script type="text/javascript">
		Load('ruprogram/getprograms.php?group='+$('#groups').val()+'&subject='+$('#search').val(), '#ruprograms');
		$('.filterpr').on('change input', function(){
			Load('ruprogram/getprograms.php?group='+$('#groups').val()+'&subject='+$('#search').val(), '#ruprograms');
		});		
	</script>
</body>
</html>