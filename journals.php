<?php
require_once('facecontrol.php');
if($user['account_type']=='teacher') {
	$res=$pdo->prepare("SELECT `ktps`.`ktp_id`, `subjects`.`subject_name`, `groups`.`group_name`, `teachers`.`teacher_name`, `items`.`kurs_num`, `groups`.`year`, `groups`.`base` FROM `ktps` INNER JOIN `items` ON `ktps`.`item_id`=`items`.`item_id` INNER JOIN `subjects` ON `items`.`subject_id`=`subjects`.`subject_id` INNER JOIN `teachers` ON `items`.`teacher_id`=`teachers`.`teacher_id` INNER JOIN `groups` ON `items`.`group_id`=`groups`.`group_id` INNER JOIN `specializations` ON `groups`.`specialization_id`=`specializations`.`specialization_id` WHERE `items`.`teacher_id`=?");
	$res->execute(array($user['person_id']));
}
if($user['account_type']=='admin') {
	$res=$pdo->query("SELECT `ktps`.`ktp_id`, `subjects`.`subject_name`, `groups`.`group_name`, `teachers`.`teacher_name`, `items`.`kurs_num`, `groups`.`year`, `groups`.`base` FROM `ktps` INNER JOIN `items` ON `ktps`.`item_id`=`items`.`item_id` INNER JOIN `subjects` ON `items`.`subject_id`=`subjects`.`subject_id` INNER JOIN `teachers` ON `items`.`teacher_id`=`teachers`.`teacher_id` INNER JOIN `groups` ON `items`.`group_id`=`groups`.`group_id` INNER JOIN `specializations` ON `groups`.`specialization_id`=`specializations`.`specialization_id`");
}
$items=$res->fetchAll();
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
			<?php
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
				<p><a class="listitem" href="journal.php?id=<?=$item['ktp_id']?>"><?=$item['subject_name']?> <?=$d?>, <?=$item['teacher_name']?></p>
			<?php } ?>
		</div>
	</div>
	<footer></footer>
</body>
</html>