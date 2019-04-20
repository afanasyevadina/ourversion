<?php
require_once('../connect.php');
require_once('../api/group.php');
$gf=new Group($pdo);
$specializations=$gf->GetSpecializations();
foreach($specializations as $specialization) { ?>
<tr>
	<td><?=$specialization['specialization_name']?></td>
	<td><?=$specialization['code']?></td>
	<td><?=$specialization['courses']?></td>
	<td class="edit" id="<?=$specialization['specialization_id']?>"><img src="img/writing.svg"></td>
</tr>
<?php } ?>