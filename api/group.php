<?php
/**
 * 
 */
class Group
{
	private $pdo;
	const LANG_RUS = 0;
	const LANG_KAZ = 1;
	
	function __construct($pdo)
	{
		$this->pdo=$pdo;
	}

	public function GetShortName($fname, $sname, $tname) {
		return trim($fname)." ".mb_substr(trim($sname), 0, 1).".".mb_substr(trim($tname), 0, 1).".";
	}

	public function Insert($data) {
		$res=$this->pdo->prepare("INSERT INTO `groups` (`group_name`, `specialization_id`, `base`, `count`, `lang`, `kurator`) VALUES (?,?,?,?,?,?)");
		$res->execute($data);
	}

	public function Upload($data, $count) {
		$sql="INSERT INTO `students` (`student_fname`, `student_sname`, `student_tname`, `student_name`, `group_id`, `subgroup`) VALUES ".str_repeat("(?,?,?,?,?,?),", $count-1)."(?,?,?,?,?,?)";
		$res=$this->pdo->prepare($sql);
		$res->execute($data);
		return $res;
	}

	public function InsertSpecialization($name, $code, $courses) {
		$res=$this->pdo->prepare("INSERT INTO `specializations` (`specialization_name`, `code`, `courses`) VALUES (?,?,?)");
		$res->execute(array($name,$code,$courses));
	}

	public function InsertStudent($fname, $sname, $tname, $group, $subgroup) {
		$short=$this->GetShortName($fname, $sname, $tname);
		$res=$this->pdo->prepare("INSERT INTO `students` (`student_name`, `student_fname`, `student_sname`, `student_tname`, `group_id`, `subgroup`) VALUES (?,?,?,?,?,?)");
		$res->execute(array($short, $fname, $sname, $tname, $group, $subgroup));
	}

	public function InsertTeacher($fname, $sname, $tname, $cmk) {
		$short=$this->GetShortName($fname, $sname, $tname);
		$res=$this->pdo->prepare("INSERT INTO `teachers` (`teacher_name`, `teacher_fname`, `teacher_sname`, `teacher_tname`, `cmk_id`) VALUES (?,?,?,?,?)");
		$res->execute(array($short, $fname, $sname, $tname, $cmk));
	}

	public function GetGroups() {
		$res=$this->pdo->query("SELECT * FROM `groups`");
		return $res->fetchAll();
	}

	public function GetTeachers() {
		$res=$this->pdo->query("SELECT * FROM `teachers` LEFT JOIN `cmks` ON `teachers`.`cmk_id`=`cmks`.`cmk_id` ");
		return $res->fetchAll();
	}

	public function GetIds() {
		$res=$this->pdo->query("SELECT `group_id` FROM `groups`");
		return $res->fetchAll();
	}

	public function GetFull() {
		$res=$this->pdo->query("SELECT * FROM `groups` INNER JOIN `specializations` ON `groups`.`specialization_id`=`specializations`.`specialization_id` LEFT JOIN teachers ON groups.kurator = teachers.teacher_id");
		return $res->fetchAll();
	}

	public function GetSpecializations() {
		$res=$this->pdo->query("SELECT * FROM `specializations`");
		return $res->fetchAll();
	}

	public function GetCmks() {
		$res=$this->pdo->query("SELECT * FROM `cmks`");
		return $res->fetchAll();
	}

	public function About($group) {
		$res=$this->pdo->prepare("SELECT * FROM `groups` INNER JOIN `specializations` ON `groups`.`specialization_id`=`specializations`.`specialization_id` LEFT JOIN teachers ON groups.kurator = teachers.teacher_id WHERE `groups`.`group_id`=?");
		$res->execute(array($group));
		return $res->fetch();
	}

	public function AboutSpecialization($spec) {
		$res=$this->pdo->prepare("SELECT * FROM `specializations` WHERE `specialization_id`=?");
		$res->execute(array($spec));
		return $res->fetch();
	}

	public function AboutStudent($student) {
		$res=$this->pdo->prepare("SELECT * FROM `students` WHERE `student_id`=?");
		$res->execute(array($student));
		return $res->fetch();
	}

	public function AboutTeacher($teacher) {
		$res=$this->pdo->prepare("SELECT * FROM `teachers` WHERE `teacher_id`=?");
		$res->execute(array($teacher));
		return $res->fetch();
	}

	public function Update($data) {
		$res=$this->pdo->prepare("UPDATE `groups` SET `group_name`=?, `specialization_id`=?, `base`=?, `year`=?, `lang`=?, `kurator`=? WHERE `group_id`=?");
		$res->execute($data);
	}

	public function UpdateSpecialization($name, $code, $courses, $id) {
		$res=$this->pdo->prepare("UPDATE `specializations` SET `specialization_name`=?, `code`=?, `courses`=? WHERE `specialization_id`=?");
		$res->execute(array($name, $code, $courses,  $id));
	}

	public function UpdateStudent($fname, $sname, $tname, $group, $subgroup, $id) {
		$short=$this->GetShortName($fname, $sname, $tname);
		$res=$this->pdo->prepare("UPDATE `students` SET `student_name`=?, `student_fname`=?, `student_sname`=?, `student_tname`=?, `group_id`=?, `subgroup`=? WHERE `student_id`=?");
		$res->execute(array($short, $fname, $sname, $tname, $group, $subgroup, $id));
	}

	public function UpdateTeacher($fname, $sname, $tname, $cmk, $id) {
		$short=$this->GetShortName($fname, $sname, $tname);
		$res=$this->pdo->prepare("UPDATE `teachers` SET `teacher_name`=?, `teacher_fname`=?, `teacher_sname`=?, `teacher_tname`=?, `cmk_id`=? WHERE `teacher_id`=?");
		$res->execute(array($short, $fname, $sname, $tname, $cmk, $id));
	}

	public function Delete($group) {
		$res=$this->pdo->prepare("DELETE FROM `groups` WHERE `group_id`=?");
		$res->execute(array($group));
	}

	public function DeleteStudent($student) {
		$res=$this->pdo->prepare("DELETE FROM `students` WHERE `student_id`=?");
		$res->execute(array($student));
	}

	public function DeleteSpecialization($spec) {
		$res=$this->pdo->prepare("DELETE FROM `specializations` WHERE `specialization_id`=?");
		$res->execute(array($spec));
	}

	public function StudentsCount($group) {
		$res=$this->pdo->prepare("SELECT COUNT(*) FROM `students` WHERE `group_id`=?");
		$res->execute(array($group));
		return $res->fetchColumn();
	}

	public function GetName($item) {
		$current=substr($item['kurs_num'], 0, 4);
		if($item['base']==9) {
			$kurs=intval($current)-intval($item['year'])+1; 
		}
		else {
			$kurs=intval($current)-intval($item['year'])+2;
		}
		$d=substr($item['group_name'], 0, strlen($item['group_name'])-3).$kurs.substr($item['group_name'], -2);
		return $d;
	}

	public function GetStudentIds($group) {
		$res=$this->pdo->prepare("SELECT `student_id` FROM `students` WHERE `students`.`group_id`=? ");
		$res->execute(array($group));
		return $res->fetchAll();
	}

	public function GetStudents($group, $subgroup=0) {
		if(!$subgroup) {
			$res=$this->pdo->prepare("SELECT `students`.`student_name`, `students`.`student_id`, `groups`.`group_name` FROM `students` INNER JOIN `groups` ON `students`.`group_id`=`groups`.`group_id` WHERE `students`.`group_id` = ? ORDER BY `students`.`student_fname`, `students`.`student_sname`, `students`.`student_tname`");
			$res->execute(array($group));
		} else {
			$res=$this->pdo->prepare("SELECT `students`.`student_name`, `students`.`student_id`, `groups`.`group_name` FROM `students` INNER JOIN `groups` ON `students`.`group_id`=`groups`.`group_id` WHERE `students`.`group_id` = ? AND `subgroup`=? ORDER BY `students`.`student_fname`, `students`.`student_sname`, `students`.`student_tname`");
			$res->execute(array($group, $subgroup));
		}
		return $res->fetchAll();
	}

	public function WeeksCount($start, $finish) {
		$diff = strtotime($finish) - strtotime($start);
		return ceil($diff/604800);
	}
}