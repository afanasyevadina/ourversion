<?php
/**
 * 
 */
class Journal
{
	private $pdo;
	
	function __construct($pdo)
	{
		$this->pdo=$pdo;
	}

	public function StudentSubjects($student, $kurs, $sem) {
		$gres=$this->pdo->prepare("SELECT `group_id` FROM `students` WHERE `student_id`=?");
		$gres->execute(array($student));
		$group=$gres->fetchColumn();
		if($sem==1) {
			$res=$this->pdo->prepare("SELECT `item_id`, `subject_name`, `items`.`general_id` FROM `items` INNER JOIN `subjects` ON `items`.`subject_id`=`subjects`.`subject_id` WHERE `items`.`group_id`=? AND `items`.`kurs_num`=? AND `items`.`sem1`>0 ORDER BY `items`.`theory` DESC");
		} else {
			$res=$this->pdo->prepare("SELECT `item_id`, `subject_name`, `items`.`general_id` FROM `items` INNER JOIN `subjects` ON `items`.`subject_id`=`subjects`.`subject_id` WHERE `items`.`group_id`=? AND `items`.`kurs_num`=? AND `items`.`sem2`>0 ORDER BY `items`.`general_id`, `items`.`theory` DESC");
		}
		$res->execute(array($group, $kurs));
		return $res->fetchAll();
	}

	public function GetRating($student, $item) {
		
		$avgres=$this->pdo->prepare("SELECT AVG(`rating_value`) FROM `ratings` INNER JOIN `lessons` ON `ratings`.`lesson_id`=`lessons`.`lesson_id` WHERE `ratings`.`student_id`=? AND `lessons`.`item_id`=?");
		$avgres->execute(array($student, $item));
		$avg=$avgres->fetchColumn();
		$examres=$this->pdo->prepare("SELECT `rating` FROM `exams` WHERE `student_id`=? AND `item_id`=?");
		$examres->execute(array($student, $item));
		$exam=$examres->fetchColumn();
		return array('avg'=>$avg, 'exam'=>$exam);
	}

	public function Save($data) {
		foreach ($data as $item) {
			$res=$this->pdo->prepare("UPDATE `ratings` SET `rating_value`=? WHERE `rating_id`=?");
			$res->execute(array_values($item));
		}
	}

	public function GetJournals($teacher, $kurs) {
		$res=$this->pdo->prepare("SELECT `ktps`.`ktp_id`, `subjects`.`subject_name`, `groups`.`group_name`, `teachers`.`teacher_name`, `items`.`kurs_num`, `groups`.`year`, `groups`.`base` FROM `ktps` INNER JOIN `items` ON `ktps`.`item_id`=`items`.`item_id` INNER JOIN `subjects` ON `items`.`subject_id`=`subjects`.`subject_id` INNER JOIN `teachers` ON `items`.`teacher_id`=`teachers`.`teacher_id` INNER JOIN `groups` ON `items`.`group_id`=`groups`.`group_id` INNER JOIN `specializations` ON `groups`.`specialization_id`=`specializations`.`specialization_id` WHERE `items`.`teacher_id`=? AND `items`.`kurs_num`=?");
		$res->execute(array($teacher, $kurs));
	}

	public function GetLast($student) {
		$res=$this->pdo->prepare("SELECT `subjects`.`subject_name`, `ratings`.`rating_value`, `lessons`.`lesson_date` FROM `ratings` INNER JOIN `lessons` ON `ratings`.`lesson_id`=`lessons`.`lesson_id` INNER JOIN `items` ON `items`.`item_id`=`lessons`.`item_id` INNER JOIN `subjects` ON `items`.`subject_id`=`subjects`.`subject_id` WHERE `ratings`.`student_id`=? AND `lessons`.`lesson_date`>= CURDATE() - INTERVAL 7 DAY");
		$res->execute(array($student));
		return $res->fetchAll();
	}
}
?>