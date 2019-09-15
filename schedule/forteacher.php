<?php
require_once('../connect.php');
require_once('../api/group.php');
require_once('../api/schedule.php');
require_once('../api/item.php');
$sf=new Schedule($pdo, '../config.json');
//$teacher=$user['person_id'];
$it=new Item($pdo);
$items=$sf->TeacherSchedule($_REQUEST['teacher'], $_REQUEST['kurs'], $_REQUEST['sem']);
$index=0;
$days=['Понедельник','Вторник','Среда','Четверг','Пятница', 'Суббота'];
for($i=1;$i<=6; $i++) { ?>
	<table border="1" data-day="<?=$i?>" class="day">
		<tr class="separator">
			<th>№</th>
			<th><?=$days[$i-1]?></th>
			<th>каб.</th>
		</tr>
	<?php for($j=1;$j<=7;$j++) {
		?>
		<tr>
			<td class="lesson_num"><?=$j?></td>
			<td class="list_box">
				<?php if($items[$index]['num_of_lesson']==$j&&$items[$index]['day_of_week']==$i&&$items[$index]['weeks']) {
					 ?>
					<ul class="sortable">
						<?php 
						$count=0;
						while($items[$index]['num_of_lesson']==$j&&$items[$index]['day_of_week']==$i&&$items[$index]['weeks']==1) {
						$subgroup=$item['subgroup'] && $item['divide'] != Subject::DIV_PRAC ? $item['subgroup'].' подгруппа' : '';?>
						<li class="inner_lesson">
							<?=$items[$index]['subject_name'].' '.$subgroup?> 
							<i><?=$items[$index]['group_name']?></i>
							<div class="cab_num"><?=$items[$index]['cabinet_name']?></div>							
						</li>
						<?php 
							$index++; 
							$count++;
						} 
						if(!$count) { ?>
							<li class="empty"></li>
						<?php } ?>
					</ul>
					<div class="separator"></div>
					<ul class="sortable" data-num="<?=$j?>" data-day="<?=$i?>" data-week="2">
						<?php 
						$count=0;
						while($items[$index]['num_of_lesson']==$j&&$items[$index]['day_of_week']==$i&&$items[$index]['weeks']==2) {
						$subgroup=$item['subgroup'] && $item['divide'] != Subject::DIV_PRAC ? $item['subgroup'].' подгруппа' : '';?>
						<li class="inner_lesson">
							<?=$items[$index]['subject_name'].' '.$subgroup?> 
							<i><?=$items[$index]['group_name']?></i>
							<div class="cab_num"><?=$items[$index]['cabinet_name']?></div>							
						</li>
						<?php 
							$index++; 
							$count++;
						} 
						if(!$count) { ?>
							<li class="empty"></li>
						<?php } ?>
					</ul>
				<?php } 
				else {?>

					<ul class="sortable">
						<?php 
						$count=0; 
						while($items[$index]['num_of_lesson']==$j&&$items[$index]['day_of_week']==$i) {
						$subgroup=$item['subgroup'] && $item['divide'] != Subject::DIV_PRAC ? $item['subgroup'].' подгруппа' : '';?>
						<li class="inner_lesson">
							<?=$items[$index]['subject_name'].' '.$subgroup?> 
							<i><?=$items[$index]['group_name']?></i>
							<div class="cab_num"><?=$items[$index]['cabinet_name']?></div>						
						</li>
						<?php 
							$index++; 
							$count++;
						} 
						if(!$count) { ?>
							<li class="empty"></li>
						<?php } ?>
					</ul>
				<?php } ?>
			</td>
			<td class="cab_cell"></td>
		</tr>
	<?php } ?>
	</table> <?php
}