<?php
require_once('../connect.php');
if(!empty($_POST['name'])) {
	$ready=[];
	$to_print=[];
	$count=0;
	foreach ($_POST['name'] as $key => $value) {
		$password="";
		$source="789456123";
		$size=6;
		while ($size--) {
			$password.=$source[rand(0,strlen($source)-1)];
		}
		switch ($_POST['type']) {
			case 'teacher':
				$nameres=$pdo->prepare("SELECT `teacher_name` FROM `teachers` WHERE `teacher_id`=?");
				$nameres->execute(array($value));
				$name=$nameres->fetch()['teacher_name'];
				break;
			
			case 'student':
				$nameres=$pdo->prepare("SELECT `student_name` FROM `students` WHERE `student_id`=?");
				$nameres->execute(array($value));
				$name=$nameres->fetch()['student_name'];
				break;
		}
		
		$ready=array_merge($ready, [$value, $_POST['type'], implode('_', explode(' ', $name)), md5($password), md5(time().$name.'pasc')]);
		$to_print[]=[implode('_', explode(' ', $name)), $password];
		$count++;
	}
	$sql="INSERT INTO `users` (`person_id`, `account_type`, `login`, `password`, `hash`) VALUES ".str_repeat("(?,?,?,?,?),", $count-1)."(?,?,?,?,?) ON DUPLICATE KEY UPDATE `person_id`=VALUES(person_id), `account_type`=VALUES(account_type), `login`=VALUES(login), `password`=VALUES(password), `hash`=VALUES(hash)";
	$insert=$pdo->prepare($sql);
	$insert->execute($ready);
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Внимание, конфиденциальные данные!!!</title>
	<link rel="stylesheet" type="text/css" href="../css/style.css">
	<meta charset="utf-8">
	<style type="text/css">
		table {
			min-width: unset;
			margin: 30px;
		}
		th, td {
			padding: 15px;
		}
	</style>
</head>
<body>
<table border="1">
	<thead>
		<tr>
			<th>Логин</th>
			<th>Пароль</th>
		</tr>
	</thead>
<?php foreach ($to_print as $key => $value) { ?>
	<tr>
		<td><?=$value[0]?></td>
		<td><?=$value[1]?></td>
	</tr>
<?php } ?>	
</table>
</body>
</html>