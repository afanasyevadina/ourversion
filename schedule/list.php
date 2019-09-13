<?php
require_once('../connect.php');
require_once('../api/item.php');
require_once('../api/subject.php');
$it=new Item($pdo);
$items=$it->GetGroupItems($_REQUEST['group'], $_REQUEST['kurs']);
$was=[];
$gs=[];
foreach($items as $item) {
	if($item['sem'.$_REQUEST['sem']]>0 &&
	($item['subgroup'] != 2 || $item['subgroup'] == 2 && $item['divide'] != Subject::DIV_PRAC)) {
		$subgroup=$item['subgroup'] && $item['divide'] != Subject::DIV_PRAC ? $item['subgroup'].' подгруппа' : '';	?>
		<li data-teacher="<?=$item['teacher_id']?>" data-id="<?=$item['item_id']?>" class="sub_item" data-subgroup="<?=$item['subgroup']?>">
			<?=$item['subject_name'].' '.$subgroup?>
			<i><?=$item['teacher_name']?></i> 
			<i class="hours">(<?=$item['sem'.$_REQUEST['sem']]?>)</i>
		</li>
	<?php
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