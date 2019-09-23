<?php
require_once('../connect.php');
require_once('../api/group.php');
require_once('../api/item.php');
require_once('../api/subject.php');
$gf=new Group($pdo);
$it=new Item($pdo);

$id=(isset($_GET['group']))?$_GET['group']:1;
$kurs=(isset($_GET['kurs']))?$_GET['kurs']:'2018-2019';
$items=$it->GetGroupItems($id, $kurs);

$contenteditable = $user['account_type'] == 'admin' ? 'contenteditable="true"' : '';

$group=''; $totalrup=0; $theory=0; $lpr=0; $totalkurs=0; $theoryrup=0; $lprrup=0; $sem1=0; $sem2=0; $examens=0; $consul=0;
$totalyear=0; $hourxp=0; $stdxp=0; $res=0;
foreach($items as $item) { 
	$item['examens'] = $item['examens'] ? $item['examens'] : ($item['exam'] ? 2 : 0);
	$d=$gf->GetName($item);
	$totalrup+=intval($item['totalrup']);
	$theoryrup+=intval($item['theoryrup']);
	$theory+=intval($item['theory']);
	$lpr+=intval($item['lpr']);
	$totalkurs+=intval($item['totalkurs']);
	$lprrup+=intval($item['lprrup']);
	$totalyear+=intval($item['sem1']+$item['sem2']+$item['examens']+$item['consul']);
	$hourxp+=intval($item['hourxp']);
	$stdxp+=intval($item['stdxp']);
	$res+=intval($item['sem1']+$item['sem2']+$item['examens']+$item['consul']-$item['hourxp']);
	$sem1+=intval($item['sem1']);
	$sem1+=intval($item['sem2']);
	$examens+=intval($item['examens']);
	$consul+=intval($item['consul']);
	 ?>
	<tr id="<?=$item['item_id']?>" data-general="<?=$item['general_id']?>">
		<td><?=$d?></td>
		<td <?=$item['subgroup']==0 || $item['divide']==Subject::DIV_PRAC?'':'class="subgroup"'?> >
			<?=$item['subgroup']==0?'':$item['subgroup']?></td>
		<td class="teacherinput" data-id="<?=$item['teacher_id']?>"><?=$item['teacher_name']?></td>
		<td><?=$item['subject_name']?></td>
		<td class="exam-td" <?=$contenteditable?>><?=($item['exam']==0)?'':$item['exam']?></td>
		<td class="zachet-td" <?=$contenteditable?>><?=($item['zachet']==0)?'':$item['zachet']?></td>
		<td class="kursach-td" <?=$contenteditable?>><?=($item['kursach']==0)?'':$item['kursach']?></td>
		<td class="control-td" <?=$contenteditable?>><?=($item['control']==0)?'':$item['control']?></td>
		<td class="totalrup-td" <?=$contenteditable?>><?=($item['totalrup']==0)?'':$item['totalrup']?></td>
		<td class="theoryrup-td"><?=($item['theoryrup']==0)?'':$item['theoryrup']?></td>
		<td class="lprrup-td" <?=$contenteditable?>><?=($item['lprrup']==0)?'':$item['lprrup']?></td>
		<td class="totalkurs-td" <?=$contenteditable?>><?=($item['totalkurs']==0)?'':$item['totalkurs']?></td>
		<td class="pd-td" <?=$contenteditable?>><?=($item['pd']==0)?'':$item['pd']?></td>
		<td class="theory-td"><?=($item['theory']==0)?'':$item['theory']?></td>
		<td class="lpr-td" <?=$contenteditable?>><?=($item['lpr']==0)?'':$item['lpr']?></td>
		<td class="kurs-td" <?=$contenteditable?>><?=($item['kurs']==0)?'':$item['kurs']?></td>
		<td class="week1-td" <?=$contenteditable?>><?=($item['week1']==0)?'':$item['week1']?></td>
		<td class="hoursperweek1-td"><?=(($item['week1']==0?0:floor($item['sem1']/$item['week1']))==0)?'':floor($item['sem1']/$item['week1'])?></td>	
		<td class="sem1-td" <?=$contenteditable?>><?=($item['sem1']==0)?'':$item['sem1']?></td>
		<td class="week2-td" <?=$contenteditable?>><?=($item['week2']==0)?'':$item['week2']?></td>
		<td class="hoursperweek2-td"><?=(($item['week2']==0?0:floor($item['sem2']/$item['week2']))==0)?'':floor($item['sem2']/$item['week2'])?></td>	
		<td class="sem2-td" <?=$contenteditable?>><?=($item['sem2']==0)?'':$item['sem2']?></td>
		<td class="consul-td" <?=$contenteditable?>><?=($item['consul']==0)?'':$item['consul']?></td>
		<td class="examens-td" <?=$contenteditable?>><?=($item['examens']==0)?'':$item['examens']?></td>
		<td class="totalyear-td" <?=$contenteditable?>><?=$item['sem1']+$item['sem2']+$item['examens']+$item['consul']?></td>
		<td class="stdxp-td" <?=$contenteditable?>><?=($item['stdxp']==0)?'':$item['stdxp']?></td>
		<td class="hourxp-td" <?=$contenteditable?>><?=($item['hourxp']==0)?'':$item['hourxp']?></td>
		<td class="res-td"><?=$item['sem1']+$item['sem2']+$item['examens']+$item['consul']-$item['hourxp']?></td>
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
	<td class="itogo-consul-td"><?=$consul==0?'':$consul?></td>
	<td class="itogo-examens-td"><?=$examens==0?'':$examens?></td>
	<td class="itogo-totalyear-td"><?=$totalyear==0?'':$totalyear?></td>
	<td class="itogo-stdxp-td"><?=$stdxp==0?'':$stdxp?></td>
	<td class="itogo-hourxp-td"><?=$hourxp==0?'':$hourxp?></td>
	<td class="itogo-res-td"><?=$res==0?'':$res?></td>
</tr>