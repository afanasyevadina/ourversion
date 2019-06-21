<?php
require_once('facecontrol.php');
require_once('api/subject.php');
require_once('api/group.php');
$sf=new Subject($pdo);
$gf=new Group($pdo);
$pcks=$sf->GetTypes();
$cmks=$gf->GetCmks();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Предметы</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/jquery.form.min.js"></script>
	<script src="js/script.js"></script>
</head>
<body>
	<div id="fon"></div>
	<div id="add">
		<form action="subjects/savesubject.php" method="post" id="subjectform" class="addform">
			<img src="img/close.png" class="cancelnew" alt="close">
			<input type="hidden" name="id" id="id">
			<div>
				<label for="teachername">Индекс: </label>
			</div>
			<div>
				<input type="text" name="index" id="subjectindex" autocomplete="off">
			</div>
			<div>
				<label for="teachername">Название: </label>
			</div>
			<div>
				<input type="text" name="name" id="subjectname" autocomplete="off">
			</div>
			<div>
				<label for="pck">Предметно-цикловая комиссия</label>
			</div>
			<div>
				<select name="pck" id="pck">
					<?php foreach($pcks as $pck) { ?>
						<option value="<?=$pck['type_id']?>"><?=$pck['type_name']?></option>
					<?php } ?>
				</select>
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
			<div>
				<label><input type="checkbox" name="divide" value="1" id="divide">Формировать подгруппы</label>
			</div>
			<input type="submit" name="submit" value="Сохранить">
			<a id="deletesubject" class="delete" href="">Удалить</a>
		</form>		
	</div>
	
	<div id="uploadform">
		<form action="subjects/uploadsubjects.php" method="post" enctype="multipart/form-data" class="uploadform">
			<img src="img/close.png" class="cancelnew" alt="close">
	        <div>
	            <div>
	                <input type="file" name="upload" accept="application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />
	            </div>
	        </div>
	        <div>
	            <div>
	                <input type="submit" value="Отправить"/>
	            </div>
	        </div>
	    </form>
	</div>
	<?php require_once('layout.php'); ?>
	<div class="container">
		<div class="main">
			<h2>Предметы</h2>
			<div class="links">
				<a href="#" id="new">Добавить</a>
				<a href="templates/subjects.xlsx" class="download">Скачать шаблон</a>
				<a href="#" id="upload">Загрузить</a>
			</div>
			<table id="subjects" border="1">
				<thead id="headgroup">
					<tr>
						<th>Индекс</th>
						<th>Название</th>
						<th>ПЦК</th>
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
		Load('subjects/getsubjects.php', '#subjects tbody');

		$('#upload').click(function(){
			$('#uploadform').css('display', 'flex');
			$('#fon').css('display', 'flex');
		});
	</script>
</body>
</html>