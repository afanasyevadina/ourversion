<?php
require_once('../connect.php');
require_once('../api/schedule.php');
$sf=new Schedule($pdo, '../config.json');
$cabinets=$sf->GetCabinets();
foreach ($cabinets as $cabinet) {
	if($cabinet['locked']) continue;
	if($cabinet['allow_match'] || $sf->IsCabinetFree($cabinet['cabinet_id'], $_REQUEST['date'], $_REQUEST['num'])) {
		$desc=$cabinet['cab_description'] ? ' ('.$cabinet['cab_description'].')' : '';
		?>
		<p class="cabinet" data-id="<?=$cabinet['cabinet_id']?>" data-name="<?=$cabinet['cabinet_name']?>">
			<?=$cabinet['cabinet_name'].$desc?>				
		</p>
	<?php
	}
}
?>