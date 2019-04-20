<?php
require_once('../facecontrol.php');
require_once('../api/group.php');
$gf=new Group($pdo);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
if($user['account_type']!='admin') {
	header('Location: /');
}
$students=$gf->GetStudents($_REQUEST['group']);
foreach($students as $student) { ?>
	<tr>
		<td>
			<label class="check_label">
				<input type="checkbox" form="loginform" name="name[]" value="<?=$student['student_id']?>">
			</label>
		</td>
		<td><?=$student['student_name']?></td>
		<td><?=$student['group_name']?></td>
		<td id="<?=$student['student_id']?>" class="edit"><img src="img/writing.svg"></td>
	</tr>
<?php } ?>