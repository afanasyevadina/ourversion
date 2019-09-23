<?php
require_once('../connect.php');
require_once('../api/item.php');
require_once('../api/group.php');
require_once('../api/subject.php');
$if=new Item($pdo);
$gf=new Group($pdo);
$items=$if->GetGroupItems($_REQUEST['group'], $_REQUEST['kurs']);
foreach ($items as $item) {
	//if($item['subgroup'] != 2 || $item['divide'] != Subject::DIV_PRAC) {
	if(!$_REQUEST['id'] || $item['teacher_id'] == $_REQUEST['id']) {
		$d=$gf->GetName($item);
		?>
		<p><a class="listitem" href="journal.php?id=<?=$item['item_id']?>"><?=$item['subject_name']?> <?=$d?>, <?=$item['teacher_name']?></p>
<?php }
} ?>