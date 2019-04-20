<?php
require_once('../connect.php');
require_once('../api/ruprogram.php');
$rf=new Ruprogram($pdo);
$id=$rf->AddTopic($_POST['part'], $_POST['program']);
?>
<tr id="<?=$id?>" data-part="<?=$_POST['part']?>" class="item">
	<td class="itemnum"></td>
	<td contenteditable="true"></td>
	<td class="total" contenteditable="true">2</td>
	<td class="lpz" contenteditable="true"></td>
	<td class="deletetopic"><img src="img/trash.svg"></td>
</tr>