<?php
require_once('connect.php');
if(isset($_COOKIE['user'])) {
	$userres=$pdo->prepare("SELECT * FROM `users` WHERE `hash`=?");
	$userres->execute(array($_COOKIE['user']));
	if($user=$userres->fetch()) {
		switch ($user['account_type']) {
			case 'teacher':
				$accountres=$pdo->prepare("SELECT * FROM `teachers` WHERE `teacher_id`=?");
				$accountres->execute(array($user['person_id']));
				if(!$account=$accountres->fetch()) {
					header('Location: login.php');
				}
				else {
					$name=$account['teacher_name'];
				}
				break;
			case 'student':
				$accountres=$pdo->prepare("SELECT * FROM `students` WHERE `student_id`=?");
				$accountres->execute(array($user['person_id']));
				if(!$account=$accountres->fetch()) {
					header('Location: login.php');
				}
				else {
					$name=$account['student_name'];
				}
				break;
			case 'admin':
			$name='Администратор';
			break;			
		}
	}
	else {
		header('Location: login.php');
	}
}
else {
	header('Location: login.php');
}
$res = $pdo->prepare("SELECT * FROM permissions WHERE role=? OR role='*'");
$res->execute(array($user['account_type']));
$permissions = $res->fetchAll();
if(!in_array('*', array_column($permissions, 'route')) && 
	!in_array(basename($_SERVER['SCRIPT_NAME']), array_column($permissions, 'route'))) {
	header('Location: /');
}
?>