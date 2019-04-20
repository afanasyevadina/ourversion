<?php
require_once('../connect.php');
require_once('../api/group.php');
require_once('../api/subject.php');
require_once('../api/general.php');
$gf=new Group($pdo);
$sf=new Subject($pdo);
$genf=new General($pdo);
$id=(isset($_GET['group']))?$_GET['group'] :1;
$group=$gf->About($id);
$types=$sf->GetTypes();
?>
<th><?=($group['s1']==0)?'':$group['s1']?><?=($group['lps']==1)?"+ЛПС":""?></th>
<th><?=($group['s2']==0)?'':$group['s2']?><?=($group['lps']==2)?"+ЛПС":""?></th>
<th><?=($group['s3']==0)?'':$group['s3']?><?=($group['lps']==3)?"+ЛПС":""?></th>
<th><?=($group['s4']==0)?'':$group['s4']?><?=($group['lps']==4)?"+ЛПС":""?></th>
<th><?=($group['s5']==0)?'':$group['s5']?><?=($group['lps']==5)?"+ЛПС":""?></th>
<th><?=($group['s6']==0)?'':$group['s6']?><?=($group['lps']==6)?"+ЛПС":""?></th>
<th><?=($group['s7']==0)?'':$group['s7']?><?=($group['lps']==7)?"+ЛПС":""?></th>
<th><?=($group['s8']==0)?'':$group['s8']?><?=($group['lps']==8)?"+ЛПС":""?></th>
<?php
echo "separator";
$totalitogo=0; $theoryitogo=0; $practiceitogo=0; $projectitogo=0; $s1itogo=0; $s2itogo=0; $s3itogo=0; $s4itogo=0; $s5itogo=0; $s6itogo=0; $s7itogo=0; $s8itogo=0;
foreach($types as $type) {
	$items=$genf->GetByType($id, $type['type_id']);
	$exam=0; $zachet=0; $kursach=0; $control=0; $total=0; $theory=0; $practice=0; $project=0; $s1=0; $s2=0; $s3=0; $s4=0; $s5=0; $s6=0; $s7=0; $s8=0;

	foreach($items as $item) { 
		$exam+=$item['exams']?1:0;
		$zachet+=$item['zachet']?1:0;
		$kursach+=$item['kursach']?1:0;
		$control+=$item['control']==''?0:$item['control'];
	 	$total+=$item['theory']+$item['practice']+$item['project']==0?'':intval($item['theory']+$item['practice']+$item['project']);
		$theory+=$item['theory']==''?:intval($item['theory']);
		$practice+=$item['practice']==''?:intval($item['practice']);
		$project+=$item['project']==''?:intval($item['project']);
		$s1+=$item['s1']==''?:intval($item['s1']);
		$s2+=$item['s2']==''?:intval($item['s2']);
		$s3+=$item['s3']==''?:intval($item['s3']);
		$s4+=$item['s4']==''?:intval($item['s4']);
		$s5+=$item['s5']==''?:intval($item['s5']);
		$s6+=$item['s6']==''?:intval($item['s6']);
		$s7+=$item['s7']==''?:intval($item['s7']);
		$s8+=$item['s8']==''?:intval($item['s8']);
	} ?>
	<tr class="itog" id="part<?=$type['type_id']?>">
		<td><?=$type['short_name']?></td>
		<td><?=$type['type_name']?></td>
		<td><?=$exam==0?'':($exam.'э')?></td>
		<td><?=$zachet==0?'':($zachet.'з')?></td>
		<td><?=$kursach==0?'':($kursach.'к')?></td>
		<td><?=$control==0?'':$control?></td>
		<td><?=$total==0?'':$total?></td>
		<td><?=$theory==0?'':$theory?></td>
		<td><?=$practice==0?'':$practice?></td>
		<td><?=$project==0?'':$project?></td>
		<td><?=$s1==0?'':$s1?></td>
		<td><?=$s2==0?'':$s2?></td>
		<td><?=$s3==0?'':$s3?></td>
		<td><?=$s4==0?'':$s4?></td>
		<td><?=$s5==0?'':$s5?></td>
		<td><?=$s6==0?'':$s6?></td>
		<td><?=$s7==0?'':$s7?></td>
		<td><?=$s8==0?'':$s8?></td>
		<td class="additem_up"><img src="img/add.svg"></td>
	</tr>
	<?php

	foreach($items as $item) {
	 	?>
		<tr id="<?=$item['general_id']?>" data-part="<?=$type['type_id']?>">
			<td class="subject_index"><?=$item['subject_index']?></td>
			<td data-id="<?=$item['subject_id']?>" class="subjectinput"><?=$item['subject_name']?></td>
			<td class="exams-td" contenteditable="true"><?=($item['exams']==0)?'':$item['exams']?></td>
			<td class="zachet-td" contenteditable="true"><?=($item['zachet']==0)?'':$item['zachet']?></td>
			<td class="kursach-td" contenteditable="true"><?=($item['kursach']==0)?'':$item['kursach']?></td>
			<td class="control-td" contenteditable="true"><?=($item['control']==0)?'':$item['control']?></td>
			<td class="total-td"><?=($item['theory']+$item['practice']+$item['project']==0)?'':$item['theory']+$item['practice']+$item['project']?></td>
			<td class="theory-td" contenteditable="true"><?=($item['theory']==0)?'':$item['theory']?></td>
			<td class="practice-td" contenteditable="true"><?=($item['practice']==0)?'':$item['practice']?></td>
			<td class="project-td" contenteditable="true"><?=($item['project']==0)?'':$item['project']?></td>
			<td class="s1-td" contenteditable="true"><?=($item['s1']==0)?'':$item['s1']?></td>
			<td class="s2-td" contenteditable="true"><?=($item['s2']==0)?'':$item['s2']?></td>
			<td class="s3-td" contenteditable="true"><?=($item['s3']==0)?'':$item['s3']?></td>
			<td class="s4-td" contenteditable="true"><?=($item['s4']==0)?'':$item['s4']?></td>
			<td class="s5-td" contenteditable="true"><?=($item['s5']==0)?'':$item['s5']?></td>
			<td class="s6-td" contenteditable="true"><?=($item['s6']==0)?'':$item['s6']?></td>
			<td class="s7-td" contenteditable="true"><?=($item['s7']==0)?'':$item['s7']?></td>
			<td class="s8-td" contenteditable="true"><?=($item['s8']==0)?'':$item['s8']?></td>
			<td class="deleteitem_up"><img src="img/trash.svg"></td>
	</tr><?php } 
	$totalitogo+=$total;
	$theoryitogo+=$theory;
	$practiceitogo+=$practice;
	$projectitogo+=$project;
	$s1itogo+=$s1;
	$s2itogo+=$s2;
	$s3itogo+=$s3;
	$s4itogo+=$s4;
	$s5itogo+=$s5;
	$s6itogo+=$s6;
	$s7itogo+=$s7;
	$s8itogo+=$s8;	
}
?>
<tr>
	<td></td>
	<td>ИТОГО</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td class="itogo-total-td"><?=$totalitogo==0?'':$totalitogo?></td>
	<td class="itogo-theory-td"><?=$theoryitogo==0?'':$theoryitogo?></td>
	<td class="itogo-practice-td"><?=$practiceitogo==0?'':$practiceitogo?></td>
	<td class="itogo-project-td"><?=$projectitogo==0?'':$projectitogo?></td>
	<td class="itogo-s1-td"><?=$s1itogo==0?'':$s1itogo?></td>
	<td class="itogo-s2-td"><?=$s2itogo==0?'':$s2itogo?></td>
	<td class="itogo-s3-td"><?=$s3itogo==0?'':$s3itogo?></td>
	<td class="itogo-s4-td"><?=$s4itogo==0?'':$s4itogo?></td>
	<td class="itogo-s5-td"><?=$s5itogo==0?'':$s5itogo?></td>
	<td class="itogo-s6-td"><?=$s6itogo==0?'':$s6itogo?></td>
	<td class="itogo-s7-td"><?=$s7itogo==0?'':$s7itogo?></td>
	<td class="itogo-s8-td"><?=$s8itogo==0?'':$s8itogo?></td>
</tr>