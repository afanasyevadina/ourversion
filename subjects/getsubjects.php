<?php
require_once('../connect.php');
require_once('../api/subject.php');
$sf=new Subject($pdo);
$subjects=$sf->GetSubjects();
$div = ['Никогда', 'Всегда', 'На практические занятия', 'Всегда в группах с русским языком обучения', 'Всегда в группах с казахским языком обучения'];
foreach($subjects as $subject) { ?>
	<tr>
		<td><?=$subject['subject_index']?></td>
		<td><?=$subject['subject_name']?></td>
		<td><?=$subject['type_name']?></td>
		<td><?=$subject['cmk_name']?></td>
		<td><?=$div[$subject['divide']]?></td>
		<td class="edit" id="<?=$subject['subject_id']?>"><img src="img/writing.svg"></td>
	</tr>
<?php } ?>