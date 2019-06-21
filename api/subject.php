<?php
/**
 * 
 */
class Subject
{
	private $pdo;
	
	function __construct($pdo)
	{
		$this->pdo=$pdo;
	}

	public function GetSubjects() {
		$res=$this->pdo->query("SELECT * FROM `subjects` LEFT JOIN `types` ON `subjects`.`type_id`=`types`.`type_id` LEFT JOIN `cmks` ON `subjects`.`cmk_id`=`cmks`.`cmk_id` ORDER BY `subjects`.`type_id`, `subjects`.`subject_index`");
		return $res->fetchAll();
	}

	public function GetTypes() {
		$res=$this->pdo->query("SELECT * FROM `types`");
		return $res->fetchAll();
	}

	public function GetType($id) {
		$res=$this->pdo->prepare("SELECT `short_name` FROM `types` WHERE `type_id`=?");
		$res->execute(array($id));
		return $res->fetch();
	}

	public function GetByType($type) {
		$res=$this->pdo->prepare("SELECT `subject_name`, `subject_id` FROM `subjects` WHERE `type_id`=?");
		$res->execute(array($type));
		return $res->fetchAll();
	}

	public function CheckIndex($name, $index) {
		$res=$this->pdo->prepare("SELECT `subjects`.`subject_id` FROM `subjects` WHERE `subjects`.`subject_name`=? AND `subjects`.`subject_index`=?");
		$res->execute(array($name, $index));
		return $res ? $res->fetch() : $res;
	}

	public function About($subject) {
		$res=$this->pdo->prepare("SELECT * FROM `subjects` WHERE `subject_id`=?");
		$res->execute(array($subject));
		return $res->fetch();
	}

	public function Delete($subject) {
		$res=$this->pdo->prepare("DELETE FROM `subjects` WHERE `subject_id`=?");
		$res->execute(array($subject));
	}

	public function Update($name, $index, $pck, $cmk, $div, $id) {
		$res=$this->pdo->prepare("UPDATE `subjects` SET `subject_name`=?, `subject_index`=?, `type_id`=?, `cmk_id`=?, `divide`=? WHERE `subject_id`=?");
		$res->execute(array($name, $index, $pck, $cmk, $div, $id));
	}

	public function Insert($name, $index, $pck, $cmk, $div) {
		$res=$this->pdo->prepare("INSERT INTO `subjects` (`subject_name`, `subject_index`, `type_id`, `cmk`, `divide`) VALUES (?,?,?,?,?)");
		$res->execute(array($name, $index, $pck, $cmk, $div));
	}

	public function Upload($data, $count) {
		$sql='INSERT INTO `subjects` (`subject_index`, `subject_name`, `type_id`) VALUES '.str_repeat('(?,?,?), ', $count-1).'(?,?,?) ON DUPLICATE KEY UPDATE `subject_index`=VALUES(subject_index), `subject_name`=VALUES(subject_name), `type_id`=VALUES(type_id)';
        $result=$this->pdo->prepare($sql);
        $result->execute($data);
        $update=$this->pdo->query("UPDATE `subjects` SET `subject_index`='' WHERE `subject_index` IS NULL");
        return $result;
	}
}