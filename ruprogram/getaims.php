<?php
require_once('../connect.php');
require_once('../api/ruprogram.php');
$rf=new Ruprogram($pdo);
$items=$rf->GetParts($_POST['id']);
foreach($items as $item) { ?>
	<tr data-part="<?=$item['part_id']?>">
		<td class="aimnum"><?=$item['part_num']?></td>
		<td><?=$item['hours']==0?'':$item['hours']?></td>
		<td><?=$item['part_name']?></td>
		<td contenteditable="true"><?=$item['imagine']?></td>
		<td contenteditable="true"><?=$item['know']?></td>
		<td contenteditable="true"><?=$item['can']?></td>
		<td contenteditable="true"><?=$item['skills']?></td>
		<td contenteditable="true"><?=$item['complex']?></td>
	</tr>
<?php } ?>