<?php
require_once('../facecontrol.php');
require_once('../api/ruprogram.php');
$rf=new Ruprogram($pdo);
$items=$rf->GetParts($_POST['id']);
$contenteditable = $user['account_type'] == 'admin' ||
($user['account_type'] == 'teacher' && in_array($user['person_id'], array_column($items, 'teacher_id'))) ?
'contenteditable="true"' : '';
foreach($items as $item) { ?>
	<tr data-part="<?=$item['part_id']?>">
		<td class="aimnum"><?=$item['part_num']?></td>
		<td><?=$item['hours']==0?'':$item['hours']?></td>
		<td><?=$item['part_name']?></td>
		<td <?=$contenteditable?>><?=$item['imagine']?></td>
		<td <?=$contenteditable?>><?=$item['know']?></td>
		<td <?=$contenteditable?>><?=$item['can']?></td>
		<td <?=$contenteditable?>><?=$item['skills']?></td>
		<td <?=$contenteditable?>><?=$item['complex']?></td>
	</tr>
<?php } ?>