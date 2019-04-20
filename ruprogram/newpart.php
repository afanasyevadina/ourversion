<?php
require_once('../connect.php');
require_once('../api/ruprogram.php');
$rf=new Ruprogram($pdo);
$id=$rf->AddPart($_POST['program']);
?>
<tr data-part="<?=$id?>" class="partitem">
	<td class="node hide"><img src="img/minus.svg"></td>
	<td class="part_name" contenteditable="true" colspan="2"></td>
	<td class="addtopic"><img src="img/add.svg"></td>
	<td class="deletepart"><img src="img/trash.svg"></td>
</tr>