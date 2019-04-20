<?php
require_once('../connect.php');
require_once('../api/group.php');
require_once('../api/subjects.php');
require_once('../api/general.php');
$gf=new Group($pdo);
$sf=new Subject($pdo);
$genf=new General($pdo);
if(!empty($_POST)) {
	$id=substr($_POST['id'], 4);
	$lastid=$genf->AddItem($_POST['group']);
	$subjects=$gf->GetByType($id);	
	$type_name=$sf->GetType($id)['short_name'];
	?>
	<tr id="<?=$lastid?>" data-part="<?=$id?>">
			<td class="subject_index"><?=$type_name?></td>
			<td class="subjectinput">
				<input type="text" list="subjects">
				<datalist id="subjects">
				<?php
					foreach($subjects as $subject) { ?>
						<option data-index="<?=$subject['subject_index']?>" data-id="<?=$subject['subject_id']?>"><?=$subject['subject_name']?></option>
					<?php }
				?>
				</datalist>
			</td>
			<td class="exams-td" contenteditable="true"></td>
			<td class="zachet-td" contenteditable="true"></td>
			<td class="kursach-td" contenteditable="true"></td>
			<td class="control-td" contenteditable="true"></td>
			<td class="total-td"></td>
			<td class="theory-td" contenteditable="true"></td>
			<td class="practice-td" contenteditable="true"></td>
			<td class="project-td" contenteditable="true"></td>
			<td class="s1-td" contenteditable="true"></td>
			<td class="s2-td" contenteditable="true"></td>
			<td class="s3-td" contenteditable="true"></td>
			<td class="s4-td" contenteditable="true"></td>
			<td class="s5-td" contenteditable="true"></td>
			<td class="s6-td" contenteditable="true"></td>
			<td class="s7-td" contenteditable="true"></td>
			<td class="s8-td" contenteditable="true"></td>
			<td class="deleteitem_up"><img src="img/trash.png"></td>
	</tr>
<?php }
?>