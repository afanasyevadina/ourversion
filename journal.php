<?php
$title = 'Журнал';
require_once('layout.php');
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
require_once 'api/item.php';
require_once 'api/group.php';
require_once 'api/journal.php';
require_once 'api/subject.php';
$if = new Item($pdo);
$gf = new Group($pdo);
$jf = new Journal($pdo);
$item=$if->About($_GET['id']);
$students=$gf->GetStudents($item['group_id'], ($item['divide'] != Subject::DIV_PRAC) ? $item['subgroup']: 0);
$lessons=$jf->GetLessons($_GET['id']);
$journal = [];
foreach($students as $student) {
	$ratings = $jf->GetJournal($_GET['id'], $student['student_id']);
	if(empty($ratings)) $jf->CreateJournal($lessons, $student['student_id']);
	$ratings = $jf->GetJournal($_GET['id'], $student['student_id']);
	$journal[$student['student_id']] = $ratings;
}

?>
	<div class="container">		
		<div class="main">
			<h2>Журнал <?=$item['subject_name']?></h2>
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
						<?php foreach($students as $student) { ?>
							<tr>
								<td><?=$student['student_name']?></td>
								<?php
								foreach($journal[$student['student_id']] as $rating) { ?>
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