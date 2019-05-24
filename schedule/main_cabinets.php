<?php
require_once('../connect.php');
require_once('../api/schedule.php');
$sf=new Schedule($pdo, '../config.json');
$cabinets=$sf->GetCabinets();
foreach ($cabinets as $cabinet) {
	if($cabinet['locked']) continue;

	if($sf->IsEmptyMain($cabinet['cabinet_id'], $_REQUEST['day'], $_REQUEST['num'])) { ?>
		<p class="cabinet" data-id="<?=$cabinet['cabinet_id']?>"><?=$cabinet['cabinet_name']?></p>
	<?php
	}
}
?>