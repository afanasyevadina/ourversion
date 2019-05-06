<?php
require_once('facecontrol.php');
require_once('api/group.php');
$gf=new Group($pdo);
if($user['account_type']!='admin') {
	header('Location: /');
}
$groups=$gf->GetGroups();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Студенты</title>
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
		<form action="students/savestudent.php" method="post" id="studentform" class="addform small">
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
				<label>Группа: </label>
			</div>
			<div>
				<select name="group" id="group">
					<?php foreach($groups as $group) { ?>
						<option value="<?=$group['group_id']?>">
							<?=$group['group_name'] ?></option>
					<?php } ?>
				</select>
			</div>
			<input type="submit" name="submit" value="Сохранить">
			<a id="deletestudent" class="delete" href="">Удалить</a>
		</form>	
	</div>

		<div id="uploadform">
		<form action="students/uploadstudents.php" method="post" enctype="multipart/form-data" class="uploadform">
			<img src="img/close.png" class="cancelnew" alt="close">
	        <div>
	        	<div>
	        		<label>Группа: </label>
	        		<select name="group">
					<?php foreach($groups as $group) { ?>
						<option value="<?=$group['group_id']?>">
							<?=$group['group_name'] ?></option>
					<?php } ?>
					</select>
	        	</div>
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

	<div class="container">		
		<div class="main">
			<h2>Студенты</h2>
			<select id="stdgroupselect">
				<?php foreach ($groups as $group) { ?>
					<option value="<?=$group['group_id']?>"><?=$group['group_name']?></option>
				<?php } ?>
			</select>
			<div class="links">
				<a href="#" id="new">Добавить</a>
				<a href="#" id="upload">Загрузить</a>
				<form action="accounts/getlogin.php" method="POST" id="loginform">
					<input type="hidden" name="type" value="student">
					<input type="submit" class="generate" value="Сгенерировать данные для входа" style="display: none;">				
				</form>
			</div>
			<table id="students" border="1">
				<thead id="headgroup">
					<tr>
						<th class="ch_box">
							<label class="check_label">
								<input type="checkbox">Выбрать все
							</label>
						</th>
						<th>Имя</th>
						<th>Группа</th>
						<th></th>
					</tr>
				</thead>
				<tbody>				
				</tbody>
			</table>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function(){
			Load('students/getstudents.php?group='+$('#group').val(), '#students tbody');			
		});
	</script>
</body>
</html>