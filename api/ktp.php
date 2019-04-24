<?php
/**
 * 
 */
class Ktp
{
	private $pdo;
	
	function __construct($pdo)
	{
		$this->pdo=$pdo;
	}

	public function GetKtp($id) {
		$res=$this->pdo->prepare("SELECT * FROM `ktps` INNER JOIN `items` ON `ktps`.`item_id`=`items`.`item_id` INNER JOIN `subjects` ON `items`.`subject_id`=`subjects`.`subject_id` INNER JOIN `teachers` ON `items`.`teacher_id`=`teachers`.`teacher_id` INNER JOIN `groups` ON `items`.`group_id`=`groups`.`group_id` INNER JOIN `specializations` ON `groups`.`specialization_id`=`specializations`.`specialization_id` WHERE `ktps`.`ktp_id`=?");
		$res->execute(array($id));
		return $res->fetch();
	}

	public function GetItems($ktp) {
		$topicres=$this->pdo->prepare("SELECT * FROM `ktpitems` INNER JOIN `rupitems` ON `ktpitems`.`rupitem_id`=`rupitems`.`rupitem_id` WHERE `ktpitems`.`ktp_id`=?");
		$topicres->execute(array($ktp));
		return $topicres->fetchAll();
	}

	public function GetPartName($part) {
		$p=$this->pdo->prepare("SELECT `part_name` FROM `parts` WHERE `part_id`=?");
        $p->execute(array($part));
        return $p->fetch()['part_name'];
	}

	public function GetTopics($program) {
		$topicres=$this->pdo->prepare("SELECT * FROM `rupitems` WHERE `program_id`=? GROUP BY `rupitem_num`");
		$topicres->execute(array($program));
		return $topicres->fetchAll();
	}

	public function Insert($program, $item) {
		$newktp=$this->pdo->prepare("INSERT INTO `ktps` (`program_id`, `item_id`) VALUES (?,?)");
		$newktp->execute(array($program, $item));
		$ktpid=$this->pdo->lastInsertId();
		return $ktpid;
	}

	public function InsertItems($data, $count) {
		$insert="INSERT INTO `ktpitems` (`ktp_id`, `ktpitem_num`, `rupitem_id`, `program_id`) VALUES ".str_repeat("(?,?,?,?), ", $count-1)."(?,?,?,?)";
		$res=$this->pdo->prepare($insert);
		$res->execute($data);
	}

	public function GetGeneralItems($general) {
		$ktpres=$this->pdo->prepare("SELECT `ktps`.`item_id`, `ktps`.`ktp_id`, `items`.`teacher_id`, `items`.`kurs_num`, `subjects`.`divide`, `items`.`group_id`, `items`.`sem1`, `items`.`sem2` FROM `ktps` INNER JOIN `items` ON `items`.`item_id`=`ktps`.`item_id` INNER JOIN `subjects` ON `subjects`.`subject_id`=`items`.`subject_id` WHERE `items`.`general_id`=?");
		$ktpres->execute(array($general));
		return $ktpres->fetchAll();
	}

	public function GetKtps($group, $subject) {
		$res=$this->pdo->prepare("SELECT `ktps`.`ktp_id`, `subjects`.`subject_name`, `groups`.`group_name`, `teachers`.`teacher_name`, `items`.`kurs_num`, `groups`.`year`, `groups`.`base` FROM `ktps` INNER JOIN `items` ON `ktps`.`item_id`=`items`.`item_id` INNER JOIN `subjects` ON `items`.`subject_id`=`subjects`.`subject_id` INNER JOIN `teachers` ON `items`.`teacher_id`=`teachers`.`teacher_id` INNER JOIN `groups` ON `items`.`group_id`=`groups`.`group_id` INNER JOIN `specializations` ON `groups`.`specialization_id`=`specializations`.`specialization_id` WHERE `items`.`group_id`=? AND `subjects`.`subject_name` LIKE ?");
		$res->execute(array($group, '%'.$subject.'%'));
		return $res->fetchAll();
	}

	public function GetTeacherKtps($user, $group, $subject) {
		$res=$this->pdo->prepare("SELECT `ktps`.`ktp_id`, `subjects`.`subject_name`, `groups`.`group_name`, `teachers`.`teacher_name`, `items`.`kurs_num`, `groups`.`year`, `groups`.`base` FROM `ktps` INNER JOIN `items` ON `ktps`.`item_id`=`items`.`item_id` INNER JOIN `subjects` ON `items`.`subject_id`=`subjects`.`subject_id` INNER JOIN `teachers` ON `items`.`teacher_id`=`teachers`.`teacher_id` INNER JOIN `groups` ON `items`.`group_id`=`groups`.`group_id` INNER JOIN `specializations` ON `groups`.`specialization_id`=`specializations`.`specialization_id` WHERE `items`.`teacher_id`=? AND `items`.`group_id`=? AND `subjects`.`subject_name` LIKE ?");
		$res->execute(array($user, $group, '%'.$subject.'%'));
	}

	public function Update($data) {
		$res=$this->pdo->prepare("UPDATE `ktpitems` SET `time`=?, `type`=?, `connections`=?, `helpers`=?, `worktype`=?, `homework`=? WHERE `ktpitem_id`=?");
		$res->execute($data);
	}
}