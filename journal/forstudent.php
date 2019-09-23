<?php
require_once('../connect.php');
require_once('../api/journal.php');
$jf=new Journal($pdo);
$student=$_REQUEST['student'];
$sem=$_REQUEST['sem'];
$kurs=$_REQUEST['kurs'];
$subjects=$jf->StudentSubjects($student, $kurs, $sem);
foreach ($subjects as $subject) {
	$rat=$jf->GetRating($student, $subject['item_id'], $sem); ?>
	<tr>
		<td><?=$subject['subject_name']?></td>
		<td><?=$rat['avg'] ? round($rat['avg'], 2) : ''?></td>
		<td><?=$rat['exam'] ? round($rat['exam'], 2) : ''?></td>
	</tr>
<?php } ?>
