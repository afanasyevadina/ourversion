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
		$items=$this->pdo->prepare("SELECT * FROM `items` INNER JOIN `subjects` ON `subjects`.`subject_id`=`items`.`subject_id` INNER JOIN `groups` ON `groups`.`group_id`=`items`.`group_id` LEFT JOIN `teachers` ON `items`.`teacher_id`=`teachers`.`teacher_id` WHERE `items`.`group_id`=? AND `kurs_num`=? ORDER BY `general_id`, `subgroup`");
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
		$add['totalrup']=intval($item['practice'])+intval($item['project']);
		$add['theoryrup']=0;
		$add['theory']=0;
		$add['subgroup']=2;
		if(intval($item['theory'])>0) {
			$add['totalkurs']=intval($temp2['lpr'])+intval($temp['kurs']);
			$add['w1']=0;
			$add['s1']=0;
			$add['w2']=0;
			$add['s2']=0;
		}
		return $add;
	}

	public function Update($data) {
		$update=$this->pdo->prepare("UPDATE `items` SET `group_id`=?, `subgroup`=?, `teacher_id`=?, `subject_id`=?, `exam`=?, `zachet`=?, `kursach`=?, `control`=?,`totalrup`=?, `theoryrup`=?, `lprrup`=?, `totalkurs`=?, `pd`=?, `theory`=?, `lpr`=?, `kurs`=?, `week1`=?, `sem1`=?, `week2`=?, `sem2`=?, `consul`=?, `examens`=?, `totalyear`=?, `stdxp`=?, `hourxp`=?, `kurs_num`=? WHERE `item_id`=?");
        $update->execute($data);
        $final=$this->pdo->query("UPDATE `items` SET  `teacher_id`= NULL WHERE `teacher_id`=''");
        //$finally=$this->pdo->query("UPDATE `items` SET  `subgroup`= 0 WHERE `subgroup`=''");
	}

	public function CreateLessons($lessons, $lc, $general) {
		$sql="INSERT INTO `lessons` (`item_id`, `rupitem_id`, `group_id`, `sem_num`) VALUES ".str_repeat('(?,?,?,?),', $lc-1)."(?,?,?,?)";
		$res=$this->pdo->prepare($sql);
		$res->execute($lessons);

		$lessonres=$this->pdo->prepare("SELECT `lessons`.`lesson_id`, `subjects`.`divide`, `items`.`theory` FROM `items` INNER JOIN `lessons` ON `lessons`.`item_id`=`items`.`item_id` INNER JOIN `subjects` ON `subjects`.`subject_id`=`items`.`subject_id` WHERE `items`.`general_id`=?");
		$lessonres->execute(array($general));
		
		$ratings=[];
		$rc=0;
		while ($lesson=$lessonres->fetch()) {
			foreach ($students as $key => $student) {
				$ratings=array_merge($ratings, array($student['student_id'], $lesson['lesson_id']));
				$rc++;
			}
		}
		if($rc) {
			$sql="INSERT INTO `ratings` (`student_id`, `lesson_id`) VALUES ".str_repeat('(?,?),', $rc-1)."(?,?)";
			$res=$this->pdo->prepare($sql);
			$res->execute($ratings);
		}
	}
}