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

	public function CheckNext($item, $next) {
		return intval($item['theory'])>0&&intval($next['item_practice']>0)&&$item['divide'];
	}

	public function GetMain($group, $kurs, $sem) {
		$res=$this->pdo->prepare("SELECT `schedule_items`.`item_id`, `subjects`.`subject_name`, `teachers`.`teacher_name`, `items`.`teacher_id`, `items`.`theory`, `items`.`totalkurs`, `schedule_items`.`day_of_week`, `schedule_items`.`num_of_lesson`, `items`.`sem1`, `items`.`sem2`, `schedule_items`.`weeks` FROM `schedule_items` INNER JOIN `items` ON `schedule_items`.`item_id`=`items`.`item_id` INNER JOIN `subjects` ON `items`.`subject_id`=`subjects`.`subject_id` INNER JOIN `teachers` ON `teachers`.`teacher_id`=`items`.`teacher_id` WHERE `items`.`group_id`=? AND `items`.`kurs_num`=? AND `schedule_items`.`sem_num`=? ORDER BY `schedule_items`.`day_of_week`, `schedule_items`.`num_of_lesson`, `schedule_items`.`weeks`");
		$res->execute(array($group, $kurs, $sem));
		return $res->fetchAll();
	}

	public function TeacherSchedule($teacher, $kurs, $sem) {
		$res=$this->pdo->prepare("SELECT `schedule_items`.`item_id`, `subjects`.`subject_name`, `schedule_items`.`day_of_week`, `schedule_items`.`num_of_lesson`, `schedule_items`.`weeks`, `groups`.`group_name` FROM `schedule_items` INNER JOIN `items` ON `schedule_items`.`item_id`=`items`.`item_id` INNER JOIN `subjects` ON `items`.`subject_id`=`subjects`.`subject_id` INNER JOIN `teachers` ON `teachers`.`teacher_id`=`items`.`teacher_id` INNER JOIN `groups` ON `schedule_items`.`group_id`=`groups`.`group_id` WHERE `items`.`teacher_id`=? AND `items`.`kurs_num`=? AND `schedule_items`.`sem_num`=? ORDER BY `schedule_items`.`day_of_week`, `schedule_items`.`num_of_lesson`, `schedule_items`.`weeks`");
		$res->execute(array($teacher, $kurs, $sem));
		return $res->fetchAll();
	}

	public function MainToday($group, $date) {
		$kurs=$this->CurrentKurs(date('Y', strtotime($date)),date('n', strtotime($date)),date('d', strtotime($date)))['kurs'];
		$sem=$this->CurrentKurs(date('Y', strtotime($date)),date('n', strtotime($date)),date('d', strtotime($date)))['sem'];
		$weekday=date('N', strtotime($date));
		$res=$this->pdo->prepare("SELECT `items`.`item_id`, `subjects`.`subject_name`, `teachers`.`teacher_name`, `items`.`teacher_id`, `schedule_items`.`day_of_week`, `schedule_items`.`num_of_lesson`, `schedule_items`.`weeks` FROM `schedule_items` INNER JOIN `items` ON `schedule_items`.`item_id`=`items`.`item_id` INNER JOIN `subjects` ON `items`.`subject_id`=`subjects`.`subject_id` INNER JOIN `teachers` ON `teachers`.`teacher_id`=`items`.`teacher_id` WHERE `items`.`group_id`=? AND `items`.`kurs_num`=? AND `schedule_items`.`sem_num`=? AND `schedule_items`.`day_of_week`=?");
		$res->execute(array($group, $kurs, $sem, $weekday));
		return $res->fetchAll();
	}

	public function SaveChanges($group, $date, $data) {
		$del=$this->pdo->prepare("UPDATE `lessons` SET `was`=0, `lesson_num`=NULL, `lesson_date`=NULL WHERE `group_id`=? AND `lesson_date`=?");
		$del->execute(array($group, $date));
		$update=$this->pdo->prepare("UPDATE `lessons` SET `lesson_date`=?, `lesson_num`=?, `was`=1 WHERE `item_id`=? AND `was`=0 LIMIT 1");
		foreach ($data as $key => $item) {
			$update->execute(array_values($item));
		}
	}

	public function SaveMain($group, $data) {
		$del=$this->pdo->prepare("DELETE FROM `schedule_items` WHERE `group_id`=?");
		$del->execute(array($group));
		$ready=[];
		$count=0;
		foreach ($data as $key => $item) {
			$ready=array_merge($ready, array_values($item));
			$count++;
		}
		if($count) {
			$query="INSERT INTO `schedule_items` (`num_of_lesson`, `day_of_week`, `item_id`, `sem_num`, `group_id`, `weeks`) VALUES ".str_repeat("(?,?,?,?,?,?), ", $count-1)."(?,?,?,?,?,?)";
			$res=$this->pdo->prepare($query);
			$res->execute($ready);
		}		
	}

	public function MatchMain($data) {
		$res=$this->pdo->prepare("SELECT `subjects`.`subject_name`,`teachers`.`teacher_name`, `groups`.`group_name` FROM `schedule_items` INNER JOIN `items` ON `schedule_items`.`item_id`=`items`.`item_id` INNER JOIN `groups` ON `items`.`group_id`=`groups`.`group_id` INNER JOIN `subjects` ON `items`.`subject_id`=`subjects`.`subject_id` INNER JOIN `teachers` ON `items`.`teacher_id`=`teachers`.`teacher_id` WHERE `schedule_items`.`day_of_week`=? AND `schedule_items`.`num_of_lesson`=? AND `items`.`kurs_num`=? AND `schedule_items`.`sem_num`=? AND `items`.`teacher_id`=?");
		$res->execute(array_values($data));
		return $res->fetch();
	}

	public function LessonsToday($group, $date) {
		$res=$this->pdo->prepare("SELECT `subjects`.`subject_name`,`teachers`.`teacher_name`, `groups`.`group_name`, `items`.`item_id`, `items`.`teacher_id`, `lessons`.`lesson_date`, `lessons`.`lesson_num` FROM `lessons` INNER JOIN `items` ON `lessons`.`item_id`=`items`.`item_id` INNER JOIN `groups` ON `items`.`group_id`=`groups`.`group_id` INNER JOIN `subjects` ON `items`.`subject_id`=`subjects`.`subject_id` INNER JOIN `teachers` ON `items`.`teacher_id`=`teachers`.`teacher_id` WHERE `lessons`.`group_id`=? AND `lessons`.`lesson_date`=?");
		$res->execute(array($group, $date));
		return $res->fetchAll();
	}

	public function CurrentKurs($year, $month, $day) {
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
}