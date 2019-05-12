<?php
require_once('../connect.php');
require_once('../api/item.php');
require_once('../api/schedule.php');
$it=new Item($pdo);
$sf=new Schedule($pdo);
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
		$color=$warning?'#F9E5D7':'#D9DFFC';
		if($warning) {
			$warnings[]=$item['general_id'];
		}
		if($item['theory']>0) {
			$gs[]=$item['general_id'];
		}
		$divide=$item['theory']==0||$warning ? 'half' : '';
		$subgroup=$item['subgroup']&&$divide ? $item['subgroup'].' подгруппа' : '';
		if(in_array($item['general_id'], $warnings)||(!$warning&&$item['theory']>0)||!in_array($item['general_id'], $gs)) {
			?>
			<li data-teacher="<?=$item['teacher_id']?>" data-id="<?=$item['item_id']?>" style="background-color:<?=$color?>" class="sub_item <?=$divide?>"><?=$item['subject_name'].' '.$subgroup?> <i><?=$item['teacher_name']?></i><span><?=$gone?>/<?=$item['sem'.$date['sem']]?></span></li>
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