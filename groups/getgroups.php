<?php
require_once('../connect.php');
require_once('../api/group.php');
$gf=new Group($pdo);
$list=$gf->GetGroups();
$langs = ['Русский', 'Казахский'];
foreach($list as $group) { ?>
	<tr>
		<td class="name"><?=$group['group_name']?></td>
		<td><?=$group['base']?></td>
		<td><?=$langs[$group['lang']]?></td>
		<td class="edit" id="<?=$group['group_id']?>"><img src="img/writing.svg"></td>
	</tr>
<?php } ?>