<?php
$title = 'Средний балл';
require_once('layout.php');
require_once 'api/journal.php';
$jf = new Journal($pdo);
$exams = $jf->GetExams($user['person_id']); ?>
	<div class="container">
		
		<div class="main">
			<h2>Мои экзамены в этом году</h2>
			
			<table border="1">
				<thead>
					<thead>
						<th>Предмет</th>
						<th>Преподаватель</th>
						<th>Семестр</th>
					</thead>
				</thead>
				<tbody>
					<?php foreach($exams as $exam) { ?>
						<tr>
							<td><?=$exam['subject_name']?></td>
							<td><?=$exam['teacher_name']?></td>
							<td><?=$exam['exam'] % 2 ? 1 : 2?></td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
	<footer></footer>
</body>
</html>