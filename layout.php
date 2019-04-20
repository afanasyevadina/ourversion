<?php
require_once('facecontrol.php');
?>
<div class="fixed-top">
		<label for="menucheck">
			<div id="menuicon">
				<img src="img/menu.svg" alt="menu">
			</div>
		</label>
		<div>
			<div class="lang">
				<a href="#">RU </a><a href="#">KZ</a>
			</div>
			<div class="separator"></div>
			<div class="auth">
				<a href="" class="a_name"><?=$name?><img src="img/down-arrow.svg" alt=""></a>
				<a href="login.php" class="logout"><img src="img/logout.svg" alt="">Выход</a>
			</div>
		</div>
	</div>
	<input type="checkbox" id="menucheck">
		<div class="menu">
			<div class="menuitem">
				<a href="/">Главная</a>
			</div>		
			<?php
			if($user['account_type']=='admin') { ?>
			<div class="menuitem">
				<a href="specializations.php">Специальности</a>
			</div>
			<div class="menuitem">
				<a href="groups.php">Группы</a>
			</div>		
			<div class="menuitem">
				<a href="teachers.php">Преподаватели</a>
			</div>			
			<div class="menuitem">
				<a href="students.php">Студенты</a>
			</div>									
			<div class="menuitem">
				<a href="subjects.php">Дисциплины</a>
			</div>		
			<div class="menuitem">
				<a href="ruprograms.php">Рабочая учебная программа</a>
			</div>			
			<div class="menuitem">
				<a href="rup.php">Рабочий учебный план</a>
			</div>				
			<div class="menuitem">
				<a href="ktps.php">КТП</a>
			</div>				
			<div class="menuitem">
				<a href="up.php">План УП</a>
			</div>			
			<div class="menuitem">
				<a href="personal.php">Нагрузка преподавателя</a>
			</div>			
			<div class="menuitem">
				<a href="journals.php">Журналы</a>
			</div>				
			<div class="menuitem">
				<a href="schedule.php">Расписание</a>
			</div>				
			<div class="menuitem">
				<a href="changes.php">Изменения в расписании</a>
			</div>	
			<?php } 
			if($user['account_type']=='student') { ?>	
			<div class="menuitem">
				<a href="student_schedule.php">Мое расписание</a>
			</div>							
			<div class="menuitem">
				<a href="public_changes.php">Изменения в расписании</a>
			</div>	
			<div class="menuitem">
				<a href="rating.php">Мои оценки</a>
			</div>		
			<?php } 
			if($user['account_type']=='teacher') { ?>	
			<div class="menuitem">
				<a href="teacher_schedule.php">Мое расписание</a>
			</div>						
			<div class="menuitem">
				<a href="public_changes.php">Изменения в расписании</a>
			</div>		
			<div class="menuitem">
				<a href="journals.php">Журналы</a>
			</div>		
			<div class="menuitem">
				<a href="ruprograms.php">Рабочая учебная программа</a>
			</div>			
			<div class="menuitem">
				<a href="rup.php">Рабочий учебный план</a>
			</div>				
			<div class="menuitem">
				<a href="ktps.php">КТП</a>
			</div>				
			<div class="menuitem">
				<a href="up.php">План УП</a>
			</div>					
			<?php } ?>
		</div>