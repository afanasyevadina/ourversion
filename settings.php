<?php
require_once('facecontrol.php');
require_once('api/schedule.php');
$sf=new Schedule($pdo, 'config.json');
$cabs=$sf->GetCabinets();
$config=json_decode(file_get_contents('config.json'), true);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Настройки</title>
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
			<h2>Настройки</h2>
			<div class="success" id="set_success">
				<h3>Изменения сохранены.</h3>
			</div>
			<div class="error" id="set_error">
				<h3>Ошибка! Изменения не сохранены.</h3>
			</div>
			<form action="api/config.php" method="POST" class="settings">
				<div>
					<label class="param">1 семестр</label>
					<label>
						 с <select name="start1_day">
							<?php for($i=1;$i<=31;$i++) { ?>
								<option <?=$i==$config['start1_day']?'selected':''?>><?=$i?></option>
							<?php } ?>
						</select>
						<select name="start1_month">
							<option <?=1==$config['start1_month']?'selected':''?> value="1">Января</option>
							<option <?=2==$config['start1_month']?'selected':''?> value="2">Февраля</option>
							<option <?=3==$config['start1_month']?'selected':''?> value="3">Марта</option>
							<option <?=4==$config['start1_month']?'selected':''?> value="4">Апреля</option>
							<option <?=5==$config['start1_month']?'selected':''?> value="5">Мая</option>
							<option <?=6==$config['start1_month']?'selected':''?> value="6">Июня</option>
							<option <?=7==$config['start1_month']?'selected':''?> value="7">Июля</option>
							<option <?=8==$config['start1_month']?'selected':''?> value="8">Августа</option>
							<option <?=9==$config['start1_month']?'selected':''?> value="9">Сентября</option>
							<option <?=10==$config['start1_month']?'selected':''?> value="10">Октября</option>
							<option <?=11==$config['start1_month']?'selected':''?> value="11">Ноября</option>
							<option <?=12==$config['start1_month']?'selected':''?> value="12">Декабря</option>
						</select>
					</label>
					<label>
						 по <select name="finish1_day">
							<?php for($i=1;$i<=31;$i++) { ?>
								<option <?=$i==$config['finish1_day']?'selected':''?>><?=$i?></option>
							<?php } ?>
						</select>
						<select name="finish1_month">
							<option <?=1==$config['finish1_month']?'selected':''?> value="1">Января</option>
							<option <?=2==$config['finish1_month']?'selected':''?> value="2">Февраля</option>
							<option <?=3==$config['finish1_month']?'selected':''?> value="3">Марта</option>
							<option <?=4==$config['finish1_month']?'selected':''?> value="4">Апреля</option>
							<option <?=5==$config['finish1_month']?'selected':''?> value="5">Мая</option>
							<option <?=6==$config['finish1_month']?'selected':''?> value="6">Июня</option>
							<option <?=7==$config['finish1_month']?'selected':''?> value="7">Июля</option>
							<option <?=8==$config['finish1_month']?'selected':''?> value="8">Августа</option>
							<option <?=9==$config['finish1_month']?'selected':''?> value="9">Сентября</option>
							<option <?=10==$config['finish1_month']?'selected':''?> value="10">Октября</option>
							<option <?=11==$config['finish1_month']?'selected':''?> value="11">Ноября</option>
							<option <?=12==$config['finish1_month']?'selected':''?> value="12">Декабря</option>
						</select>
					</label>
				</div>
				<div>
					
					<label class="param">2 семестр</label>
					<label>
						 с <select name="start2_day">
							<?php for($i=1;$i<=31;$i++) { ?>
								<option <?=$i==$config['start2_day']?'selected':''?>><?=$i?></option>
							<?php } ?>
						</select>
						<select name="start2_month">
							<option <?=1==$config['start2_month']?'selected':''?> value="1">Января</option>
							<option <?=2==$config['start2_month']?'selected':''?> value="2">Февраля</option>
							<option <?=3==$config['start2_month']?'selected':''?> value="3">Марта</option>
							<option <?=4==$config['start2_month']?'selected':''?> value="4">Апреля</option>
							<option <?=5==$config['start2_month']?'selected':''?> value="5">Мая</option>
							<option <?=6==$config['start2_month']?'selected':''?> value="6">Июня</option>
							<option <?=7==$config['start2_month']?'selected':''?> value="7">Июля</option>
							<option <?=8==$config['start2_month']?'selected':''?> value="8">Августа</option>
							<option <?=9==$config['start2_month']?'selected':''?> value="9">Сентября</option>
							<option <?=10==$config['start2_month']?'selected':''?> value="10">Октября</option>
							<option <?=11==$config['start2_month']?'selected':''?> value="11">Ноября</option>
							<option <?=12==$config['start2_month']?'selected':''?> value="12">Декабря</option>
						</select>
					</label>
					<label>
						 по <select name="finish2_day">
							<?php for($i=1;$i<=31;$i++) { ?>
								<option <?=$i==$config['finish2_day']?'selected':''?>><?=$i?></option>
							<?php } ?>
						</select>
						<select name="finish2_month">
							<option <?=1==$config['finish2_month']?'selected':''?> value="1">Января</option>
							<option <?=2==$config['finish2_month']?'selected':''?> value="2">Февраля</option>
							<option <?=3==$config['finish2_month']?'selected':''?> value="3">Марта</option>
							<option <?=4==$config['finish2_month']?'selected':''?> value="4">Апреля</option>
							<option <?=5==$config['finish2_month']?'selected':''?> value="5">Мая</option>
							<option <?=6==$config['finish2_month']?'selected':''?> value="6">Июня</option>
							<option <?=7==$config['finish2_month']?'selected':''?> value="7">Июля</option>
							<option <?=8==$config['finish2_month']?'selected':''?> value="8">Августа</option>
							<option <?=9==$config['finish2_month']?'selected':''?> value="9">Сентября</option>
							<option <?=10==$config['finish2_month']?'selected':''?> value="10">Октября</option>
							<option <?=11==$config['finish2_month']?'selected':''?> value="11">Ноября</option>
							<option <?=12==$config['finish2_month']?'selected':''?> value="12">Декабря</option>
						</select>
					</label>
				</div>				
				<div>
					<label class="param">Количество студентов для деления на подгруппы</label>
					<input type="number" min="0" name="students_count" value="<?=$config['students_count']?>">
				</div>			
				<div>
					<label class="param">Количество дней в учебной неделе</label>
					<input type="number" min="0" max="7" name="days_count" value="<?=$config['days_count']?>">
				</div>
				<input type="submit" value="Сохранить">
			</form>
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
			<br>
			<hr>
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
			<br>
			<hr>
			<h2>Кабинеты</h2>
			<div class="success" id="cab_success">
				<h3>Изменения сохранены.</h3>
			</div>
			<div class="error" id="cab_error">
				<h3>Ошибка! Изменения не сохранены.</h3>
			</div>
			<div class="links">
				<a href="#" id="newcab">Добавить</a>
				<a href="#" id="savecab" class="save">Сохранить</a>
			</div>
			<table id="cabinets" border="1">
				<thead id="headgroup">
					<tr>
						<th>Название</th>
						<th>Описание</th>
						<th>Вместимость</th>
						<th>Заблокирован</th>
						<th>Разрешить наложения</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($cabs as $cab) { ?>
						<tr>
							<td class="cab_name" contenteditable="true"><?=$cab['cabinet_name']?></td>
							<td class="cab_desc" contenteditable="true"><?=$cab['cab_description']?></td>
							<td class="cab_places" contenteditable="true"><?=$cab['cab_places']?></td>
							<td>
								<label class="check_label">
									<input type="checkbox" id="locked" <?=$cab['locked'] ? 'checked' : ''?>>
								</label>
							</td>
							<td>
								<label class="check_label">
									<input type="checkbox" id="match" <?=$cab['allow_match'] ? 'checked' : ''?>>
								</label>
							</td>
							<td class="deletecab" data-id="<?=$cab['cabinet_id']?>"><img src="img/trash.svg"></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
	<footer></footer>
	<script type="text/javascript">
		Load('specializations/getspecializations.php', '#specializations tbody');
		$('form').ajaxForm({
			dataType: 'html',
			success: function(response) {
				$('#set_success').show();
				setTimeout(function(){
					$('#set_success').hide();
				},2000);
			},
			error: function() {
				$('#set_error').show();
				setTimeout(function(){
					$('#set_error').hide();
				},2000);
			}
		});

		$('#newcab').click(function(e) {
			e.preventDefault();
			$('#cabinets tbody')
			.append("<tr><td class='cab_name' contenteditable='true'></td>"+
				"<td class='cab_desc' contenteditable='true'></td>"+
				"<td class='cab_places' contenteditable='true'></td>"+
				"<td><label class='check_label'><input type='checkbox' id='locked'></label></td>"+
				"<td><label class='check_label'><input type='checkbox' id='match'></label></td>"+
				"<td class='deletecab'><img src='img/trash.svg'></td></tr>");
		});

		$('#savecab').click(function(e) {
			e.preventDefault();
			var res=[];
			$('#cabinets tbody').find('tr.edited').each(function(){
				var temp=[];
				temp.push($(this).find('td.cab_name').html());
				temp.push($(this).find('td.cab_desc').html());
				temp.push($(this).find('td.cab_places').html());
				temp.push($(this).find('input#locked').prop('checked') ? 1 :0);
				temp.push($(this).find('input#match').prop('checked') ? 1 :0);
				res.push(temp);
				$.ajax({
					url: 'schedule/savecabinet.php',
					method: 'POST',
					dataType: 'html',
					data: 'data='+JSON.stringify(res),
					success: function(response) {
						$('#cabinets tr').removeClass('edited');
						$('#cab_success').show();
						setTimeout(function(){
							$('#cab_success').hide();
						},2000);
					},
					error: function() {
						$('#cab_error').show();
						setTimeout(function(){
							$('#cab_error').hide();
						},2000);
					}
				});
			});
		});

		$('#cabinets tbody').on('click', '.deletecab', function(){
			if(!!$(this).data('id')) {
				$.ajax({
					url: 'schedule/deletecabinet.php',
					method: 'POST',
					dataType: 'html',
					data: 'id='+$(this).data('id')
				});
			}
			$(this).parent().remove();
		});

		$('#cabinets tbody').on('input', 'td.cab_name, td.cab_desc, td.cab_places', function() {
			$(this).parent().addClass('edited');
		});
		$('#cabinets tbody').on('change', 'input', function() {
			$(this).parent().parent().parent().addClass('edited');
		});
	</script>
</body>
</html>