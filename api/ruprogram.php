<?php
/**
 * 
 */
class Ruprogram
{
	private $pdo;
	
	function __construct($pdo)
	{
		$this->pdo=$pdo;
	}

	

	public function Insert($general) {
		$rupres=$this->pdo->prepare("INSERT INTO `ruprograms` (`general_id`) VALUES (?)");
		$rupres->execute(array($general));
	}

	public function DeletePart($part) {
		$ires=$this->pdo->prepare("DELETE FROM `rupitems` WHERE `part_id`=?");
		$ires->execute(array($part));
		$res=$this->pdo->prepare("DELETE FROM `parts` WHERE `part_id`=?");
		$res->execute(array($part));
	}

	public function DeleteTopic($topic) {
		$res=$this->pdo->prepare("DELETE FROM `rupitems` WHERE `rupitem_id`=?");
		$res->execute(array($topic));
	}

	public function GetProgram($program) {
		$res=$this->pdo->prepare("SELECT * FROM `ruprograms` WHERE `program_id`=?");
		$res->execute(array($program));
		return $res->fetch();
	}

	public function GetPrograms($group, $subject) {
		$res=$this->pdo->prepare("SELECT `ruprograms`.`program_id`, `subjects`.`subject_name`, `groups`.`group_name` FROM `ruprograms` INNER JOIN `general` ON `ruprograms`.`general_id`=`general`.`general_id` INNER JOIN `groups` ON `general`.`group_id`=`groups`.`group_id` INNER JOIN `subjects` ON `general`.`subject_id`=`subjects`.`subject_id` WHERE `general`.`group_id`=? AND `subjects`.`subject_name` LIKE ?");
		$res->execute(array($group, '%'.$subject.'%'));
		return $res->fetchAll();
	}

	public function GetParts($program) {
		$res=$this->pdo->prepare("SELECT * FROM `parts` WHERE `program_id`=?");
		$res->execute(array($program));
		return $res->fetchAll();
	}

	public function GetItems($general) {
		$subjectres=$this->pdo->prepare("SELECT * FROM `items` INNER JOIN `groups` ON `items`.`group_id`=`groups`.`group_id` INNER JOIN `specializations` ON `specializations`.`specialization_id`=`groups`.`specialization_id` INNER JOIN `subjects` ON `items`.`subject_id`=`subjects`.`subject_id` LEFT JOIN `teachers` ON `items`.`teacher_id`=`teachers`.`teacher_id` WHERE `general_id`=? ORDER BY `kurs_num`");
		$subjectres->execute(array($general));

		//это чтобы было красиво и правильно
		$items=$subjectres->fetchAll();
		$clon=$items;
		foreach ($items as $key => $item) {
		      unset($clon[$key]);
		      foreach ($clon as $k => $value) {
		            if($value['kurs_num']==$item['kurs_num']) {
		                  unset($items[$k]);
		            }
		      }
		}
		return $items;
	}

	public function GetPartItems($part) {
		$res=$this->pdo->prepare("SELECT * FROM `rupitems` WHERE `part_id`=?");
        $res->execute(array($part));
        return $res->fetchAll();
	}

	public function GetLpr($program) {
		$res=$this->pdo->prepare("SELECT * FROM `rupitems` WHERE `item_practice`>0 AND `program_id`=?");
      	$res->execute(array($program));
      	return $res->fetchAll();
	}

	public function AddPart($program) {
		$res=$this->pdo->prepare("INSERT INTO `parts` (`program_id`) VALUES (?)");
		$res->execute(array($program));
		return $this->pdo->lastInsertId();
	}

	public function AddTopic($part, $program) {
		echo "string";
		$res=$this->pdo->prepare("INSERT INTO `rupitems` (`part_id`, `program_id`) VALUES (?,?)");
    	$res->execute(array($part, $program));
		return $this->pdo->lastInsertId();
	}

	public function UpdateAims($data) {
		$res=$this->pdo->prepare("UPDATE `parts` SET `imagine`=?, `know`=?, `can`=?, `skills`=?, `complex`=? WHERE `part_id`=?");
		foreach ($data as $key => $item) {
			$res->execute($item);
		}		
	}

	public function UpdateLpr($data) {
		$res=$this->pdo->prepare("UPDATE `rupitems` SET `content`=? WHERE `rupitem_id`=?");
		foreach ($data as $key => $item) {
			$res->execute($item);
		}
	}

	public function UpdateTime($data) {
		$res=$this->pdo->prepare("UPDATE `items` SET `theory1`=?, `theory2`=?, `lab1`=?, `lab2`=?, `pract1`=?, `pract2`=?, `kurs1`=?, `kurs2`=? WHERE `item_id`=?");
		foreach ($data as $key => $item) {
			$res->execute($item);
		}
	}
	public function UpdateParts($data) {
		$res=$this->pdo->prepare("UPDATE `parts` SET `part_num`=?, `part_name`=?, `hours`=? WHERE `part_id`=?");
		foreach ($data as $key => $part) {
			$res->execute(array_values($part));
		}
	}

	public function UpdateItems($data) {
		$itemres=$this->pdo->prepare("UPDATE `rupitems` SET `rupitem_num`=?, `rupitem_name`=?, `item_theory`=?, `item_practice`=? WHERE `rupitem_id`=?");
		foreach ($data as $key => $item) {
			$total=$item[2];
			$item[2]=$total-$item[3];
			$itemres->execute(array_values($item));
		}
	}
}