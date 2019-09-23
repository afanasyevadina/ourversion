	<div class="container">
		<div class="main" style="width: calc(100% - 300px)">			
			<section class="section">
				<div class="overlay">
					<h1 class="section_header">Добро пожаловать,<br> <?=$name?>!</h1>
				</div>
				<img src="img/hello.jpg">
			</section>
			<section class="section">
				<h2>Расписание на сегодня</h2>
				<div class="table_c changes">
					<table border="1" class="schedule_table full">		
					</table>
				</div>
			</section>
			<section class="section">
				<h1 class="section_title">Что умеет данная АИС?</h1>
				<div class="section_container">
					<div class="section_item">
						<img src="img/plan.png">
						<h4>Загрузка и редактирование Плана УП</h4>
						<p>Загружайте Ваши планы в формате электронных таблиц или создавайте онлайн.</p>
					</div>
					<div class="section_item">
						<img src="img/get.png">
						<h4>Генерация Рабочих учебных планов</h4>
						<p>На основе планов создаются РУПы на каждый год. Вам остается только определить преподавателей и скорректировать распределние часов при необходимости.</p>
					</div>
					<div class="section_item">
						<img src="img/edit.jpg">
						<h4>Редактор РУП и КТП</h4>
						<p>Создавайте онлайн рабочие учебные программы на основе плана и генерируйте КТП в один клик!</p>
					</div>
					<div class="section_item">
						<img src="img/wordexcel.jpg">
						<h4>Скачивание готовых документов в формате Word и Excel</h4>
						<p>Учебные планы, РУП и КТП можно скачать к себе на компьютер.</p>
					</div>	
				</div>			
			</section>
				<p class="p_s">P.S. Не судите строго, этот искусственный интеллект не так умен, как ожидалось.</p>
		</div>
	</div>
	<footer></footer>
	<input type="hidden" id="teacher" value="<?=@$user['person_id']?>">
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/jquery.form.min.js"></script>
	<script src="js/jquery-ui.js"></script>		
	<script src="js/script.js"></script>
	<script src="js/schedule.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			Load('schedule/loadchanges.php?teacher='+$('#teacher').val(), '.schedule_table');
		});
	</script>
</body>
</html>