<?php
require_once('facecontrol.php');
require_once('api/group.php');
$gf=new Group($pdo);
$list=$gf->GetGroups();
?>
<!DOCTYPE html>
<html>
<head>
	<title>План УП</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script src="js/jquery-3.3.1.min.js"></script>
	<script src="js/jquery.form.min.js"></script>
	<script src="js/script.js"></script>
</head>
<body>
	<div id="fon"></div>
	<div id="uploadform">
		<form action="ups/uploadup.php" method="post" enctype="multipart/form-data" class="uploadform">
			<img src="img/close.png" class="cancelnew" alt="close">
	        <div>
	            <div>
					<label for="group">Группа: </label>
				</div>
					<div>							
						<select name="group" id="group">
							<?php foreach($list as $group) { ?>
								<option value="<?=$group['group_id']?>"><?=$group['group_name']?></option>
							<?php } ?>
						</select>
					</div>
	            <div>
	                <input type="file" name="upload" accept="application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" />
	            </div>
	        </div>
	        <div>
	            <div>
	                <input type="submit" value="Отправить"/>
	            </div>
	        </div>
	    </form>
	</div>
	<?php require_once('layout.php'); ?>
	<div class="container">
		<div class="main">
			<h2>План учебного процесса</h2>
			<div class="options">
				<select id="upgroupselect">
					<?php foreach($list as $group) { ?>}
					<option value="<?=$group['group_id']?>"><?=$group['group_name']?></option>
				<?php } ?>
				</select>
			</div>
			<div class="links">
				<a href="templates/up.xlsx" class="download">Скачать шаблон</a>
				<a href="" id="downloadup" class="download">Скачать</a>
				<?php if ($user['account_type']=='admin') { ?>
					<a id="upload" href="#">Загрузить из файла</a>
				    <a href="" id="generaterup" class="generate">Сгенерить РУПы</a>
				    <a href="" id="save" class="save">Сохранить</a>
				<?php } ?>
			</div>
			<div id="success" class="success">
				<h3>Изменения сохранены.</h3>
			</div>
			<div id="error" class="error">
				<h3>Ошибка! Изменения не сохранены.</h3>
			</div>
			<table id="up" border="1" class="hasitog">
				<thead id="headgroup">
					<tr>
						<th rowspan="5" class="header-center">№ п/п</th>
						<th rowspan="5" class="header-center">Наименование УД</th>
						<th colspan="3" class="header-center">Распределение по семестрам</th>
						<th rowspan="5" class="header-center">К-во к/р</th>
						<th colspan="4" class="header-center">Количество часов</th>
						<th colspan="8" class="header-center">Распределение по курсам и семестрам</th>
						<?php if($user['account_type']=='admin') { ?>
							<th rowspan="5"></th>
						<?php } ?>
					</tr>
					<tr>
						<th rowspan="4">экзаменов</th>
						<th rowspan="4">зачет</th>
						<th rowspan="4">курс. проект</t4>
						<th rowspan="4" class="header-center">Всего</th>
						<th colspan="3" rowspan="2" class="header-center">Из них</th>
						<th colspan="2" class="header-center">1 курс</th>
						<th colspan="2" class="header-center">2 курс</th>
						<th colspan="2" class="header-center">3 курс</th>
						<th colspan="2" class="header-center">4 курс</th>
					</tr>
					<tr id="weeks"></tr>
					<tr>
						<th rowspan="2">теорет.</th>
						<th rowspan="2">практ.</th>
						<th rowspan="2">курс. проект.</th>
						<th>н</th>
						<th>н</th>
						<th>н</th>
						<th>н</th>
						<th>н</th>
						<th>н</th>
						<th>н</th>
						<th>н</th>
					</tr>
					<tr>
						<th>1 сем</th>
						<th>2 сем</th>
						<th>3 сем</th>
						<th>4 сем</th>
						<th>5 сем</th>
						<th>6 сем</th>
						<th>7 сем</th>
						<th>8 сем</th>
					</tr>
				</thead>
				<tr>
					<td class="header-center" >1</td>
					<td class="header-center" >2</td>
					<td class="header-center" >3</td>
					<td class="header-center" >4</td>
					<td class="header-center" >5</td>
					<td class="header-center" >6</td>
					<td class="header-center" >7</td>
					<td class="header-center" >8</td>
					<td class="header-center" >9</td>
					<td class="header-center" >10</td>
					<td class="header-center" >11</td>
					<td class="header-center" >12</td>
					<td class="header-center" >13</td>
					<td class="header-center" >14</td>
					<td class="header-center" >15</td>
					<td class="header-center" >16</td>
					<td class="header-center" >17</td>
					<td class="header-center" >18</td>
					<?php if($user['account_type']=='admin') { ?>
						<td class="header-center"></td>
					<?php } ?>
				</tr>
				<tbody id="uptbody">					
				</tbody>
			</table>
		</div>
	</div>
	<footer></footer>
	<script type="text/javascript">
		$(document).ready(function(){
		$.ajax({
			url: 'ups/getup.php?group='+$('#upgroupselect').val(),
			dataType: 'html',
			success: function(response) {
				$('#weeks').html(response.split('separator')[0]);
				$('#uptbody').html(response.split('separator')[1]);
				$('#downloadup').attr('href', 'ups/downloadup.php?group='+$('#upgroupselect').val());
				$('#generaterup').attr('href', 'rups/generaterups.php?group='+$('#upgroupselect').val());
				$('#group').val($('#upgroupselect').val());
			},
			error: function() {
				alert('error');
			}
		});
		$('table').on('change blur input', 'td.subjectinput input', function() {
			$(this).parent().parent().attr('class', 'edited');
			const $this=$(this);
			var has='';
			var index='';
			$('#subjects').find('option').each(function(i){
				if($(this).html()==$this.val())	{
					index=$(this).data('index');
					has=$(this).data('id');
				}
			});
			$this.parent().attr('data-id', has);
			$this.parent().parent().find('td.subject_index').html(index);
		});
		$('#save').click(function(e){	
			e.preventDefault();		
			var res=[];
			$('#up tbody').find('tr.edited').each(function(i){
				var temp=[];
				$(this).find('td').each(function(i){
					if(!$(this).hasClass('deleteitem_up')) {
						temp.push($(this).hasClass('subjectinput')?$(this).data('id'):$(this).html());
					}
				});
				temp.push($(this).attr('id'));
				res.push(temp);
			});
			$.ajax({
				url: 'ups/updateup.php',
				dataType: 'html',
				method: 'POST',
				data: 'data='+JSON.stringify(res),
				success: function(response) {
					$('tr.edited').removeClass('edited');
					$('#success').css('display', 'block');
					setTimeout(function(){
						$('#success').css('display', 'none');
					}, 2000);
				},
				error: function(){
					$('#error').css('display', 'block');
					setTimeout(function(){
						$('#error').css('display', 'none');
					}, 2000);
				}
			});
		});
		$('body').on('focus', '[contenteditable]', function() {
	        const $this = $(this);
	        $this.data('before', $this.html());
		}).on('blur keyup paste input', '[contenteditable]', function() {
	    const $this = $(this);
	    if(($.isNumeric($this.html())&&parseInt($this.html(), 10)>=0)||$this.html()=='') {
	    	let tr=$this.parent();
	    	let a=tr.find('td.theory-td').html()==''?0:parseInt(tr.find('td.theory-td').html(),10);
	    	let b=tr.find('td.practice-td').html()==''?0:parseInt(tr.find('td.practice-td').html(),10);
	    	let c=tr.find('td.project-td').html()==''?0:parseInt(tr.find('td.project-td').html(),10);
	    	let sem1=tr.find('td.s1-td').html()==''?0:parseInt(tr.find('td.s1-td').html(),10);
	    	let sem2=tr.find('td.s2-td').html()==''?0:parseInt(tr.find('td.s2-td').html(),10);
	    	let sem3=tr.find('td.s3-td').html()==''?0:parseInt(tr.find('td.s3-td').html(),10);
	    	let sem4=tr.find('td.s4-td').html()==''?0:parseInt(tr.find('td.s4-td').html(),10);
	    	let sem5=tr.find('td.s5-td').html()==''?0:parseInt(tr.find('td.s5-td').html(),10);
	    	let sem6=tr.find('td.s6-td').html()==''?0:parseInt(tr.find('td.s6-td').html(),10);
	    	let sem7=tr.find('td.s7-td').html()==''?0:parseInt(tr.find('td.s7-td').html(),10);
	    	let sem8=tr.find('td.s8-td').html()==''?0:parseInt(tr.find('td.s8-td').html(),10);
	    	tr.find('td.total-td').html(a+b+c==0?'':a+b+c);
	    	let total=0;
	    	let theory=0;
	    	let practice=0;
	    	let project=0;
	    	let s1=0;
	    	let s2=0;
	    	let s3=0;
	    	let s4=0;
	    	let s5=0;
	    	let s6=0;
	    	let s7=0;
	    	let s8=0;
	    	$('td.total-td').each(function(i) {
	    		total+=$(this).html()==''?0:parseInt($(this).html(),10);
	    	});
	    	$('td.theory-td').each(function(i) {
	    		theory+=$(this).html()==''?0:parseInt($(this).html(),10);
	    	});
	    	$('td.practice-td').each(function(i) {
	    		practice+=$(this).html()==''?0:parseInt($(this).html(),10);
	    	});
	    	$('td.project-td').each(function(i) {
	    		project+=$(this).html()==''?0:parseInt($(this).html(),10);
	    	});
	    	$('td.s1-td').each(function(i) {
	    		s1+=$(this).html()==''?0:parseInt($(this).html(),10);
	    	});
	    	$('td.s2-td').each(function(i) {
	    		s2+=$(this).html()==''?0:parseInt($(this).html(),10);
	    	});
	    	$('td.s3-td').each(function(i) {
	    		s3+=$(this).html()==''?0:parseInt($(this).html(),10);
	    	});
	    	$('td.s4-td').each(function(i) {
	    		s4+=$(this).html()==''?0:parseInt($(this).html(),10);
	    	});
	    	$('td.s5-td').each(function(i) {
	    		s5+=$(this).html()==''?0:parseInt($(this).html(),10);
	    	});
	    	$('td.s6-td').each(function(i) {
	    		s6+=$(this).html()==''?0:parseInt($(this).html(),10);
	    	});
	    	$('td.s7-td').each(function(i) {
	    		s7+=$(this).html()==''?0:parseInt($(this).html(),10);
	    	});
	    	$('td.s8-td').each(function(i) {
	    		s8+=$(this).html()==''?0:parseInt($(this).html(),10);
	    	});
	    	$('td.itogo-total-td').html(total==0?'':total);
	    	$('td.itogo-theory-td').html(theory==0?'':theory);
	    	$('td.itogo-practice-td').html(practice==0?'':practice);
	    	$('td.itogo-project-td').html(project==0?'':project);
	    	$('td.itogo-s1-td').html(s1==0?'':s1);
	    	$('td.itogo-s2-td').html(s2==0?'':s2);
	    	$('td.itogo-s3-td').html(s3==0?'':s3);
	    	$('td.itogo-s4-td').html(s4==0?'':s4);
	    	$('td.itogo-s5-td').html(s5==0?'':s5);
	    	$('td.itogo-s6-td').html(s6==0?'':s6);
	    	$('td.itogo-s7-td').html(s7==0?'':s7);
	    	$('td.itogo-s8-td').html(s8==0?'':s8);			

	    	if((a+b+c)!=(sem1+sem2+sem3+sem4+sem5+sem6+sem7+sem8)) {
	    		$this.css('background-color', '#ECB7B7');
				$(this).css('color', '#400000');
	    	}
	    	else {
	    		tr.find('td').css('background-color', '#fff');
				tr.find('td').css('color', '#000');
	    	}

		    if ($this.data('before') !== $this.html()) {
		        $(this).data('before', $this.html());
		        $(this).parent().attr('class', 'edited');
		    }
		}
		else {
			$this.css('background-color', '#ECB7B7');
			$(this).css('color', '#400000');
		}
	});

		$('table').on('click', 'td.additem_up', function(){
			const $this=$(this).parent();
			$.ajax({
				url: 'ups/getsubjects.php',
				data: 'id='+$this.attr('id')+'&group='+$('#upgroupselect').val(),
				method: 'POST',
				dataType: 'html',
				success: function(response) {
					console.log(response);
					$this.after(response);
				}
			});
		});
		$('table').on('click', 'td.deleteitem_up', function(){
			$.ajax({
				url: 'ups/deleteup.php',
				dataType: 'html',
				data: 'id='+$(this).parent().attr('id'),
				method: 'POST',
				success: function(response) {
					$.ajax({
						url: 'ups/getup.php?group='+$('#upgroupselect').val(),
						dataType: 'html',
						success: function(response) {
							$('#weeks').html(response.split('separator')[0]);
							$('#uptbody').html(response.split('separator')[1]);
							$('#downloadup').attr('href', 'ups/downloadup.php?group='+$('#upgroupselect').val());
							$('#generaterup').attr('href', 'rups/generaterups.php?group='+$('#upgroupselect').val());
						},
						error: function() {
							alert('error');
					}
				});
			}
		});
	});

	$('table').on('click', 'td.subjectinput', function() {
		const $this=$(this);
		if($this.find('input').length==0) {
			var text=$this.html();
			$('td.subjectinput').each(function() {
				$this.html($this.find('input').val());
			});
			$.ajax({
				url: 'ups/getlist.php',
				data: 'id='+$this.parent().data('part')+'&old='+text,
				method: 'POST',
				dataType: 'html',
				success: function(response) {
					$this.html(response);
				}
			});
		}
	});
	$(document).mouseup(function (e){ // событие клика по веб-документу
		var div = $("td.subjectinput"); // тут указываем ID элемента
		if (!div.is(e.target) // если клик был не по нашему блоку
		    && div.has(e.target).length === 0) { // и не по его дочерним элементам
			$('td.subjectinput').each(function() {
				$(this).html($(this).find('input').val());
			});
		}
	});
	$('table').on('change', 'td.subjectinput input', function() {
		$(this).parent().parent().attr('class', 'edited');
	})
	});
	</script>
</body>
</html>