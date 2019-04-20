<?php
require_once('../connect.php');
require_once('../api/group.php');
require_once('../api/subject.php');
require_once('../api/general.php');
require_once('../api/clear.php');
require_once('../api/ruprogram.php');
require_once('../api/item.php');
$gf=new Group($pdo);
$sf=new Subject($pdo);
$genf=new General($pdo);
$clear=new Clear($pdo);
$rup=new Ruprogram($pdo);
$it=new Item($pdo);

if(isset($_GET['group'])) {
	$clear->ClearGroupItems($_GET['group']);
	$items=$genf->GetGeneral($_GET['group']);
	$types=$sf->GetSubjects();
	$group=$gf->About($_GET['group']);
	$kurs1=[]; $kurs2=[]; $kurs3=[]; $kurs4=[];
	$ready=[];
	$count=0;
	foreach ($items as $key => $item) {
		$div=0;
		foreach ($types as $key => $subject) {
			if($subject['subject_id']==$item['subject_id']) {
				$div=$subject['divide'];
			}
		}
		$temp1=[]; $temp2=[]; $temp3=[]; $temp4=[];
		$temp=$it->CreateTemp($item, $_GET['group']);

		if(intval($item['s1']>0)||intval($item['s2'])>0) {
			$temp1=array_merge($temp1, $it->CreateKurs($item, $temp, $group, 1));
			if(intval($group['count'])>24&&$div==1) {
				$temp1['subgroup']=1;
				$add=$it->CreateAdditional($item, $temp1);
				$ready=array_merge($ready, array_values($add));
				$count++;
			}
			$ready=array_merge($ready, array_values($temp1));
			$count++;
		}
		if(intval($item['s3']>0)||intval($item['s4'])>0) {
			$temp2=array_merge($temp2, $it->CreateKurs($item, $temp, $group, 2));
			if(intval($group['count'])>24&&$div==1) {
				$temp2['subgroup']=1;
				$add=$it->CreateAdditional($item, $temp2);
				$ready=array_merge($ready, array_values($add));
				$count++;
			}
			$ready=array_merge($ready, array_values($temp2));
			$count++;
		}
		if(intval($item['s5']>0)||intval($item['s6'])>0) {
			$temp3=array_merge($temp3, $it->CreateKurs($item, $temp, $group, 3));

			if(intval($group['count'])>24&&$div==1) {
				$temp3['subgroup']=1;
				$add=$it->CreateAdditional($item, $temp3);
				$ready=array_merge($ready, array_values($add));
				$count++;
			}
			$ready=array_merge($ready, array_values($temp3));
			$count++;
		}
		if(intval($item['s7']>0)||intval($item['s8'])>0) {
			$temp4=array_merge($temp4, $it->CreateKurs($item, $temp, $group, 4));

			if(intval($group['count'])>24&&$div==1) {
				$temp4['subgroup']=1;
				$add=$it->CreateAdditional($item, $temp4);
				$ready=array_merge($ready, array_values($add));
				$count++;
			}
			$ready=array_merge($ready, array_values($temp4));
			$count++;
		}
		// заодно и РУПы можно сделать
		$clear->ClearRup($item['general_id']);
		$rup->Insert($item['general_id']);
	}
	if($count>0) {
		$result=$it->Insert($ready, $count);
		if($result) header('Location: /rup.php');
	}
}