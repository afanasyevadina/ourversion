<?php
require_once('../connect.php');
require_once('../api/group.php');
require_once('../api/item.php');
$gf=new Group($pdo);
$it=new Item($pdo);

$id=(isset($_GET['group']))?$_GET['group']:1;
$kurs=(isset($_GET['kurs']))?$_GET['kurs']:'2018-2019';
$items=$it->GetGroupItems($id, $kurs);

$group=''; $totalrup=0; $theory=0; $lpr=0; $totalkurs=0; $theoryrup=0; $lprrup=0; $sem1=0; $sem2=0;
$totalyear=0; $hourxp=0; $res=0;
foreach($items as $item) { 
	$d=$gf->GetName($item);
	$totalrup+=intval($item['totalrup']);
	$theoryrup+=intval($item['theorypd']);
	$theory+=intval($item['theory']);
	$lpr+=intval($item['lpr']);
	$totalkurs+=intval($item['totalkurs']);
	$lprrup+=intval($item['lprpd']);
	$totalyear+=intval($item['totalyear']);
	$hourxp+=intval($item['hourxp']);
	$res+=intval($item['totalyear'])-intval($item['hourxp']);
	$sem1+=intval($item['sem1']);
	$sem1+=intval($item['sem2']);
	 ?>
	<tr id="<?=$item['item_id']?>" data-general="<?=$item['general_id']?>">
		<td><?=$d?></td>
		<td <?=$item['subgroup']==0?'':'class="subgroup"'?> ><?=$item['subgroup']==0?'':$item['subgroup']?></td>
		<td class="teacherinput" data-id="<?=$item['teacher_id']?>"><?=$item['teacher_name']?></td>
		<td><?=$item['subject_name']?></td>
		<td class="exam-td" contenteditable="true"><?=($item['exam']==0)?'':$item['exam']?></td>
		<td class="zachet-td" contenteditable="true"><?=($item['zachet']==0)?'':$item['zachet']?></td>
		<td class="kursach-td" contenteditable="true"><?=($item['kursach']==0)?'':$item['kursach']?></td>
		<td class="control-td" contenteditable="true"><?=($item['control']==0)?'':$item['control']?></td>
		<td class="totalrup-td" contenteditable="true"><?=($item['totalrup']==0)?'':$item['totalrup']?></td>
		<td class="theoryrup-td"><?=($item['theoryrup']==0)?'':$item['theoryrup']?></td>
		<td class="lprrup-td" contenteditable="true"><?=($item['lprrup']==0)?'':$item['lprrup']?></td>
		<td class="totalkurs-td" contenteditable="true"><?=($item['totalkurs']==0)?'':$item['totalkurs']?></td>
		<td class="pd-td" contenteditable="true"><?=($item['pd']==0)?'':$item['pd']?></td>
		<td class="theory-td"><?=($item['theory']==0)?'':$item['theory']?></td>
		<td class="lpr-td" contenteditable="true"><?=($item['lpr']==0)?'':$item['lpr']?></td>
		<td class="kurs-td" contenteditable="true"><?=($item['kurs']==0)?'':$item['kurs']?></td>
		<td class="week1-td" contenteditable="true"><?=($item['week1']==0)?'':$item['week1']?></td>
		<td class="hoursperweek1-td"><?=(($item['week1']==0?0:floor($item['sem1']/$item['week1']))==0)?'':floor($item['sem1']/$item['week1'])?></td>	
		<td class="sem1-td" contenteditable="true"><?=($item['sem1']==0)?'':$item['sem1']?></td>
		<td class="week2-td" contenteditable="true"><?=($item['week2']==0)?'':$item['week2']?></td>
		<td class="hoursperweek2-td"><?=(($item['week2']==0?0:floor($item['sem2']/$item['week2']))==0)?'':floor($item['sem2']/$item['week2'])?></td>	
		<td class="sem2-td" contenteditable="true"><?=($item['sem2']==0)?'':$item['sem2']?></td>
		<td class="consul-td" contenteditable="true"><?=($item['consul']==0)?'':$item['consul']?></td>
		<td class="examens-td" contenteditable="true"><?=($item['examens']==0)?'':$item['examens']?></td>
		<td class="totalyear-td" contenteditable="true"><?=($item['totalyear']==0)?'':$item['totalyear']?></td>
		<td class="stdxp-td" contenteditable="true"><?=($item['stdxp']==0)?'':$item['stdxp']?></td>
		<td class="hourxp-td" contenteditable="true"><?=($item['hourxp']==0)?'':$item['hourxp']?></td>
		<td class="res-td"><?=($item['totalyear']-$item['hourxp']==0)?'':$item['totalyear']-$item['hourxp']?></td>
	</tr>
<?php } ?>
<tr>
	<td><?=$group?></td>
	<td></td>
	<td></td>
	<td class="itogo-td">Итого</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td class="itogo-totalrup-td"><?=$totalrup==0?'':$totalrup?></td>
	<td class="itogo-theoryrup-td"><?=$theoryrup==0?'':$theoryrup?></td>
	<td class="itogo-lprrup-td"><?=$lprrup==0?'':$lprrup?></td>
	<td class="itogo-totalkurs-td"><?=$totalkurs==0?'':$totalkurs?></td>
	<td></td>
	<td class="itogo-theory-td"><?=$theory==0?'':$theory?></td>
	<td class="itogo-lpr-td"><?=$lpr==0?'':$lpr?></td>
	<td></td>
	<td></td>
	<td></td>
	<td class="itogo-sem1-td"><?=$sem1==0?'':$sem1?></td>
	<td></td>
	<td></td>
	<td class="itogo-sem2-td"><?=$sem2==0?'':$sem2?></td>
	<td></td>
	<td></td>
	<td class="itogo-totalyear-td"><?=$totalyear==0?'':$totalyear?></td>
	<td></td>
	<td class="itogo-hourxp-td"><?=$hourxp==0?'':$hourxp?></td>
	<td class="itogo-res-td"><?=$res==0?'':$res?></td>
</tr>