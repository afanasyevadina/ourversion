<?php
/**
 * 
 */
class Schedule
{
	private $pdo;

	public $config;
	
	function __construct($pdo, $config_path)
	{
		$this->pdo=$pdo;
		$this->config=json_decode(file_get_contents($config_path), true);
	}

	public function GetNext($item, $sem) {
		$res=$this->pdo->prepare("SELECT * FROM `lessons` INNER JOIN `rupitems` ON `lessons`.`rupitem_id`=`rupitems`.`rupitem_id` WHERE `lessons`.`item_id`=? AND `lessons`.`was`=0 AND `lessons`.`sem_num`=? LIMIT 1");
		$res->execute(array($item, $sem));
		return $res->fetch();
	}

	public function GetGone($item, $sem) {
		$res=$this->pdo->prepare("SELECT COUNT(*) FROM `lessons` WHERE `item_id`=? AND `was`=1 AND `sem_num`=?");
		$res->execute(array($item, $sem));
		return $res->fetchColumn();
	}

	//theory or practice
	public function CheckNext($item, $next) {
		return intval($item['theory'])>0&&intval($next['item_practice']>0)&&$item['divide'];
	}

	//what is by main schedule
	public function GetMain($group, $kurs, $sem) {
		$res=$this->pdo->prepare("SELECT `schedule_items`.*, `subjects`.`subject_name`, `teachers`.`teacher_name`, `items`.`teacher_id`, `items`.`theory`, `items`.`totalkurs`, `items`.`sem1`, `items`.`sem2`, `cabinets`.* FROM `schedule_items` INNER JOIN `items` ON `schedule_items`.`item_id`=`items`.`item_id` INNER JOIN `subjects` ON `items`.`subject_id`=`subjects`.`subject_id` INNER JOIN `teachers` ON `teachers`.`teacher_id`=`items`.`teacher_id` LEFT JOIN `cabinets` ON `cabinets`.`cabinet_id`=`schedule_items`.`cab_num` WHERE `items`.`group_id`=? AND `items`.`kurs_num`=? AND `schedule_items`.`sem_num`=? ORDER BY `schedule_items`.`day_of_week`, `schedule_items`.`num_of_lesson`, `schedule_items`.`weeks`");
		$res->execute(array($group, $kurs, $sem));
		return $res->fetchAll();
	}

	public function TeacherSchedule($teacher, $kurs, $sem) {
		$res=$this->pdo->prepare("SELECT `schedule_items`.*, `subjects`.`subject_name`, `groups`.`group_name`, `teachers`.`teacher_name`, `items`.`theory`, `items`.`totalkurs`, `items`.`sem1`, `items`.`sem2`, `cabinets`.* FROM `schedule_items` INNER JOIN `items` ON `schedule_items`.`item_id`=`items`.`item_id` INNER JOIN `subjects` ON `items`.`subject_id`=`subjects`.`subject_id` INNER JOIN `teachers` ON `teachers`.`teacher_id`=`items`.`teacher_id` INNER JOIN `groups` ON `schedule_items`.`group_id`=`groups`.`group_id` LEFT JOIN `cabinets` ON `cabinets`.`cabinet_id`=`schedule_items`.`cab_num` WHERE `items`.`teacher_id`=? AND `items`.`kurs_num`=? AND `schedule_items`.`sem_num`=? ORDER BY `schedule_items`.`day_of_week`, `schedule_items`.`num_of_lesson`, `schedule_items`.`weeks`");
		$res->execute(array($teacher, $kurs, $sem));
		return $res->fetchAll();
	}

	public function CabinetSchedule($cabinet, $kurs, $sem) {
		$res=$this->pdo->prepare("SELECT `schedule_items`.*, `subjects`.`subject_name`, `groups`.`group_name`, `teachers`.`teacher_name`, `items`.`theory`, `items`.`totalkurs`, `items`.`sem1`, `items`.`sem2`, `cabinets`.* FROM `schedule_items` INNER JOIN `items` ON `schedule_items`.`item_id`=`items`.`item_id` INNER JOIN `subjects` ON `items`.`subject_id`=`subjects`.`subject_id` INNER JOIN `teachers` ON `teachers`.`teacher_id`=`items`.`teacher_id` INNER JOIN `groups` ON `schedule_items`.`group_id`=`groups`.`group_id` LEFT JOIN `cabinets` ON `cabinets`.`cabinet_id`=`schedule_items`.`cab_num` WHERE`schedule_items`.`cab_num`=? AND `items`.`kurs_num`=? AND `schedule_items`.`sem_num`=? ORDER BY `schedule_items`.`day_of_week`, `schedule_items`.`num_of_lesson`, `schedule_items`.`weeks`");
		$res->execute(array($cabinet, $kurs, $sem));
		return $res->fetchAll();
	}

	//what will be in current day by main schedule
	public function MainToday($group, $date) {
		$kurs=$this->CurrentKurs($date)['kurs'];
		$sem=$this->CurrentKurs($date)['sem'];
		$weekday=date('N', strtotime($date));
		$res=$this->pdo->prepare("SELECT `items`.`item_id`, `subjects`.`subject_name`, `teachers`.`teacher_name`, `items`.`teacher_id`, `schedule_items`.`day_of_week`, `schedule_items`.`num_of_lesson`, `schedule_items`.`weeks`, `cabinets`.`cabinet_name`  FROM `schedule_items` INNER JOIN `items` ON `schedule_items`.`item_id`=`items`.`item_id` INNER JOIN `subjects` ON `items`.`subject_id`=`subjects`.`subject_id` INNER JOIN `teachers` ON `teachers`.`teacher_id`=`items`.`teacher_id` LEFT JOIN `cabinets` ON `cabinets`.`cabinet_id`=`schedule_items`.`cab_num` WHERE `items`.`group_id`=? AND `items`.`kurs_num`=? AND `schedule_items`.`sem_num`=? AND `schedule_items`.`day_of_week`=?");
		$res->execute(array($group, $kurs, $sem, $weekday));
		return $res->fetchAll();
	}

	public function SaveChanges($group, $date, $data) {
		$del=$this->pdo->prepare("UPDATE `lessons` SET `was`=0, `lesson_num`=NULL, `cab_num`=NULL, `teacher_id`=NULL, `lesson_date`=NULL WHERE `group_id`=? AND `lesson_date`=?");
		$del->execute(array($group, $date));
		$update=$this->pdo->prepare("UPDATE `lessons` SET `lesson_date`=?, `lesson_num`=?, `cab_num`=?, `teacher_id`=?, `was`=1 WHERE `item_id`=? AND `was`=0 LIMIT 1");
		foreach ($data as $key => $item) {
			$update->execute(array_values($item));
		}
	}

	public function SaveMain($group, $data) {
		/*$del=$this->pdo->prepare("DELETE FROM `schedule_items` WHERE `group_id`=? AND");
		$del->execute(array($group));*/
		$ready=[];
		$count=0;
		foreach ($data as $key => $item) {
			print_r($item);
			$ready=array_merge($ready, array_values($item));
			$count++;
		}
		if($count) {
			$query="INSERT INTO `schedule_items` (`num_of_lesson`, `day_of_week`, `cab_num`, `item_id`, `kurs_num`, `sem_num`, `group_id`, `weeks`, `subgroup`) VALUES ".str_repeat("(?,?,?,?,?,?,?,?,?), ", $count-1)."(?,?,?,?,?,?,?,?,?) ON DUPLICATE KEY UPDATE `num_of_lesson`=VALUES(num_of_lesson), `day_of_week`=VALUES(day_of_week), `cab_num`=VALUES(cab_num), `item_id`=VALUES(item_id), `sem_num`=VALUES(`sem_num`), `group_id`=VALUES(group_id), `weeks`=VALUES(`weeks`), `subgroup`=VALUES(subgroup)";
			$res=$this->pdo->prepare($query);
			$res->execute($ready);
		}		
	}

	public function MatchMain($data) {
		$res=$this->pdo->prepare("SELECT `subjects`.`subject_name`,`teachers`.`teacher_name`, `groups`.`group_name` FROM `schedule_items` INNER JOIN `items` ON `schedule_items`.`item_id`=`items`.`item_id` INNER JOIN `groups` ON `items`.`group_id`=`groups`.`group_id` INNER JOIN `subjects` ON `items`.`subject_id`=`subjects`.`subject_id` INNER JOIN `teachers` ON `items`.`teacher_id`=`teachers`.`teacher_id` WHERE `schedule_items`.`day_of_week`=? AND `schedule_items`.`kurs_num`=? AND `schedule_items`.`sem_num`=? AND `schedule_items`.`num_of_lesson`=? AND `items`.`teacher_id`=?");
		$res->execute(array_values($data));
		return $res->fetch();
	}

	//what have been set to certain day
	public function LessonsToday($group, $date) {
		$res=$this->pdo->prepare("SELECT `subjects`.`subject_name`,`teachers`.`teacher_name`, `groups`.`group_name`, `items`.`item_id`, `items`.`teacher_id`, `cabinets`.*, `lessons`.* FROM `lessons` INNER JOIN `items` ON `lessons`.`item_id`=`items`.`item_id` INNER JOIN `groups` ON `items`.`group_id`=`groups`.`group_id` INNER JOIN `subjects` ON `items`.`subject_id`=`subjects`.`subject_id` INNER JOIN `teachers` ON `lessons`.`teacher_id`=`teachers`.`teacher_id` LEFT JOIN `cabinets` ON `cabinets`.`cabinet_id`=`lessons`.`cab_num` WHERE `lessons`.`group_id`=? AND `lessons`.`lesson_date`=?");
		$res->execute(array($group, $date));
		return $res->fetchAll();
	}

	public function TeacherLessons($teacher, $kurs) {
		$res=$this->pdo->prepare("SELECT `lessons`.*, `rupitems`.`item_theory`, `rupitems`.`item_practice` FROM `lessons` INNER JOIN `rupitems` ON `lessons`.`rupitem_id`=`rupitems`.`rupitem_id` INNER JOIN `items` ON `items`.`item_id`=`lessons`.`item_id` WHERE `items`.`teacher_id`=? AND `lessons`.`teacher_id`=? AND `items`.`kurs_num`=?");
		$res->execute(array($teacher, $teacher, $kurs));
		return $res->fetchAll();
	}

	//number of academic year and semestr
	public function CurrentKurs($date) {
		$year=date('Y', strtotime($date));
		$month=date('m', strtotime($date));
		$day=date('d', strtotime($date));
		$return=[];
		if(intval($month)>=$this->config['start1_month']) {
			$return['kurs']=$year.'-'.($year+1);
		} else {
			$return['kurs']=($year-1).'-'.$year;
		}
		if(($month>=$this->config['start1_month']&&$day>=$this->config['start1_day'])||($month==$this->config['start2_month']&&$day<=$this->config['start2_day'])) {
			$return['sem']=1;
		} else {
			$return['sem']=2;
		}
		return $return;
	}

	//sets cabinet to main schedule
	public function SaveCabinet($cab) {
		$res=$this->pdo->prepare("INSERT INTO `cabinets` (`cabinet_name`, `cab_description`, `cab_places`, `locked`, `allow_match`) VALUES (?,?,?,?,?) ON DUPLICATE KEY UPDATE `cabinet_name`=VALUES(cabinet_name), `cab_description`=VALUES(cab_description), `locked`=VALUES(locked), `cab_places`=VALUES(cab_places), `allow_match`=VALUES(allow_match)");
		$res->execute($cab);
	}

	public function DeleteCabinet($cab) {
		$res=$this->pdo->prepare("DELETE FROM `cabinets` WHERE `cabinet_id`=?");
		$res->execute(array($cab));
	}

	public function GetCabinets($name='') {
		$res=$this->pdo->prepare("SELECT * FROM `cabinets` WHERE `cabinet_name` LIKE ? ORDER BY `cab_description`, `cabinet_name`");
		$res->execute(array('%'.$name.'%'));
		return $res->fetchAll();
	}

	public function IsEmptyMain($cab, $day, $num) {
		$res=$this->pdo->prepare("SELECT * FROM `schedule_items` WHERE `cab_num`=? AND `day_of_week`=? AND `num_of_lesson`=?");
		$res->execute(array($cab, $day, $num));
		return !$res->fetch();
	}

	public function IsTeacherFree($teacher, $date, $num) {
		$res=$this->pdo->prepare("SELECT * FROM `lessons` WHERE `teacher_id`=? AND `lesson_date`=? AND `lesson_num`=?");
		$res->execute(array($teacher, $date, $num));
		if($res->fetch()) {
			return false;
		} else {
			$kurs=$this->CurrentKurs($date)['kurs'];
			$sem=$this->CurrentKurs($date)['sem'];
			$groups=$this->pdo->prepare("SELECT `schedule_items`.`group_id` FROM `schedule_items` INNER JOIN `items` ON `schedule_items`.`item_id`=`items`.`item_id` WHERE `items`.`teacher_id`=? AND `schedule_items`.`day_of_week`=? AND `schedule_items`.`num_of_lesson`=? AND `schedule_items`.`kurs_num`=? AND `schedule_items`.`sem_num`=?");
			$groups->execute(array($teacher, date('N', strtotime($date)), $num, $kurs, $sem));
			while ($group=$groups->fetch()) {
				$lesnres=$this->pdo->prepare("SELECT COUNT(*) FROM `lessons` WHERE `group_id`=? AND `lesson_date`=?");
				$lesnres->execute(array($group['group_id'], $date));
				if($lesnres->fetchColumn()) {
					return false;
				}
			}
		}
		return true;
	}

	public function IsCabinetFree($cabinet, $date, $num) {
		$res=$this->pdo->prepare("SELECT * FROM `lessons` WHERE `cab_num`=? AND `lesson_date`=? AND `lesson_num`=?");
		$res->execute(array($cabinet, $date, $num));
		if($res->fetch()) {
			return false;
		} else {
			$kurs=$this->CurrentKurs($date)['kurs'];
			$sem=$this->CurrentKurs($date)['sem'];
			$groups=$this->pdo->prepare("SELECT `group_id` FROM `schedule_items` WHERE `cab_num`=? AND `day_of_week`=? AND `num_of_lesson`=? AND `kurs_num`=? AND `sem_num`=?");
			$groups->execute(array($cabinet, date('N', strtotime($date)), $num, $kurs, $sem));
			while ($group=$groups->fetch()) {
				$lesnres=$this->pdo->prepare("SELECT COUNT(*) FROM `lessons` WHERE `group_id`=? AND `lesson_date`=?");
				$lesnres->execute(array($group['group_id'], $date));
				if($lesnres->fetchColumn()) {
					return false;
				}
			}
		}
		return true;
	}

	public function DeleteItem($item) {
		$res=$this->pdo->prepare("DELETE FROM `schedule_items` WHERE `sch_id`=?");
		$res->execute(array($item));
	}

	public function MainCabinet($item) {
		$res=$this->pdo->prepare("SELECT `cabinets`.* FROM `cabinets` INNER JOIN `schedule_items` ON `schedule_items`.`cab_num`=`cabinets`.`cabinet_id` WHERE `schedule_items`.`item_id`=?");
		$res->execute(array($item));
		return $res->fetch();
	}
}