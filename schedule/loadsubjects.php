<?php
require_once('../connect.php');
require_once('../api/item.php');
require_once('../api/schedule.php');
require_once('../api/subject.php');
$it=new Item($pdo);
$sf=new Schedule($pdo, '../config.json');
$date=$sf->CurrentKurs($_REQUEST['date']);
$items=$it->GetGroupItems($_REQUEST['group'], $date['kurs']);
$was=[];
$warnings=[];
$gs=[];
foreach($items as $item) { 
	if($item['sem'.$date['sem']]>0) {
		$next=$sf->GetNext($item['item_id'], $date['sem']);
		$gone=$sf->GetGone($item['item_id'], $date['sem']);
		$warning=$sf->CheckNext($item, $next);
		if($warning) {
			$warnings[]=$item['general_id'];
		}
		if($item['theory']>0) {
			$gs[]=$item['general_id'];
		}
		$subgroup=$item['subgroup'] && ($warning || $item['divide'] != Subject::DIV_PRAC) ? $item['subgroup'].' подгруппа' : '';
		if(in_array($item['general_id'], $warnings)||(!$warning&&$item['theory']>0)||!in_array($item['general_id'], $gs)) {
			$cab = $sf->MainCabinet($item['item_id']);
			?>
			<li data-teacher="<?=$item['teacher_id']?>" data-id="<?=$item['item_id']?>" class="sub_item" data-cab="<?=$cab['cabinet_id']?>" data-c_name="<?=$cab['cabinet_name']?>">
				<?=$item['subject_name'].' '.$subgroup?> 
				<i class="teacher"><?=$item['teacher_name']?></i>
				<i class="hours">(<?=$gone?>/<?=$item['sem'.$date['sem']]?>)</i>
			</li>
	<?php }
	}
} ?>
<script type="text/javascript">
	$( ".draggable li" ).draggable({
		connectToSortable: ".sortable",
		helper: "clone",
		revert: "invalid"
	});
	$( "ul, li" ).disableSelection();
</script>