<?php
/**
 * 
 */
class Teacher
{
	private $pdo;
	
	function __construct($pdo)
	{
		$this->pdo=$pdo;
	}

	public function GetNames() {
		$res=$this->pdo->query("SELECT `teacher_id`, `teacher_name` FROM `teachers`");
		return $res->fetchAll();
	}

	public function About($teacher) {
		$res=$this->pdo->prepare("SELECT * FROM `teachers` WHERE `teacher_id`=?");
		$res->execute(array($teacher));
		return $res->fetch();
	}

	public function Delete($teacher) {
		$res=$this->pdo->prepare("DELETE FROM `teachers` WHERE `teacher_id`=?");
		$res->execute(array($teacher));
	}
}