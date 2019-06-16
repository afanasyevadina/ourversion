<?php
require_once('../connect.php');
require_once('../api/item.php');
$it=new Item($pdo);
$items=$it->GetGroupItems($_REQUEST['group'], $_REQUEST['kurs']);
$was=[];
$gs=[];
foreach($items as $item) {
	if($item['theory']>0) {
		$gs[]=$item['general_id'];
	}
	if(($item['sem'.$_REQUEST['sem']]>0)&&
	($item['theory']>0||!in_array($item['general_id'], $gs))) {
		$divide=!$item['theory']&&$item['subgroup']!=0 ? 'half' : '';
		$subgroup=$divide ? $item['subgroup'].' подгруппа' : '';
		?>
		<li data-teacher="<?=$item['teacher_id']?>" data-id="<?=$item['item_id']?>" class="sub_item <?=$divide?>">
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