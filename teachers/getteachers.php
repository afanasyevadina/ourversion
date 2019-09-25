<?php
require_once('../connect.php');
require_once('../api/group.php');
$sf=new Group($pdo);
$teachers=$sf->GetTeachers();
foreach($teachers as $teacher) { ?>
<tr class="searchable">
	<td>
		<label class="check_label">
			<input type="checkbox" form="loginform" name="name[]" value="<?=$teacher['teacher_id']?>">
		</label>
	</td>
	<td><?=$teacher['teacher_name']?></td>
	<td><?=$teacher['cmk_name']?></td>
	<td id="<?=$teacher['teacher_id']?>" class='edit'><img src='img/writing.svg'></td>
</tr>
<?php }