<?php 
require_once('../connect.php');
require_once('../api/ruprogram.php');
$rf=new Ruprogram($pdo);
$items=$rf->GetLpr($_POST['id']);
$contenteditable = $user['account_type'] == 'admin' ||
($user['account_type'] == 'teacher' && in_array($user['person_id'], array_column($items, 'teacher_id'))) ?
'contenteditable="true"' : '';
foreach($items as $item) { ?>
	<tr data-id="<?=$item['rupitem_id']?>">
		<td><b>№<?=$item['rupitem_num']?></b> <?=$item['rupitem_name']?></td>
		<td><?=$item['item_practice']?></td>
		<td <?=$contenteditable?> class="content"><?=$item['content']?></td>
	</tr>
<?php } ?>