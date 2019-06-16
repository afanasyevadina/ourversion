<?php
require_once('../connect.php');
require_once('../api/schedule.php');
$sf=new Schedule($pdo, '../config.json');
$week=date('W', strtotime($_REQUEST['date']));
$changes=$sf->LessonsToday($_REQUEST['group'], $_REQUEST['date']);
if(empty($changes)) {
	$items=$sf->MainToday($_REQUEST['group'], $_REQUEST['date']);
}
$days=['Понедельник','Вторник','Среда','Четверг','Пятница', 'Суббота'];
$chindex=0;
$index=0;
?>
	<tbody data-day="<?=date('N', strtotime($_REQUEST['date']))?>" class="day">
		<tr class="separator">
			<th>№</th>
			<th><?=$days[date('N', strtotime($_REQUEST['date']))-1]?></th>
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
						<?=$changes[$chindex]['subject_name']?> <i class="teacher"><?=$changes[$chindex]['teacher_name']?></i>		
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
									<?=$items[$index]['subject_name']?> <i class="teacher"><?=$items[$index]['teacher_name']?></i>	
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