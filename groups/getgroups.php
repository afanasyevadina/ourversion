<?php
require_once('../connect.php');
require_once('../api/group.php');
$gf=new Group($pdo);
$list=$gf->GetGroups();
foreach($list as $group) { ?>
	<tr>
		<td class="name"><?=$group['group_name']?></td>
		<td><?=$group['base']?></td>
		<td><?=($group['s1']==0)?'':$group['s1']?><?=($group['lps']==1)?"+ЛПС":""?></td>
		<td><?=($group['s2']==0)?'':$group['s2']?><?=($group['lps']==2)?"+ЛПС":""?></td>
		<td><?=($group['s3']==0)?'':$group['s3']?><?=($group['lps']==3)?"+ЛПС":""?></td>
		<td><?=($group['s4']==0)?'':$group['s4']?><?=($group['lps']==4)?"+ЛПС":""?></td>
		<td><?=($group['s5']==0)?'':$group['s5']?><?=($group['lps']==5)?"+ЛПС":""?></td>
		<td><?=($group['s6']==0)?'':$group['s6']?><?=($group['lps']==6)?"+ЛПС":""?></td>
		<td><?=($group['s7']==0)?'':$group['s7']?><?=($group['lps']==7)?"+ЛПС":""?></td>
		<td><?=($group['s8']==0)?'':$group['s8']?><?=($group['lps']==8)?"+ЛПС":""?></td>
		<td class="edit" id="<?=$group['group_id']?>"><img src="img/writing.svg"></td>
	</tr>
<?php } ?>