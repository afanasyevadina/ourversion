<?php
require_once('../connect.php');
require_once('../api/group.php');
$gf=new Group($pdo);
if(isset($_POST['submit'])) {	
	$gf->Update(array($_POST['name'], $_POST['specialization'], $_POST['base'], $_POST['s1'], $_POST['s2'], $_POST['s3'], $_POST['s4'], $_POST['s5'], $_POST['s6'], $_POST['s7'], $_POST['s8'], $_POST['lps'], $_POST['year'], $_POST['count'], $_POST['id']));
}
?>