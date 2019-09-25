<?php
require_once('../connect.php');
require_once('../api/group.php');
$config=json_decode(file_get_contents('../config.json'), true);
$gf=new Group($pdo);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
$students=$gf->GetStudents($_REQUEST['group'], $_REQUEST['subgroup']);
$i=0;
echo $gf->StudentsCount($_REQUEST['group']) >= $config['students_count'];
echo "endcount";
foreach($students as $student) { ?>
	<tr class="searchable">
		<td>
			<label class="check_label">
				<input type="checkbox" form="loginform" name="name[]" value="<?=$student['student_id']?>">
			</label>
		</td>
		<td><?=++$i?></td>
		<td><?=$student['student_name']?></td>
		<td><?=$student['group_name']?></td>
		<td id="<?=$student['student_id']?>" class="edit"><img src="img/writing.svg"></td>
	</tr>
<?php } ?>