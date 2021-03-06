<?php
/**
 * 
 */
class Item
{
	private $pdo;
	
	function __construct($pdo)
	{
		$this->pdo=$pdo;
	}

	public function Insert($data, $count) {
		$insert="INSERT INTO `items` (`general_id`, `group_id`, `subject_id`, `exam`, `zachet`, `kursach`, `control`, `totalrup`, `theoryrup`, `lprrup`, `subgroup`, `totalkurs`, `theory`, `lpr`, `kurs`, `week1`, `sem1`, `week2`, `sem2`, `kurs_num`) VALUES ".str_repeat("(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?),", $count-1)."(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		$result=$this->pdo->prepare($insert);
		$result->execute($data);
		return $result;
	}

	public function GetGroupItems($group, $kurs) {
		$items=$this->pdo->prepare("SELECT * FROM `items` INNER JOIN `subjects` ON `subjects`.`subject_id`=`items`.`subject_id` INNER JOIN `groups` ON `groups`.`group_id`=`items`.`group_id` LEFT JOIN `teachers` ON `items`.`teacher_id`=`teachers`.`teacher_id` WHERE `items`.`group_id`=? AND `kurs_num`=? ORDER BY `general_id`, `theory` DESC, `subgroup`");
		$items->execute(array($group, $kurs));
		return $items->fetchAll();
	}

	public function GetTeacherItems($teacher, $kurs) {
		$items=$this->pdo->prepare("SELECT * FROM `items` INNER JOIN `subjects` ON `subjects`.`subject_id`=`items`.`subject_id` INNER JOIN `groups` ON `items`.`group_id`=`groups`.`group_id` INNER JOIN `teachers` ON `teachers`.`teacher_id`=`items`.`teacher_id` WHERE `items`.`teacher_id`=? AND `items`.`kurs_num`=?");
		$items->execute(array($teacher, $kurs));
		return $items->fetchAll();
	}


	public function CreateTemp($item, $group) {
		$temp=[];
		$temp['general']=$item['general_id'];
		$temp['group']=$group;
		$temp['subject']=$item['subject_id'];
		$temp['exams']=$item['exams'];
		$temp['zachet']=$item['zachet'];
		$temp['kursach']=$item['kursach'];
		$temp['control']=$item['control'];
		$temp['totalrup']=intval($item['theory'])+intval($item['practice'])+intval($item['project']);
		$temp['theoryrup']=$item['theory'];
		$temp['lprrup']=$item['practice'];
		$temp['subgroup']=0;
		return $temp;
	}

	public function CreateKurs($item, $temp, $group, $num) {
		$temp['totalkurs']+=$item['s'.($num*2-1)]==''?0:intval($item['s'.($num*2-1)]);
		$temp['totalkurs']+=$item['s'.$num*2]==''?0:intval($item['s'.$num*2]);

		$alone=$temp['totalkurs']==$temp['totalrup'];

		$temp['theory']=$alone?$item['theory']:0;
		$temp['lpr']=$alone?$item['practice']:0;
		$temp['kurs']=$alone?$item['project']:0;

		$temp['w1']=$item['s'.($num*2-1)]>0?$group['s'.($num*2-1)]:0;
		$temp['s1']=$item['s'.($num*2-1)];
		$temp['w2']=$item['s'.$num*2]>0?$group['s'.$num*2]:0;
		$temp['s2']=$item['s'.$num*2];

		$temp['kurs_num']=($group['year']+$num-1).'-'.(intval($group['year'])+$num);
		return $temp;
	}

	public function CreateAdditional($item, $temp) {
		$add=$temp;
		$add['exams']=0;
		$add['subgroup']=2;
		if($item['divide'] == 2) { //divide in practce
			$add['totalkurs']=intval($temp['lpr'])+intval($temp['kurs']);
			$add['w1']=0;
			$add['s1']=0;
			$add['w2']=0;
			$add['s2']=0;
			$add['totalrup']=intval($item['practice'])+intval($item['project']);
			$add['theoryrup']=0;
			$add['theory']=0;
		}
		return $add;
	}

	public function Update($data) {
		$update=$this->pdo->prepare("UPDATE `items` SET `group_id`=?, `subgroup`=?, `teacher_id`=?, `subject_id`=?, `exam`=?, `zachet`=?, `kursach`=?, `control`=?,`totalrup`=?, `theoryrup`=?, `lprrup`=?, `totalkurs`=?, `pd`=?, `theory`=?, `lpr`=?, `kurs`=?, `week1`=?, `sem1`=?, `week2`=?, `sem2`=?, `consul`=?, `examens`=?, `totalyear`=?, `stdxp`=?, `hourxp`=?, `kurs_num`=? WHERE `item_id`=?");
        $update->execute($data);
        $final=$this->pdo->query("UPDATE `items` SET  `teacher_id`= NULL WHERE `teacher_id`=''");
        //$finally=$this->pdo->query("UPDATE `items` SET  `subgroup`= 0 WHERE `subgroup`=''");
	}

	public function CreateLessons($group) {
		$lessons = [];
		$params = [];
		$res = $this->pdo->prepare("SELECT * FROM items WHERE group_id=?");
		$res->execute(array($group));
		while($plan = $res->fetch()) {
			for($i = 0; $i < ceil($plan['sem1'] / 2); $i++) {
				$lessons = array_merge($lessons, [$plan['item_id'], $plan['group_id'], 1]);
				$params[] = '(?,?,?)';
			}		
			for($i = 0; $i < ceil($plan['sem2'] / 2); $i++) {
				$lessons = array_merge($lessons, [$plan['item_id'], $plan['group_id'], 2]);
				$params[] = '(?,?,?)';
			}
		}
		$sql="INSERT INTO `lessons` (`item_id`, `group_id`, `sem_num`) VALUES ".implode(',', $params);
		$res=$this->pdo->prepare($sql);
		$res->execute($lessons);		
	}

	public function About($item) {
		$res=$this->pdo->prepare("SELECT `items`.`group_id`, `items`.`teacher_id`, `items`.`item_id`, items.subgroup, `subjects`.`subject_name`,  subjects.divide FROM `items` INNER JOIN `subjects` ON `items`.`subject_id`=`subjects`.`subject_id` WHERE `items`.`item_id`=?");
		$res->execute(array($item));
		return $res->fetch();
	}
}