<?php
require_once('../connect.php');
require_once('../api/item.php');
$it=new Item($pdo);
$id=(isset($_GET['teacher']))?$_GET['teacher']:1;
$kurs=(isset($_GET['kurs']))?$_GET['kurs']:'2018-2019';
$items=$it->GetTeacherItems($id, $kurs);
$teacher=''; $totalrup=0; $theory=0; $lpr=0; $totalkurs=0; $theorypd=0; $lprpd=0; 
$week1=0; $hoursperweek1=0; $week2=0; $hoursperweek2=0; $sem1=0; $sem2=0; 
$totalyear=0; $hourxp=0; $res=0;
foreach($items as $item) { 
	$current=substr($item['kurs_num'], 0, 4);
	if($item['base']==9) {
		$kurs=intval($current)-intval($item['year'])+1; 
	}
	else {
		$kurs=intval($current)-intval($item['year'])+2;
	}
	$d=substr($item['group_name'], 0, strlen($item['group_name'])-3).$kurs.substr($item['group_name'], -2);
	$teacher=$item['teacher_name'];
	$totalrup+=intval($item['totalrup']);
	$theorypd+=intval($item['theorypd']);
	$theory+=intval($item['theory']);
	$lpr+=intval($item['lpr']);
	$totalkurs+=intval($item['totalkurs']);
	$lprpd+=intval($item['lprpd']);
	$week1+=intval($item['week1']);
	$hoursperweek1+=intval($item['hoursperweek1']);
	$sem1+=intval($item['week1'])*intval($item['hoursperweek1']);
	$week2+=intval($item['week2']);
	$hoursperweek2+=intval($item['hoursperweek2']);
	$sem2+=intval($item['week2'])*intval($item['hoursperweek2']);
	$totalyear+=intval($item['totalyear']);
	$hourxp+=intval($item['hourxp']);
	$res+=intval($item['totalyear'])-intval($item['hourxp']);
	 ?>
	<tr id="<?=$item['item_id']?>">
		<td><?=$d?></td>
		<td><?=$item['teacher_name']?></td>
		<td><?=$item['subject_name']?></td>
		<td class="exam-td"><?=($item['exam']==0)?'':$item['exam']?></td>
		<td class="zachet-td"><?=($item['zachet']==0)?'':$item['zachet']?></td>
		<td class="kursach-td"><?=($item['kursach']==0)?'':$item['kursach']?></td>
		<td class="control-td"><?=($item['control']==0)?'':$item['control']?></td>
		<td class="totalrup-td"><?=($item['totalrup']==0)?'':$item['totalrup']?></td>
		<td class="theory-td"><?=($item['theory']==0)?'':$item['theory']?></td>
		<td class="lpr-td"><?=($item['lpr']==0)?'':$item['lpr']?></td>
		<td class="totalkurs-td"><?=($item['totalkurs']==0)?'':$item['totalkurs']?></td>
		<td class="sum-td"><?=($item['theorypd']+$item['lprpd']+$item['kurspd']==0)?'':$item['theorypd']+$item['lprpd']+$item['kurspd']?></td>
		<td class="theorypd-td"><?=($item['theorypd']==0)?'':$item['theorypd']?></td>
		<td class="lprpd-td"><?=($item['lprpd']==0)?'':$item['lprpd']?></td>
		<td class="kurspd-td"><?=($item['kurspd']==0)?'':$item['kurspd']?></td>
		<td class="week1-td"><?=($item['week1']==0)?'':$item['week1']?></td>
		<td class="hoursperweek1-td"><?=($item['hoursperweek1']==0)?'':$item['hoursperweek1']?></td>	
		<td class="mul1-td"><?=($item['hoursperweek1']*$item['week1']==0)?'':$item['hoursperweek1']*$item['week1']?></td>
		<td class="week2-td"><?=($item['week2']==0)?'':$item['week2']?></td>
		<td class="hoursperweek2-td"><?=($item['hoursperweek2']==0)?'':$item['hoursperweek2']?></td>
		<td class="mul2-td"><?=($item['hoursperweek2']*$item['week2']==0)?'':$item['hoursperweek2']*$item['week2']?></td>
		<td class="consul-td"><?=($item['consul']==0)?'':$item['consul']?></td>
		<td class="examens-td"><?=($item['examens']==0)?'':$item['examens']?></td>
		<td class="totalyear-td"><?=($item['totalyear']==0)?'':$item['totalyear']?></td>
		<td class="stdxp-td"><?=($item['stdxp']==0)?'':$item['stdxp']?></td>
		<td class="hourxp-td"><?=($item['hourxp']==0)?'':$item['hourxp']?></td>
		<td class="res-td"><?=($item['totalyear']-$item['hourxp']==0)?'':$item['totalyear']-$item['hourxp']?></td>
	</tr>
<?php } ?>
<tr>
	<td></td>
	<td><?=$teacher?></td>
	<td class="itogo-td">Итого</td>
	<td></td>
	<td></td>
	<td></td>
	<td></td>
	<td class="itogo-totalrup-td"><?=$totalrup==0?'':$totalrup?></td>
	<td class="itogo-theory-td"><?=$theory==0?'':$theory?></td>
	<td class="itogo-lpr-td"><?=$lpr==0?'':$lpr?></td>
	<td class="itogo-totalkurs-td"><?=$totalkurs==0?'':$totalkurs?></td>
	<td></td>
	<td class="itogo-theorypd-td"><?=$theorypd==0?'':$theorypd?></td>
	<td class="itogo-lprpd-td"><?=$lprpd==0?'':$lprpd?></td>
	<td></td>
	<td class="itogo-week1-td"><?=$week1==0?'':$week1?></td>
	<td class="itogo-hoursperweek1-td"><?=$hoursperweek1==0?'':$hoursperweek1?></td>
	<td class="itogo-sem1-td"><?=$sem1==0?'':$sem1?></td>
	<td class="itogo-week2-td"><?=$week2==0?'':$week2?></td>
	<td class="itogo-hoursperweek2-td"><?=$hoursperweek2==0?'':$hoursperweek2?></td>
	<td class="itogo-sem2-td"><?=$sem2==0?'':$sem2?></td>
	<td></td>
	<td></td>
	<td class="itogo-totalyear-td"><?=$totalyear==0?'':$totalyear?></td>
	<td></td>
	<td class="itogo-hourxp-td"><?=$hourxp==0?'':$hourxp?></td>
	<td class="itogo-res-td"><?=$res==0?'':$res?></td>
</tr>