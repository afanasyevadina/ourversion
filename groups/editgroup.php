<?php
require_once('../connect.php');
require_once('../api/group.php');
$gf=new Group($pdo);
if(isset($_POST['submit'])) {	
	$gf->Update(array($_POST['name'],
	 $_POST['specialization'], 
	 $_POST['base'], 
	 $_POST['year'], 
	 $_POST['lang'], 
	 $_POST['kurator'], 
	 $_POST['id']));
}
?>