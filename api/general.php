<?php
/**
 * 
 */
class General
{
	private $pdo;
	
	function __construct($pdo)
	{
		$this->pdo=$pdo;
	}

	public function Upload($data, $count) {
		$sql='INSERT INTO `general` (`subject_id`, `exams`, `zachet`, `kursach`, `control`, `theory`, `practice`, `project`, `s1`, `s2`, `s3`, `s4`, `s5`, `s6`, `s7`, `s8`, `group_id`) VALUES '.str_repeat('(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?), ', $count-1).'(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)';
	    $result=$this->pdo->prepare($sql);
	    $result->execute($data);
	    return $result;
	}

	public function GetGeneral($group) {
		$res=$this->pdo->prepare("SELECT * FROM `general` INNER JOIN subjects ON subjects.subject_id = general.subject_id WHERE `group_id`=?");
		$res->execute(array($group));
		return $res->fetchAll();
	}

	public function GetByType($group, $type) {
		$res=$this->pdo->prepare("SELECT * FROM `general` INNER JOIN `subjects` ON `subjects`.`subject_id`=`general`.`subject_id`  WHERE `group_id`=? AND `subjects`.`type_id`=?");
	    $res->execute(array($group, $type));
	    return $res->fetchAll();
	}

	public function AddItem($data) {
		$insert=$this->pdo->prepare("INSERT INTO `general` (`group_id`) VALUES (?)");
		$insert->execute(array($data));
		$lastid=$this->pdo->lastInsertId();
	}

	public function DeleteItem($id) {
		$res=$this->pdo->prepare("DELETE FROM `general` WHERE `general_id`=?");
		$res->execute(array($id));
	}

	public function Update($data) {
		$update=$this->pdo->prepare("UPDATE `general` SET `subject_id`=?, `exams`=?, `zachet`=?, `kursach`=?, `control`=?, `theory`=?, `practice`=?, `project`=?, `s1`=?, `s2`=?, `s3`=?, `s4`=?, `s5`=?, `s6`=?, `s7`=?, `s8`=? WHERE `general_id`=?");
        $update->execute($data);
	}
}
?>