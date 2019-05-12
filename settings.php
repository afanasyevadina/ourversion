<?php
require_once('facecontrol.php');
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
</head>
<body>
	<?php require_once('layout.php'); ?>
	<div class="container">
		
		<div class="main">
			<h2>Настройки</h2>
			<div class="success">
				<h3>Изменения сохранены.</h3>
			</div>
			<div class="error">
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
		</div>
	</div>
	<footer></footer>
	<script type="text/javascript">
		$('form').ajaxForm({
			dataType: 'html',
			success: function(response) {
				$('.success').show();
				setTimeout(function(){
					$('.success').hide();
				},2000);
			},
			error: function(response) {
				$('.error').show();
				setTimeout(function(){
					$('.error').hide();
				},2000);
			}
		});
	</script>
</body>
</html>