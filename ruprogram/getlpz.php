<?php 
require_once('../connect.php');
require_once('../api/ruprogram.php');
$rf=new Ruprogram($pdo);
$items=$rf->GetLpr($_POST['id']);
foreach($items as $item) { ?>
	<tr data-id="<?=$item['rupitem_id']?>">
		<td><b>№<?=$item['rupitem_num']?></b> <?=$item['rupitem_name']?></td>
		<td><?=$item['item_practice']?></td>
		<td contenteditable="true" class="content"><?=$item['content']?></td>
	</tr>
<?php } ?>