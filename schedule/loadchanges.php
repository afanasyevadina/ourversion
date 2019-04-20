<?php
require_once('../connect.php');
require_once('../api/schedule.php');
$sf=new Schedule($pdo);
$date=date('N', strtotime($_REQUEST['date']));
$week=date('W', strtotime($_REQUEST['date']));
$changes=$sf->LessonsToday($_REQUEST['group'], $_REQUEST['date']);
$items=$sf->MainToday(array($_REQUEST['group'], $_REQUEST['kurs'], $_REQUEST['sem'], $date));
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
						<li data-id="<?=$changes[$chindex]['item_id']?>" data-num="<?=$j?>" data-teacher="<?=$changes[$chindex]['teacher_id']?>" class="inner_lesson">
						<?=$changes[$chindex]['subject_name']?> <?=$changes[$chindex]['teacher_name']?>							
						</li>
						<?php 
						$chindex++;
						$count++;
					}

					if(!$count) {
						while($items[$index]['num_of_lesson']==$j) {
							if(!$items[$index]['weeks']||$items[$index]['weeks']==$week%2+1) { ?>
								<li data-id="<?=$items[$index]['item_id']?>" data-num="<?=$j?>" data-teacher="<?=$items[$index]['teacher_id']?>">
									<?=$items[$index]['subject_name']?> <?=$items[$index]['teacher_name']?>							
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
			<td contenteditable="true">25</td>
		</tr>
	<?php } ?>
	</tbody>
<script type="text/javascript">
	Update();
	Numerate();
</script>