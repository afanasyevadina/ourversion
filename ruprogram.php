<?php
require_once('facecontrol.php');
require_once('api/ruprogram.php');
require_once('api/group.php');
$rf=new Ruprogram($pdo);
$gf=new Group($pdo);
//собственно план
$main=$rf->GetProgram($_GET['id']);

//разделы
$parts=$rf->GetParts($_GET['id']);

//часы, название предмета и прочая *****
$items=$rf->GetItems($main['general_id']);

$roman=['', 'I', 'II', 'III', 'IV'];
$teachers=array_unique(array_column($items, 'teacher_name'));

$contenteditable = $user['account_type'] == 'admin' ||
($user['account_type'] == 'teacher' && in_array($user['person_id'], array_column($items, 'teacher_id'))) ?
'contenteditable="true"' : '';

$items = $rf->SanitizeItems($items);

?>
<!DOCTYPE html>
<html>
<head>
	<title>Рабочая учебная программа</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/jquery.form.min.js"></script>
	<script src="js/script.js"></script>
</head>
<body>
	<?php require_once('layout.php'); ?>
	<div class="container">
		<div class="main">
			<h2>Рабочая учебная программа</h2>
			<div class="links">
				<?php if ($contenteditable) { ?> <a href="ktps/generatektp.php?id=<?=$_GET['id']?>" id="generatektp" class="generate">Сгенерить КТП</a> <?php } ?>
				<a href="ruprogram/downloadprogram.php?id=<?=$_GET['id']?>" class="download">Скачать РУП</a>
			</div>
			<p class="shapka">Қазақстан Республикасының Білім және ғылым мининстрлігі</p>
			<p class="shapka">"Павлодар бизнес-колледжі" КМҚК</p>
			<p class="shapka">Министерство образования и науки Республики Казахстан</p>
			<p class="shapka">КГКП "Павлодарский бизнес-колледж"</p>
			<p class="shapka">Оқу жұмыс бағдарламасы</p>
			<p class="shapka">Рабочая учебная программа</p>
			<p>Оқытушы/Преподавателя <u><?=trim(implode(', ', $teachers), ',')?></u></p>
			<p><u>"<?=$items[0]['subject_name']?>"</u> пәні бойынша жұмыс бағдарламасы типтік бағдарлама 2015 ж. "24" тамыз тіркеу №4209 негізінде құрастырылған.</p>
			<p>Рабочая программа разработана на основании типовой программы по дисциплине <u>"<?=$items[0]['subject_name']?>"</u> регистрационный №4209 от "24" августа 2015 г.</p>
			<p><?=$items[0]['code']?> "<?=$items[0]['specialization_name']?>" мамандығы үшін</p>
			<p>Для специальности <?=$items[0]['code']?> "<?=$items[0]['specialization_name']?>"</p>

			<p class="center">Оқыту сағаттарын бөлу</p>
			<p class="center">Распределение учебного времени</p>

			<?php if ($contenteditable) { ?> <a href="" id="savetime" class="save">Сохранить</a> <?php } ?>
			<div id="timesuccess" class="success">
				<h3>Изменения сохранены.</h3>
			</div>
			<div id="timeerror" class="error">
				<h3>Ошибка! Изменения не сохранены.</h3>
			</div>

			<table border="1" id="time" data-theory="<?=$item['theory']?>" data-lpr="<?=$item['lpr']?>" data-kurs="<?=$item['kurs']?>">
				<thead>
					<tr>
						<th rowspan="3">Курс</th>
						<th rowspan="3">Барлық сағат/ всего часов</th>
						<th colspan="8">Оның ішінде/из них</th>
					</tr>
					<tr>
						<th colspan="2">Теориялық сабақ/ теоретических занятий</th>
						<th colspan="2">Зертхана жұмысы/ лабораторные работы</th>
						<th colspan="2">Тәжірибе сабағы/ практические занятия</th>
						<th colspan="2">Курстық жұмыстар/ курсовых работ</th>
					</tr>
					<tr>
						<th>Сем. №1</th><th>Сем. №2</th><th>Сем. №1</th><th>Сем. №2</th><th>Сем. №1</th><th>Сем. №2</th><th>Сем. №1</th><th>Сем. №2</th>
					</tr>
				</thead>
				<?php foreach ($items as $key => $item) { 
					$current=substr($item['kurs_num'], 0, 4);
					if($items[0]['base']==9) {
						$kurs=intval($current)-intval($item['year'])+1; 
					}
					else {
						$kurs=intval($current)-intval($item['year'])+2;
					}
					?>
					<tr data-item="<?=$item['item_id']?>" class="total_hours" data-first="<?=$item['sem1']?>" data-second="<?=$item['sem2']?>">
						<td><?=$roman[$kurs]?></td>
						<td class="kurs_hours"><?=$item['totalkurs']?></td>
						<td class="sem_hours theory1" <?=$contenteditable?>><?=$item['theory1']==0?'':$item['theory1']?></td>
						<td class="sem_hours theory2" <?=$contenteditable?>><?=$item['theory2']==0?'':$item['theory2']?></td>
						<td class="sem_hours lab1" <?=$contenteditable?>><?=$item['lab1']==0?'':$item['lab1']?></td>
						<td class="sem_hours lab2" <?=$contenteditable?>><?=$item['lab2']==0?'':$item['lab2']?></td>
						<td class="sem_hours prac1" <?=$contenteditable?>><?=$item['pract1']==0?'':$item['pract1']?></td>
						<td class="sem_hours prac2" <?=$contenteditable?>><?=$item['pract2']==0?'':$item['pract2']?></td>
						<td class="sem_hours kurs1" <?=$contenteditable?>><?=$item['kurs1']==0?'':$item['kurs1']==0?></td>
						<td class="sem_hours kurs2" <?=$contenteditable?>><?=$item['kurs2']==0?'':$item['kurs2']?></td>
					</tr>
				<?php } ?>
			</table>
			<p class="center">Топтарда оқылатын пән</p>
			<p class="center">Предмет изучается в группах</p>
			<table border="1">
				<thead>
					<tr>
						<th>Оқу жылы/учебный год</th>
						<th>Курстың нөмірі/номер курса</th>
						<th>Топтың шифрі/шифр группы</th>
					</tr>
				</thead>
				<?php foreach ($items as $key => $item) { 
					$current=substr($item['kurs_num'], 0, 4);
					if($items[0]['base']==9) {
						$kurs=intval($current)-intval($item['year'])+1; 
					}
					else {
						$kurs=intval($current)-intval($item['year'])+2;
					}
					?>
					<tr>
						<td><?=$item['kurs_num']?></td>
						<td><?=$roman[$kurs]?></td>
						<td><?=$gf->GetName($item)?></td>
					</tr>
				<?php } ?>
			</table>
			<h4>2. ТЕМАТИЧЕСКИЙ ПЛАН</h4>
			<?php if ($contenteditable) { ?> <a href="" id="save" class="save">Сохранить</a> <?php } ?>

			<div id="success" class="success">
				<h3>Изменения сохранены.</h3>
			</div>
			<div id="error" class="error">
				<h3>Ошибка! Изменения не сохранены.</h3>
			</div>
			<table border="1">
				<thead>
					<tr>
						<th rowspan="2">№ п/п</th>
						<th rowspan="2">Наименование разделов и тем</th>
						<th colspan="2">Количество учебного времени</th>
						<?php if ($contenteditable) { ?> <th rowspan="2" class="addpart"><img src="img/add.svg"></th> <?php } ?>
					</tr>
					<tr><th>всего</th><th>лпз</th></tr>
				</thead>
				<tbody id="programitems">
					<?php foreach ($parts as $key => $part) { ?>
						<tr data-part="<?=$part['part_id']?>" class="partitem">
							<td class="node hide"><img src="img/minus.svg"></td>
							<td <?=$contenteditable?> class="part_name" colspan="2"><?=$part['part_name']?></td>
							<?php if ($contenteditable) { ?> <td class="addtopic"><img src="img/add.svg"></td>
							<td class="deletepart"><img src="img/trash.svg"></td> <?php } ?>
						</tr>
						<?php
						$collection=$rf->GetPartItems($part['part_id']);
						foreach($collection as $item) {  ?>
							<tr id="<?=$item['rupitem_id']?>" data-part="<?=$part['part_id']?>" class="item">
								<td class="itemnum"><?=$item['rupitem_num']?></td>
								<td <?=$contenteditable?>><?=$item['rupitem_name']?></td>
								<td class="total" <?=$contenteditable?>><?=$item['item_theory']+$item['item_practice']==0?'':$item['item_theory']+$item['item_practice']?></td>
								<td class="lpz" <?=$contenteditable?>><?=$item['item_practice']==0?'':$item['item_practice']?></td>
								<?php if ($contenteditable) { ?> <td class="deletetopic"><img src="img/trash.svg"></td> <?php } ?>
							</tr>
						<?php }
					} ?>
				</tbody>
				<tr>
					<td></td><td>Всего учебного времени по дисциплине</td>
					<td class="totalhours"><?=$items[0]['totalrup']?></td><td class="lpzhours" id="vsegolpr"><?=$items[0]['lprrup']?></td>
				</tr>
			</table>

			<?php if ($contenteditable) { ?> <a href="" id="saveaims" class="save">Сохранить</a> <?php } ?>
			<div id="aimsuccess" class="success">
				<h3>Изменения сохранены.</h3>
			</div>
			<div id="aimerror" class="error">
				<h3>Ошибка! Изменения не сохранены.</h3>
			</div>
			<table border="1">
				<thead>
					<tr>
						<th rowspan="2">№</th>
						<th rowspan="2">Кол-во часов</th>
						<th rowspan="2">Основные вопросы, темы</th>
						<th colspan="4">Цель дидактического процесса</th>
						<th rowspan="2">Состав методического комплекса</th>
					</tr>
					<tr>
						<th>представления</th><th>знания</th><th>умения</th><th>навыки</th>
					</tr>
					<tbody id="aims">						
					</tbody>
				</thead>
			</table>
			<h4>5. ПЕРЕЧЕНЬ ЛАБОРАТОРНО-ПРАКТИЧЕСКИХ РАБОТ</h4>	
			<?php if ($contenteditable) { ?> <a href="" id="savelprs" class="save">Сохранить</a> <?php } ?>
			<div id="lprsuccess" class="success">
				<h3>Изменения сохранены.</h3>
			</div>
			<div id="lprerror" class="error">
				<h3>Ошибка! Изменения не сохранены.</h3>
			</div>		
			<table border="1">
				<thead>
					<tr>
						<th>№ занятия. Наименование темы</th><th>Кол-во часов</th><th>Содержание лабораторной работы</th>
					</tr>
				</thead>
				<tbody id="lpz">					
				</tbody>
				<tr>
					<td>Всего:</td><td><?=$items[0]['lprrup']?></td><td></td>
				</tr>
			</table>
		</div>
	</div>
	<footer></footer>
	<input type="hidden" id="id" value="<?=$main['program_id']?>">
	<script type="text/javascript">
		function numerate() {
			var num=1;
			$('td.itemnum').each(function(i) {
				$(this).html(num);
				num++;
			});
		}
		function getData() {
			$.ajax({
				url: 'ruprogram/getlpz.php',
				data: 'id='+$('#id').val(),
				dataType: 'html',
				method: 'POST',
				success: function(response) {
					$('#lpz').html(response);
				},
				error: function() {
					alert('error');
				}
			});
			$.ajax({
				url: 'ruprogram/getaims.php',
				data: 'id='+$('#id').val(),
				dataType: 'html',
				method: 'POST',
				success: function(response) {
					$('#aims').html(response);
				},
				error: function() {
					alert('error');
				}
			});
		}

		var canadd=true;
		var isReady=false;
		function showLink() {
			if(isReady) {
				$('#generatektp').css('display', 'block');
			}
			else {
				$('#generatektp').css('display', 'none');
			}
		}
		function checkHours() {
			var total=0;
		    	$('td.total').each(function() {
		    		total+=$(this).html()==''?0:parseInt($(this).html());
		    	});
		    	if(parseInt($('.totalhours').html())==total) {
		    		$('.totalhours').css('background-color', '#B0EBCC');
		    		canadd=false;
		    		isReady=true;
		    	}
		    	else {
		    		if(parseInt($('.totalhours').html())<total) {
		    			$('.totalhours').css('background-color', '#ECB7B7');
		    			canadd=false;
		    		}
		    		else {
			    		$('.totalhours').css('background-color', '#fff');
			    		canadd=true;
			    	}
		    		isReady=false;
		    	}
		    	var lpz=0;
		    	$('td.lpz').each(function() {
		    		lpz+=$(this).html()==''?0:parseInt($(this).html());
		    	});
		    	if(parseInt($('.lpzhours').html())==lpz||$('.lpzhours').html()==''&&lpz==0) {
		    		$('.lpzhours').css('background-color', '#B0EBCC');
		    		isReady=true;
		    	}
		    	else {
		    		if(parseInt($('.lpzhours').html())<lpz||($('.lpzhours').html()==''&&lpz>0)) {
		    			$('.lpzhours').css('background-color', '#ECB7B7');
		    		}
		    		else {
		    			$('.lpzhours').css('background-color', '#fff');
		    		}
		    		isReady=false;
		    	}
		}
		function checkTime() {
			var lpr=0;
			$('tr.total_hours').each(function(i){
				let t1=$(this).find('.theory1').html()==''?0:parseInt($(this).find('.theory1').html(),10);
			    let t2=$(this).find('.theory2').html()==''?0:parseInt($(this).find('.theory2').html(),10);
			    let l1=$(this).find('.lab1').html()==''?0:parseInt($(this).find('.lab1').html(),10);
			    let l2=$(this).find('.lab2').html()==''?0:parseInt($(this).find('.lab2').html(),10);
			    let p1=$(this).find('.prac1').html()==''?0:parseInt($(this).find('.prac1').html(),10);
			    let p2=$(this).find('.prac2').html()==''?0:parseInt($(this).find('.prac2').html(),10);
			    let k1=$(this).find('.kurs1').html()==''?0:parseInt($(this).find('.kurs1').html(),10);
			    let k2=$(this).find('.kurs2').html()==''?0:parseInt($(this).find('.kurs2').html(),10);
			    if($(this).find('.kurs_hours').html()!=(t1+t2+l1+l2+p1+p2+k1+k2)||
			    	$(this).data('first')!=t1+l1+p1+k1||
			    	$(this).data('second')!=t2+l2+p2+k2) {
			    	$(this).find('.kurs_hours').css('background-color', '#ECB7B7');
			    	isReady=false;
			    }
			    else {
			    	$(this).find('.kurs_hours').css('background-color', '#fff');	
			    	isReady=true;	    		
			    }
			    lpr+=l1;
			    lpr+=l2;
			    lpr+=p1;
			    lpr+=p2;
			});
			if($('#vsegolpr').html()==lpr||$('#vsegolpr').html()==''&&lpr==0) {
				$('#vsegolpr').css('background-color', '#B0EBCC');	
			} 
			else {
				$('#vsegolpr').css('background-color', '#ECB7B7');
			}
		}
		numerate();
		getData();
		checkHours();
		checkTime();
		showLink();
		
		$('table').on('click', '.addpart', function() {
			$.ajax({
				url: 'ruprogram/newpart.php',
				data: 'program='+$('#id').val(),
				dataType: 'html',
				method: 'POST',
				success: function(response) {
					$('#programitems').append(response);
				},
				error: function() {
					alert('error');
				}
			});
		});
		$('table').on('click', '.addtopic', function() {
			if(canadd) {
				const $this=$(this).parent();
				$.ajax({
					url: 'ruprogram/newtopic.php',
					data: 'part='+$this.data('part')+'&program='+$('#id').val(),
					dataType: 'html',
					method: 'POST',
					success: function(response) {
						console.log(response);
						if($('tr.item[data-part='+$this.data('part')+']').length==0) {
							$this.after(response);
						}
						else {
							$('tr.item[data-part='+$this.data('part')+']').last().after(response);
						}
						numerate();
						checkHours();
					},
					error: function() {
						alert('error');
					}
				});
			}
		});
		$('table').on('click', '.deletetopic', function() {
			const $this=$(this).parent();
			$.ajax({
				url: 'ruprogram/deletetopic.php',
				data: 'id='+$this.attr('id'),
				dataType: 'html',
				method: 'POST',
				success: function(response) {
					$this.remove();
					numerate();
					checkHours();
				},
				error: function() {
					alert('error');
				}
			});
		});
		$('table').on('click', '.deletepart', function() {
			const $this=$(this).parent();
			$.ajax({
				url: 'ruprogram/deletepart.php',
				data: 'id='+$this.data('part'),
				dataType: 'html',
				method: 'POST',
				success: function(response) {
					$('tr[data-part='+$this.data('part')+']').remove();
					numerate();
					checkHours();
				},
				error: function() {
					alert('error');
				}
			});
		});
		$('#save').click(function(e){	
			e.preventDefault();		
			var partres=[];
			var index=1;
			$('#programitems').find('tr.partitem').each(function(i){
				var temp=[];
				temp.push(index);
				index++;
				temp.push($(this).find('td.part_name').html());
				var hours=0;
				$('tr.item[data-part='+$(this).data('part')+']').each(function(i){
					hours+=$(this).find('td.total').html()==''?0:parseInt($(this).find('td.total').html());
				});
				temp.push(hours);
				temp.push($(this).data('part'));
				partres.push(temp);
			});
			var itemres=[];
			$('#programitems').find('tr.item').each(function(i){
				var temp=[];
				$(this).find('td').each(function(i){
					if(!$(this).hasClass('deletetopic')) {
						temp.push($(this).html());
					}
				});
				temp.push($(this).attr('id'));
				itemres.push(temp);
			});
			$.ajax({
				url: 'ruprogram/updateprogram.php',
				dataType: 'html',
				method: 'POST',
				data: 'parts='+JSON.stringify(partres)+'&items='+JSON.stringify(itemres),
				success: function(response) {
					$('#success').css('display', 'block');
					setTimeout(function(){
						$('#success').css('display', 'none');
					}, 2000);
					getData();
				},
				error: function(){
					$('#error').css('display', 'block');
					setTimeout(function(){
						$('#error').css('display', 'none');
					}, 2000);
				}
			});
			showLink();
		});
		$('body').on('focus', 'td.total[contenteditable], td.lpz[contenteditable]', function() {
	        const $this = $(this);
	        $this.data('before', $this.html());
		}).on('blur keyup paste input', 'td.total[contenteditable], td.lpz[contenteditable]', function() {
		    const $this = $(this);
		    if(($.isNumeric($this.html())&&parseInt($this.html(), 10)>=0)||$this.html()=='') {
		    	checkHours();
		    }
		});

		$('body').on('focus', 'td.sem_hours[contenteditable]', function() {
	        const $this = $(this);
	        $this.data('before', $this.html());
		}).on('blur keyup paste input', 'td.sem_hours[contenteditable]', function() {
		    const $this = $(this);
		    if(($.isNumeric($this.html())&&parseInt($this.html(), 10)>=0)||$this.html()=='') {
		    	checkTime();
		    }
		});
		$('#saveaims').click(function(e){
			e.preventDefault();
			var res=[];
			$('#aims').find('tr').each(function(i) {
				var temp=[];
				$(this).find('td[contenteditable]').each(function(i) {
					temp.push($(this).html());
				});
				temp.push($(this).data('part'));
				res.push(temp);
			});
			$.ajax({
				url: 'ruprogram/saveaims.php',
				method: 'POST',
				data: 'data='+JSON.stringify(res),
				dataType: 'html',
				success: function(response) {
					$('#aimsuccess').css('display', 'block');
					setTimeout(function(){
						$('#aimsuccess').css('display', 'none');
					}, 2000);
				},
				error: function(){
					$('#aimerror').css('display', 'block');
					setTimeout(function(){
						$('#aimerror').css('display', 'none');
					}, 2000);
				}
			});			
			if(isReady) {
				$('#generatektp').css('display', 'block');
			}
			else {
				$('#generatektp').css('display', 'none');
			}
		});
		$('#savelprs').click(function(e){
			e.preventDefault();
			var res=[];
			$('#lpz').find('tr').each(function(i) {
				var temp=[];
				temp.push($(this).find('td.content').html());
				temp.push($(this).data('id'));
				res.push(temp);
			});
			$.ajax({
				url: 'ruprogram/savelprs.php',
				method: 'POST',
				data: 'data='+JSON.stringify(res),
				dataType: 'html',
				success: function(response) {
					$('#lprsuccess').css('display', 'block');
					setTimeout(function(){
						$('#lprsuccess').css('display', 'none');
					}, 2000);
				},
				error: function(){
					$('#lprerror').css('display', 'block');
					setTimeout(function(){
						$('#lprerror').css('display', 'none');
					}, 2000);
				}
			});
			showLink();
		});
		$('#savetime').click(function(e){
			e.preventDefault();
			var res=[];
			$('#time').find('tr').each(function(i) {
				var temp=[];
				$(this).find('td[contenteditable]').each(function(i) {
					temp.push($(this).html());
				})
				temp.push($(this).data('item'));
				res.push(temp);
			});
			$.ajax({
				url: 'ruprogram/savetime.php',
				method: 'POST',
				data: 'data='+JSON.stringify(res),
				dataType: 'html',
				success: function(response) {
					$('#timesuccess').css('display', 'block');
					setTimeout(function(){
						$('#timesuccess').css('display', 'none');
					}, 2000);
				},
				error: function(){
					$('#timeerror').css('display', 'block');
					setTimeout(function(){
						$('#timeerror').css('display', 'none');
					}, 2000);
				}
			});
			showLink();
		});
		$('table').on('click', '.hide', function(){
			//$('tr.item[data-part='+$(this).parent().data('part')+']').css('display', 'none');
			$('tr.item[data-part='+$(this).parent().data('part')+']').hide();
			$(this).removeClass('hide');
			$(this).addClass('show');
			$(this).html("<img src='img/plus.svg'/>");
		});

		$('table').on('click', '.show', function(){
			//$('tr.item[data-part='+$(this).parent().data('part')+']').css('display', 'table');
			$('tr.item[data-part='+$(this).parent().data('part')+']').show();
			$(this).removeClass('show');
			$(this).addClass('hide');
			$(this).html("<img src='img/minus.svg'/>");
		});
	</script>
</body>
</html>