<?php
require_once('../facecontrol.php');
require_once('../api/journal.php');
$jf=new Journal($pdo);
$student=$user['person_id'];
$sem=$_REQUEST['sem'];
$kurs=$_REQUEST['kurs'];
$subjects=$jf->StudentSubjects($student, $kurs, $sem);
foreach ($subjects as $subject) {
	$rat=$jf->GetRating($student, $subject['item_id'], $sem); ?>
	<tr>
		<td><?=$subject['subject_name']?></td>
		<td><?=$rat['avg']?></td>
		<td><?=$rat['exam']?></td>
	</tr>
<?php } ?>
