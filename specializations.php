<?php
require_once('facecontrol.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Специальности</title>
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
				<form action="specializations/savespecialization.php" method="post" id="specform" class="addform wide">
					<img src="img/close.png" class="cancelnew" alt="close">
					<input type="hidden" name="id" id="id">
					<div>
						<label for="name">Название: </label>
					</div>
					<div>
						<input type="text" name="name" id="name" autocomplete="off">
					</div>
					<div>
						<label for="code">Шифр: </label>
					</div>
					<div>
						<input type="text" name="code" id="code" autocomplete="off">
					</div>
					<div>
						<label for="courses">Количество курсов: </label>
					</div>
					<div>
						<input type="number" name="courses" value="4" min="1" max="5" id="courses">
					</div>

					<input type="submit" name="submit" value="Сохранить">
					<a id="deletespec" class="delete" href="">Удалить</a>
				</form>
			</div>
	<div class="container">
		<div class="main">
			<h2>Специальности</h2>
			<div class="links">
				<a href="#" id="new">Добавить</a>
			</div>
			<table id="specializations" border="1">
				<thead id="headgroup">
					<tr>
						<th>Название</th>
						<th>Шифр</th>
						<th>Количество курсов</th>
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
		Load('specializations/getspecializations.php', '#specializations tbody');
	</script>
</body>
</html>