<?php
require_once('../connect.php');
require_once('../api/ktp.php');
require_once('../api/group.php');
$ktpf=new Ktp($pdo);
$gf=new Group($pdo);
/*if($user['account_type']=='teacher') {
	$items=$ktpf->GetTeacherKtps($user['person_id'], $_REQUEST['group'], $_REQUEST['subject']);
}
else {*/
	$items=$ktpf->GetKtps($_REQUEST['group'], $_REQUEST['subject']);
//}
foreach ($items as $item) { ?>
	<p><a class="listitem" href="ktp.php?id=<?=$item['ktp_id']?>"><?=$item['subject_name']?> <?=$gf->GetName($item)?>, <?=$item['teacher_name']?></p>
<?php } ?>