<?php
require_once('facecontrol.php');
if($user['account_type']!='teacher') {
	//header('Location: /');
}
$itemres=$pdo->prepare("SELECT `items`.`group_id`, `items`.`teacher_id`, `items`.`item_id` FROM `ktps` INNER JOIN `items` ON `ktps`.`item_id`=`items`.`item_id` AND `ktps`.`ktp_id`=?");
$itemres->execute(array($_GET['id']));
$item=$itemres->fetch();
$students=$pdo->prepare("SELECT * FROM `students` WHERE `students`.`group_id`=?");
$students->execute(array($item['group_id']));
$lessonres=$pdo->prepare("SELECT `lessons`.`lesson_date`, `rupitems`.`item_practice` FROM `lessons` INNER JOIN `rupitems` ON `rupitems`.`rupitem_id`=`lessons`.`rupitem_id` WHERE `lessons`.`item_id`=? GROUP BY `rupitems`.`rupitem_num`");
$lessonres->execute(array($item['item_id']));
$lessons=$lessonres->fetchAll();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Журнал</title>
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
			<h2>Журнал</h2>
			<div class="links">
				<a href="#" class="save" id="savejournal">Сохранить</a>
			</div>
			<div id="success" class="success">
				<h3>Изменения сохранены.</h3>
			</div>
			<div id="error" class="error">
				<h3>Ошибка! Изменения не сохранены.</h3>
			</div>
			<div class="table_resp">
				<table id="groups" border="1" class="journal">
					<thead id="headgroup">
						<tr>
							<th>ФИО</th>
							<?php
							foreach ($lessons as $lesson) { ?>
								<th class="date"><?=$lesson['lesson_date']?date('d.m', strtotime($lesson['lesson_date'])):''?></th>
							<?php } ?>
						</tr>
					</thead>
					<tbody>
						<?php while ($student=$students->fetch()) { ?>
							<tr>
								<td><?=$student['student_name']?></td>
								<?php
								$ratings=$pdo->prepare("SELECT * FROM `ratings` INNER JOIN `lessons` ON `ratings`.`lesson_id`=`lessons`.`lesson_id` WHERE `ratings`.`student_id`=? AND `lessons`.`item_id`=?");
								$ratings->execute(array($student['student_id'], $item['item_id']));
								while ($rating=$ratings->fetch()) { ?>
									<td contenteditable="<?=$rating['lesson_date']?'true':'false'?>" id="<?=$rating['rating_id']?>"><?=$rating['rating_value']?></td>
								<?php } ?>
							</tr>
							<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<footer></footer>
	<script type="text/javascript">		
		$('body').on('focus', '[contenteditable]', function() {
	        const $this = $(this);
	        $this.data('before', $this.html());
		}).on('blur keyup paste input', '[contenteditable]', function() {
			const $this = $(this);
			if($this.html()!=''&&$this.html()!='1'&&$this.html()!='2'&&$this.html()!='3'&&$this.html()!='4'&&$this.html()!='5') {
				$this.css('background-color', '#ECB7B7');
				$this.css('color', '#400000');
			}
			else {
				$this.css('background-color', '#fff');
				$this.css('color', '#000');
			}
			if ($this.data('before') !== $this.html()) {
			    $(this).data('before', $this.html());
			    $(this).attr('class', 'edited');
			}
		});
		$('#savejournal').click(function(){
			var res=[];
			$('tbody').find('td.edited').each(function(i){
				var temp=[];
				temp.push($(this).html());
				temp.push($(this).attr('id'));
				res.push(temp);
			});
			$.ajax({
				url: 'journal/savejournal.php',
				method: 'POST',
				dataType: 'html',
				data: 'data='+JSON.stringify(res),
				success: function(response) {
					$('td.edited').removeClass('edited');
					$('#success').css('display', 'block');
					setTimeout(function(){
						$('#success').css('display', 'none');
					}, 2000);
				},
				error: function(){
					$('#error').css('display', 'block');
					setTimeout(function(){
						$('#error').css('display', 'none');
					}, 2000);
				}
			});
		});
	</script>
</body>
</html>