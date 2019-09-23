<?php
require_once('../connect.php');
require_once('../api/schedule.php');
$sf=new Schedule($pdo, '../config.json');
$date = isset($_REQUEST['date']) ? $_REQUEST['date'] : date('d.m.Y');
$week=date('N', strtotime($date));
if(isset($_REQUEST['group'])) {
	$changes=$sf->LessonsToday($_REQUEST['group'], $date);
	if(empty($changes)) {
		$items=$sf->MainToday($_REQUEST['group'], $date);
	}
}
if(isset($_REQUEST['teacher'])) {
	$changes=$sf->LessonsToday($_REQUEST['teacher'], $date, false);
	if(empty($changes)) {
		$items=$sf->MainToday($_REQUEST['teacher'], $date, false);
	}
}
$days=['Понедельник','Вторник','Среда','Четверг','Пятница', 'Суббота'];
$chindex=0;
$index=0;
?>
	<tbody data-day="<?=$week?>" class="day">
		<tr class="separator">
			<th>№</th>
			<th><?=$days[$week-1]?></th>
			<th>каб.</th>
		</tr>
	<?php for($j=1;$j<=7;$j++) {
		$count=0; ?>
		<tr>
			<td class="lesson_num"><?=$j?></td>
			<td class="list_box">
				<ul class="sortable" data-num="<?=$j?>" data-day="<?=$i?>">
					<?php 
					while ($changes[$chindex]['lesson_num']==$j) { ?>
						<li data-id="<?=$changes[$chindex]['item_id']?>" data-num="<?=$j?>" data-teacher="<?=$changes[$chindex]['teacher_id']?>" data-cab="<?=$changes[$chindex]['cabinet_id']?>" class="inner_lesson">
						<?=$changes[$chindex]['subject_name']?> 
							<i class="teacher">
							<?=isset($_REQUEST['group']) ? $changes[$chindex]['teacher_name'] : $changes[$chindex]['group_name']?></i>		
							<div class="cab_num"><?=$changes[$chindex]['cabinet_name']?></div>								
						</li>
						<?php 
						$chindex++;
						$count++;
					}

					if(empty($changes)) {
						while($items[$index]['num_of_lesson']==$j) {
							if(!$items[$index]['weeks']||$items[$index]['weeks']==$week%2+1) { ?>
								<li data-id="<?=$items[$index]['item_id']?>" data-num="<?=$j?>" data-teacher="<?=$items[$index]['teacher_id']?>" data-cab="<?=$items[$index]['cabinet_id']?>" class="inner_lesson">
									<?=$items[$index]['subject_name']?> 
									<i class="teacher">
									<?=isset($_REQUEST['group']) ? $items[$index]['teacher_name'] : $items[$index]['group_name']?></i>	
									<div class="cab_num"><?=$items[$index]['cabinet_name']?></div>									
								</li>
							<?php 
								$count++;
							}
							$index++; 
						} 
					}
					
					if(!$count) { ?>
						<li class="empty"></li>
					<?php } ?>
				</ul>
			</td>
			<td class="cab_cell"></td>
		</tr>
	<?php } ?>
	</tbody>
<script type="text/javascript">
	Update();
	Numerate();
</script>