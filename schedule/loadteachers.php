<?php
require_once('../connect.php');
require_once('../api/group.php');
require_once('../api/schedule.php');
$gf=new Group($pdo);
$sf=new Schedule($pdo, '../config.json');
$teachers=$gf->GetTeachers();
foreach ($teachers as $teacher) {
	if($sf->IsTeacherFree($teacher['teacher_id'], $_REQUEST['date'], $_REQUEST['num'])) {
		?>
		<p class="teacher" data-id="<?=$teacher['teacher_id']?>" data-name="<?=$teacher['teacher_name']?>">
			<?=$teacher['teacher_name']?>				
		</p>
	<?php
	}
}
?>