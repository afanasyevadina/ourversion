<?php
$title = 'Студенты';
require_once('layout.php');
require_once('api/group.php');
$gf=new Group($pdo);
$groups=$gf->GetGroups();
?>
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
			<div class="subgroup">
				<label><input type="radio" name="subgroup" id="subgroup1" value="1">1 подгруппа</label>
			</div>
			<div class="subgroup">
				<label><input type="radio" name="subgroup" id="subgroup2" value="2">2 подгруппа</label>
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
			<select id="subgroupselect">
				<option value="0">Все</option>
				<option value="1">1 подгруппа</option>
				<option value="2">2 подгруппа</option>
			</select>
			<div class="links">
				<a href="#" id="new">Добавить</a>
				<a href="templates/students.xlsx" class="download">Скачать шаблон</a>
				<a href="#" id="upload">Загрузить</a>
				<form action="accounts/getlogin.php" method="POST" id="loginform">
					<input type="hidden" name="type" value="student">
					<input type="submit" class="generate" value="Сгенерировать данные для входа" style="display: none;">				
				</form>
			</div>
			<input type="text" placeholder="Поиск..." class="query" style="margin-bottom: 10px">
			<table id="students" border="1">
				<thead id="headgroup">
					<tr>
						<th class="ch_box">
							<label class="check_label">
								<input type="checkbox">Выбрать все
							</label>
						</th>
						<th>№</th>
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
	<script src="js/search.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$.ajax({
				url: 'students/getstudents.php',
				method: 'POST',
				data: 'group='+$('#stdgroupselect').val()+'&subgroup=0',
				dataType: 'html',
				success: function(result) {
					if(!result.split('endcount')[0]) {
						$('.subgroup').hide();
						$('#subgroupselect').hide();
					} else {
						$('.subgroup').show();
						$('#subgroupselect').show();
					}
					$('#students tbody').html(result.split('endcount')[1]);
				}
			});
		});
	</script>
</body>
</html>