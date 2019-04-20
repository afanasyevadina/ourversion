<?php
require_once('facecontrol.php');
require_once('api/group.php');
$gf=new Group($pdo);
$cmks=$gf->Getcmks();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Преподаватели</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/jquery.form.min.js"></script>
	<script src="js/script.js"></script>
</head>
<body>
	<div id="fon"></div>
	<div id="add">
		<form action="teachers/saveteacher.php" method="post" id="teacherform" class="addform">
			<img src="img/close.png" class="cancelnew" alt="close">
			<input type="hidden" name="id" id="id">
			<div>
				<label for="fname">Фамилия: </label>
				<input type="text" name="fname" id="fname" autocomplete="off">
			</div>
			<div>
				<label for="sname">Имя: </label>
				<input type="text" name="sname" id="sname" autocomplete="off">
			</div>
			<div>
				<label for="tname">Отчество: </label>
				<input type="text" name="tname" id="tname" autocomplete="off">
			</div>
			<div>
				<label for="cmk">Цикловая методическая комиссия</label>
			</div>
			<div>
				<select name="cmk" id="cmk">
					<?php foreach($cmks as $cmk) { ?>
						<option value="<?=$cmk['cmk_id']?>"><?=$cmk['cmk_name']?></option>
					<?php } ?>
				</select>
			</div>
			<input type="submit" name="submit" value="Сохранить">
			<a id="deleteteacher" class="delete" href="">Удалить</a>
		</form>
	</div>
	<?php require_once('layout.php'); ?>
	<div class="container">
		<div class="main">
			<h2>Преподаватели</h2>
			<div class="links">
				<a href="#" id="new">Добавить</a>
				<form action="accounts/getlogin.php" method="POST" id="loginform">
					<input type="hidden" name="type" value="teacher">
					<input type="submit" class="generate" value="Сгенерировать данные для входа">				
				</form>
			</div>

			<table id="teachers" border="1">
				<thead id="headgroup">
					<tr>
						<th class="ch_box">
							<label class="check_label">
								<input type="checkbox">Выбрать все
							</label>
						</th>
						<th>ФИО</th>
						<th>ЦМК</th>
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
		Load('teachers/getteachers.php', '#teachers tbody');
	</script>
</body>
</html>