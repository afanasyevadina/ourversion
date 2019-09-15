<?php
require_once('../connect.php');
require_once('../api/journal.php');
require_once('../api/group.php');
$jf=new Journal($pdo);
$gf=new Group($pdo);
//if($user['account_type']=='teacher') {
	$items=$jf->GetJournals($user['person_id'], $_REQUEST['kurs']);
//}
foreach ($items as $item) {
				$d=$gf->GetName($item);
				?>
				<p><a class="listitem" href="journal.php?id=<?=$item['ktp_id']?>"><?=$item['subject_name']?> <?=$d?>, <?=$item['teacher_name']?></p>
			<?php } ?>