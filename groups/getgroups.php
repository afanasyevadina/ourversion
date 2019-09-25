<?php
require_once('../connect.php');
require_once('../api/group.php');
$gf=new Group($pdo);
$list=$gf->GetFull();
$langs = ['Русский', 'Казахский'];
foreach($list as $group) { ?>
	<tr class="searchable">
		<td class="name"><?=$group['group_name']?></td>
		<td><?=$group['base']?></td>
		<td><?=$langs[$group['lang']]?></td>
		<td><?=$group['teacher_name']?></td>
		<td class="edit" id="<?=$group['group_id']?>"><img src="img/writing.svg"></td>
	</tr>
<?php } ?>