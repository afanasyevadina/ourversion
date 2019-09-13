<?php
require_once('connect.php');
setcookie('user', null, time()-3600);
$warning='';
if(!empty($_POST)) {
	$res=$pdo->prepare("SELECT * FROM `users` WHERE `login`=? AND `password`=?");
	$res->execute(array($_POST['login'], md5($_POST['password'])));
	if($user=$res->fetch()) {
		setcookie('user', $user['hash'], time()+3600*24*30);
		header('Location: /');
	}
	else {
		$warning='Неверные данные ввели Вы, уважаемый.';
	}
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Вход</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<meta charset="utf-8">
	<style type="text/css">
		body {
			background-color: #ddd;
		}
	</style>
</head>
<body>
	<div class="fixed-top">
		<div class="lang">
			<a href="#">RU </a><a href="#">KZ</a>
		</div>
	</div>
	<div class="login">
		<form action="login.php" method="post">
			<p class="login-header">Авторизация</p>
			<p class="warning"><?=$warning?></p>
			<input type="text" name="login" id="login" placeholder="Login" autocomplete="off" autofocus>
			<input type="password" name="password" id="password" placeholder="Password">
			<input type="submit" value="Войти">
		</form>
	</div>
</body>
</html>