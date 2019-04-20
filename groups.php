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
						<input type="text" name="name" value="ИС-326" id="name" autocomplete="off">
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
					<div class="inline">
						<label for="year">Год поступления: </label><input type="number" name="year" min="2015" max="2019" id="year" value="2019">
					</div>
					<div class="inline">
						<label for="count">Количество учащихся: </label><span id="count"></span>
					</div>
					<div>Количество недель: </div>
					<div>						
						<label for="s1">1 семестр</label>
						<input type="number" name="s1" min="0" value="19" id="s1">
						<label for="lps1">ЛПС</label>
						<input type="radio" name="lps" value="1" id="lps1">
					</div>

					<div>
						<label for="s2">2 семестр</label>
						<input type="number" name="s2" min="0" value="18" id="s2">
						<label for="lps2">ЛПС</label>
						<input type="radio" name="lps" value="2" id="lps2" checked="checked">
					</div>			

					<div>
						<label for="s3">3 семестр</label>
						<input type="number" name="s3" min="0" value="18" id="s3">
						<label for="lps3">ЛПС</label>
						<input type="radio" name="lps" value="3" id="lps3">
					</div>

					<div>
						<label for="s4">4 семестр</label>
						<input type="number" name="s4" min="0" value="11" id="s4">
						<label for="lps4">ЛПС</label>
						<input type="radio" name="lps" value="4" id="lps4">
					</div>

					<div>
						<label for="s5">5 семестр</label>
						<input type="number" name="s5" min="0" value="18" id="s5">
						<label for="lps5">ЛПС</label>
						<input type="radio" name="lps" value="5" id="lps5">
					</div>				

					<div>
						<label for="s6">6 семестр</label>
						<input type="number" name="s6" min="0" value="9" id="s6">
						<label for="lps6">ЛПС</label>
						<input type="radio" name="lps" value="6" id="lps6">
					</div>

					<div>
						<label for="s7">7 семестр</label>
						<input type="number" name="s7" min="0" value="10" id="s7">
						<label for="lps7">ЛПС</label>
						<input type="radio" name="lps" value="7" id="lps7">
					</div>

					<div>
						<label for="s8">8 семестр</label>
						<input type="number" name="s8" min="0" value="0" id="s8">
						<label for="lps8">ЛПС</label>
						<input type="radio" name="lps" value="8" id="lps8">
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
					<th rowspan="2">Название</th>
					<th rowspan="2">База</th>
					<th colspan="9" class="header-center">Семестр</th>
				</tr>
				<tr>
					<th>1</th>
					<th>2</th>
					<th>3</th>
					<th>4</th>
					<th>5</th>
					<th>6</th>
					<th>7</th>
					<th>8</th>
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