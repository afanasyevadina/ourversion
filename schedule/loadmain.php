<?php
require_once('../connect.php');
require_once('../api/schedule.php');
require_once('../api/item.php');
$sf=new Schedule($pdo, '../config.json');
$it=new Item($pdo);
$items=$sf->GetMain($_REQUEST['group'], $_REQUEST['kurs'], $_REQUEST['sem']);
$index=0;
$days=['Понедельник','Вторник','Среда','Четверг','Пятница', 'Суббота'];
for($i=1;$i<=6; $i++) { ?>
	<tbody data-day="<?=$i?>" class="day">
		<tr class="separator">
			<th></th>
			<th>№</th>
			<th><?=$days[$i-1]?></th>
			<th>каб.</th>
		</tr>
	<?php for($j=1;$j<=7;$j++) {
		?>
		<tr>
			<td class="divide"><img src="img/divide.svg"/></td>
			<td class="lesson_num"><?=$j?></td>
			<td class="list_box">
				<?php if($items[$index]['num_of_lesson']==$j&&$items[$index]['day_of_week']==$i&&$items[$index]['weeks']) {
					 ?>
					<ul class="sortable" data-num="<?=$j?>" data-day="<?=$i?>" data-week="1">
						<?php 
						$count=0;
						while($items[$index]['num_of_lesson']==$j&&$items[$index]['day_of_week']==$i&&$items[$index]['weeks']==1) {
						$divide = $it->Divide($items[$index][$index]);
						$subgroup=$divide ? $item['subgroup'].' подгруппа' : ''; ?>
						<li data-id="<?=$items[$index]['item_id']?>" data-num="<?=$j?>" data-day="<?=$i?>" data-teacher="<?=$items[$index]['teacher_id']?>" class="inner_lesson" data-s_item="<?=$items[$index]['sch_id']?>" data-cab="<?=$items[$index]['cabinet_id']?>" data-subgroup="<?=$item[$index]['subgroup']?>">
							<?=$items[$index]['subject_name'].' '.$subgroup?> 
							<i><?=$items[$index]['teacher_name']?></i>
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
						$divide = $it->Divide($items[$index]);
						$subgroup=$divide ? $items[$index]['subgroup'].' подгруппа' : ''; ?>
						<li data-id="<?=$items[$index]['item_id']?>" data-num="<?=$j?>" data-day="<?=$i?>" data-teacher="<?=$items[$index]['teacher_id']?>" class="inner_lesson <?=$divide?>" data-s_item="<?=$items[$index]['sch_id']?>" data-cab="<?=$items[$index]['cabinet_id']?>" data-subgroup="<?=$item[$index]['subgroup']?>">
							<?=$items[$index]['subject_name'].' '.$subgroup?> 
							<i><?=$items[$index]['teacher_name']?></i>
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

					<ul class="sortable" data-num="<?=$j?>" data-day="<?=$i?>">
						<?php 
						$count=0; 
						while($items[$index]['num_of_lesson']==$j&&$items[$index]['day_of_week']==$i) {
						$divide = $it->Divide($items[$index]);
						$subgroup=$divide ? $items[$index]['subgroup'].' подгруппа' : ''; ?>
						<li data-id="<?=$items[$index]['item_id']?>" data-num="<?=$j?>" data-day="<?=$i?>" data-teacher="<?=$items[$index]['teacher_id']?>" class="inner_lesson <?=$divide?>" data-s_item="<?=$items[$index]['sch_id']?>" data-cab="<?=$items[$index]['cabinet_id']?>" data-subgroup="<?=$divide?>">
							<?=$items[$index]['subject_name'].' '.$subgroup?> 
							<i><?=$items[$index]['teacher_name']?></i>	
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
	</tbody> <?php
}
?>
<script type="text/javascript">
	Update();
	Numerate();
</script>