<?php
require_once('../connect.php');
require_once('../api/ruprogram.php');
$rf=new Ruprogram($pdo);
$items=$rf->GetPrograms($_REQUEST['group'], $_REQUEST['subject']);
foreach($items as $item) { ?>
	<p class="searchable"><a class="listitem" href="ruprogram.php?id=<?=$item['program_id']?>"><?=$item['subject_name']?> <?=$item['group_name']?></p>
<?php } ?>