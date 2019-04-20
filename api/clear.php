<?php
/**
 * 
 */
class Clear
{
	private $pdo;
	
	function __construct($pdo)
	{
		$this->pdo=$pdo;
	}

	public function ClearSchedule($item) {

	}

	public function ClearLessons($item) {
		$ls=$this->pdo->prepare("SELECT `lesson_id` FROM `lessons` WHERE `item_id`=?");
        $ls->execute(array($item));
        while ($l=$ls->fetch()) {
            $delr=$this->pdo->prepare("DELETE FROM `ratings` WHERE `lesson_id`=?");
            $delr->execute(array($l['lesson_id']));
        }
        $dell=$this->pdo->prepare("DELETE FROM `lessons` WHERE `item_id`=?");
        $dell->execute(array($item));
        $dels=$this->pdo->prepare("DELETE FROM `schedule_items` WHERE `item_id`=?");
        $dell->execute(array($item));
	}

	public function ClearKtp($item) {
		$ktps=$this->pdo->prepare("SELECT `ktp_id` FROM `ktps` WHERE `item_id`=?");
        $ktps->execute(array($item));
        while ($ktp=$ktps->fetch()) {
            $ktpres=$this->pdo->prepare("DELETE FROM `ktpitems` WHERE `ktp_id`=?");
            $ktpres->execute(array($ktp['ktp_id']));
        }    
        $ktpdel=$this->pdo->prepare("DELETE FROM `ktps` WHERE `item_id`=?");
        $ktpdel->execute(array($item));
	}

	public function ClearRup($general) {
		$progres=$this->pdo->prepare("SELECT `program_id` FROM `ruprograms` WHERE `general_id`=?");
        $progres->execute(array($general));
        while ($prog=$progres->fetch()) {
            $rupres=$this->pdo->prepare("DELETE FROM `rupitems` WHERE `program_id`=?");
            $rupres->execute(array($prog['program_id']));
            $partres=$this->pdo->prepare("DELETE FROM `parts` WHERE `program_id`=?");
            $partres->execute(array($prog['program_id']));
        }
        $progresult=$this->pdo->prepare("DELETE FROM `ruprograms` WHERE `general_id`=?");
        $progresult->execute(array($general));
	}

	public function ClearItems($general) {
		$res=$this->pdo->prepare("SELECT `item_id` FROM `items` WHERE `general_id`=?");
        $res->execute(array($general));
        while($item=$res->fetch()) {
            $this->ClearKtp($item['item_id']);
            $this->ClearLessons($item['item_id']);
        }
        $ires=$this->pdo->prepare("DELETE FROM `items` WHERE `general_id`=?");
        $ires->execute(array($general));
	}

	public function ClearGroupItems($group) {
		$res=$this->pdo->prepare("SELECT `item_id` FROM `items` WHERE `group_id`=?");
        $res->execute(array($group));
        while($item=$res->fetch()) {
            $this->ClearKtp($item['item_id']);
            $this->ClearLessons($item['item_id']);
        }
        $ires=$this->pdo->prepare("DELETE FROM `items` WHERE `group_id`=?");
        $ires->execute(array($group));
	}

	public function ClearGeneral($group) {
		$oldgeneral=$this->pdo->prepare("SELECT `general_id` FROM `general` WHERE `group_id`=?");
    	$oldgeneral->execute(array($group));
    	while ($old=$oldgeneral->fetch()) {
	        $this->ClearItems($old['general_id']);
	        $this->ClearRup($old['general_id']);
	    }
	    $oldres=$this->pdo->prepare("DELETE FROM `general` WHERE `group_id`=?");
	    $oldres->execute(array($group));
	}

    public function ClearProgram($program) {
        $delete=$this->pdo->prepare("DELETE FROM `ktps` WHERE `program_id`=?");
        $delete->execute(array($_GET['id']));
        $deleteitems=$this->pdo->prepare("DELETE FROM `ktpitems` WHERE `program_id`=?");
        $deleteitems->execute(array($_GET['id']));

        //достаем итемы по годам
        $genres=$this->pdo->prepare("SELECT `general_id` FROM `ruprograms` WHERE `program_id`=?");
        $genres->execute(array($_GET['id']));
        $general_id=$genres->fetch()['general_id'];
        $itemres=$this->pdo->prepare("SELECT * FROM `items` WHERE `general_id`=? ORDER BY `kurs_num`, `totalkurs` DESC");
        $itemres->execute(array($general_id));
        $items=$itemres->fetchAll();

        //удаляем все старое
        foreach ($items as $key => $item) {
            $this->ClearLessons($item['item_id']);
        }
        return $items;
    }

    public function ResetAll() {
        $this->ResetPlans();
        $this->pdo->query("SET FOREIGN_KEY_CHECKS=1");
        $this->pdo->query("TRUNCATE TABLE `cmks`");
        $this->pdo->query("TRUNCATE TABLE `groups`");
        $this->pdo->query("TRUNCATE TABLE `specializations`");
        $this->pdo->query("TRUNCATE TABLE `students`");
        $this->pdo->query("TRUNCATE TABLE `subjects`");
        $this->pdo->query("TRUNCATE TABLE `teachers`");
        $this->pdo->query("TRUNCATE TABLE `types`");
        $this->pdo->query("TRUNCATE TABLE `users`");
    }

    public function ResetPlans() {
        $this->ResetItems();
        $this->pdo->query("TRUNCATE TABLE `general`");
    }

    public function ResetItems() {
        $this->pdo->query("SET FOREIGN_KEY_CHECKS=1");
        $this->pdo->query("TRUNCATE TABLE `items`");
        $this->pdo->query("TRUNCATE TABLE `ktpitems`");
        $this->pdo->query("TRUNCATE TABLE `ktps`");
        $this->pdo->query("TRUNCATE TABLE `lessons`");
        $this->pdo->query("TRUNCATE TABLE `parts`");
        $this->pdo->query("TRUNCATE TABLE `ratings`");
        $this->pdo->query("TRUNCATE TABLE `rupitems`");
        $this->pdo->query("TRUNCATE TABLE `ruprograms`");
        $this->pdo->query("TRUNCATE TABLE `schedule_items`");
    }
}