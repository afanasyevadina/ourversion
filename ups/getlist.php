<?php
require_once('../connect.php');
require_once('../api/subject.php');
$sf=new Subject($pdo);
if(!empty($_POST)) {
	$subjects=$sf->GetByType($_POST['id']);
	?>
	<input type="text" list="subjects" value="<?=$_POST['old']?>">
	<datalist id="subjects">
	<?php
		foreach($subjects as $subject) { ?>
			<option data-index="<?=$subject['subject_index']?>" data-id="<?=$subject['subject_id']?>"><?=$subject['subject_name']?></option>
		<?php }
	?>
	</datalist>
<?php }
?>