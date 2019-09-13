<?php
require_once('facecontrol.php');
require_once('api/group.php');
$gf=new Group($pdo);
$specializations=$gf->GetSpecializations();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Группы</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/jquery.form.min.js"></script>
	<script src="js/script.js"></script>
</head>
<body>
	<?php require_once('layout.php'); ?>
	<div id="fon"></div>
			<div id="add">
				<form action="groups/savegroup.php" method="post" id="groupform" class="addform small">
					<img src="img/close.png" class="cancelnew" alt="close">
					<input type="hidden" name="id" id="id">
					<div>
						<label for="name">Название: </label>
						<input type="text" name="name" id="name" autocomplete="off">
					</div>
					<div>
						<label>Специальность: </label>
					</div>
					<div>
						<select name="specialization" id="specialization" style="font-size: 0.8em;">
							<?php foreach($specializations as $specialization) { ?>
								<option title="<?=$specialization['specialization_name']?>" value="<?=$specialization['specialization_id']?>">
									<?=strlen($specialization['specialization_name'])>50? 
									mb_substr($specialization['specialization_name'], 0, 50).'...':
									$specialization['specialization_name'] ?> 
									(<?=$specialization['code']?>)</option>
							<?php } ?>
						</select>
					</div>
					<div>
						<label>База 9 </label><input type="radio" name="base" value="9" id="base9" checked="checked">
						<label style="margin-left: 30px;">База 11 </label><input type="radio" name="base" value="11" id="base11">
					</div>
					<div><label for="lang">Язык обучения</label></div>
					<div>
						<select name="lang" id="lang">
							<option value="0">Русский</option>
							<option value="1">Казахский</option>
						</select>
					</div>
					<div class="inline">
						<label for="year">Год поступления: </label><input type="number" name="year" min="2015" max="2019" id="year" value="<?=date('Y')?>">
					</div>
					<div class="inline">
						<label for="count">Количество учащихся: </label><span id="count"></span>
					</div>

					<input type="submit" name="submit" value="Сохранить">
					<a id="deletegroup" class="delete" href="">Удалить</a>
				</form>
			</div>
	<div class="container">
		
		<div class="main">
			<h2>Группы</h2>
			<div class="links">
				<a href="#" id="new">Добавить</a>
			</div>
			<table id="groups" border="1">
				<thead id="headgroup">
					<tr>
					<th>Название</th>
					<th>База</th>
					<th>Язык обучения</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
	<footer></footer>
	<script type="text/javascript">
		Load('groups/getgroups.php', '#groups tbody');
	</script>
</body>
</html>