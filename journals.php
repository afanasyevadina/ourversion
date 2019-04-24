<?php
require_once('facecontrol.php');
require_once('../api/journal.php');
require_once('../api/group.php');
$jf=new Journal($pdo);
$gf=new Group($pdo);
if($user['account_type']=='teacher') {
	$items=$jf->GetJournals($user['person_id'], $_REQUEST['kurs']);
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Журналы</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/jquery.form.min.js"></script>
	<script src="js/script.js"></script>
</head>
<body>
	<?php require_once('layout.php'); ?>
	<div class="container">
		<div class="main">
			<h2>Журналы</h2>
			<select class="filter" id="courses">
				<option>2019-2020</option>
				<option>2018-2019</option>
				<option>2017-2018</option>
				<option>2016-2017</option>
				<option>2015-2016</option>
			</select>
			<?php
			foreach ($items as $item) {
				$d=$gf->GetName($item);
				?>
				<p><a class="listitem" href="journal.php?id=<?=$item['ktp_id']?>"><?=$item['subject_name']?> <?=$d?>, <?=$item['teacher_name']?></p>
			<?php } ?>
		</div>
	</div>
	<footer></footer>
</body>
</html>