<?php
require_once('../facecontrol.php');
require_once('../api/ktp.php');
$ktpf=new Ktp($pdo);
if($user['account_type']=='teacher') {
	$items=$ktpf->GetTeacherKtps($user['person_id'], $_REQUEST['group'], $_REQUEST['subject']);
}
else {
	$items=$ktpf->GetKtps($_REQUEST['group'], $_REQUEST['subject']);
}
foreach ($items as $item) { 
	$current=substr($item['kurs_num'], 0, 4);
	if($items[0]['base']==9) {
		$kurs=intval($current)-intval($item['year'])+1; 
	}
	else {
		$kurs=intval($current)-intval($item['year'])+2;
	}
	$d=substr($item['group_name'], 0, strlen($item['group_name'])-3).$kurs.substr($item['group_name'], -2);
	?>
	<p><a class="listitem" href="ktp.php?id=<?=$item['ktp_id']?>"><?=$item['subject_name']?> <?=$d?>, <?=$item['teacher_name']?></p>
<?php } ?>