<?php
require_once('connect.php');
require_once('api/clear.php');
$clear=new Clear($pdo);
if(isset($_GET['action'])) {
	switch ($_GET['action']) {
		case 'all':
			$clear->ResetAll();
			break;
		
		case 'plans':
			$clear->ResetPlans();
			break;

		case 'items':
			$clear->ResetItems();
			break;
	}
	header('Location: /');
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Reset</title>
	<meta charset="utf-8">
	<style type="text/css">
		a {
			display: block;
			width: 200px;
			margin-left: 50px;
			text-decoration: none;
			color: #000;
			font-size: 25px;
			padding: 10px;
			transition: 0.5s;
			opacity: 0.8;
		}
		a:hover {
			transform: translateX(10px);
			opacity: 1;
		}
	</style>
</head>
<body>
	<a href="reset.php?action=all">Reset All ></a>
	<a href="reset.php?action=items">Reset Items ></a>
	<a href="reset.php?action=plans">Reset Plans ></a>
</body>
</html>