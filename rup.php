<?php
$title = 'РУПЫ';
require_once('layout.php');
require_once('api/group.php');
$gf=new Group($pdo);
$groups=$gf->GetGroups();
$cmks=$gf->GetCmks();
$teachers=$gf->GetTeachers();
foreach ($teachers as $teacher) {
	$tArr[$teacher['cmk_id']][] = $teacher;
}
?>
	<div id="ihelpyou" hidden="hidden">
		<input type="text" list="teachers">
		<div class="teachers">
			<?php
			foreach($tArr as $cmk) { ?>
				<p class="optgroup" data-cmk="<?=$cmk[0]['cmk_id']?>"><?=$cmk[0]['cmk_name']?></p>
				<?php foreach($cmk as $teacher) { ?>
				<p data-cmk="<?=$teacher['cmk_id']?>" data-id="<?=$teacher['teacher_id']?>"><?=$teacher['teacher_name']?></p>
			<?php } 
			} ?>
		</div>
	</div>
	<div id="uploadform">
		<form action="rups/uploadrup.php" method="post" enctype="multipart/form-data" class="uploadform">
			<img src="img/close.png" class="cancelnew" alt="close">
	        <div>
	            <div>
					<label for="kursupl">Учебный год: </label>
				</div>
					<div>							
						<select name="kurs" id="kursupl">
							<option>2018-2019</option>
							<option>2017-2018</option>
							<option>2016-2017</option>
							<option>2015-2016</option>
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
	<div class="container">
		<div class="main" style="width: 100%;margin: 0;">
			<h2>Рабочий учебный план</h2>
			<div class="options">
					<select id="groupselect">
						<?php foreach($groups as $group) { 
							$year=$group['year']; ?>
						<option value="<?=$group['group_id']?>"><?=$group['group_name']?></option>
					<?php } ?>
					</select>
					<select id="kursselect">
							<option>2019-2020</option>
							<option>2018-2019</option>
							<option>2017-2018</option>
							<option>2016-2017</option>
							<option>2015-2016</option>
					</select>
			</div>
			<div class="links">
			    <a href="" id="downloadrup" class="download">Скачать</a>
			    <?php if ($user['account_type']=='admin') { ?>
				    <a href="" id="sync" class="generate">Синхронизировать с Планом УП</a>
				    <a href="" id="save" class="save">Сохранить</a>
				<?php } ?>
			</div>
			<div id="success" class="success">
				<h3>Изменения сохранены.</h3>
			</div>
			<div id="error" class="error">
				<h3>Ошибка! Изменения не сохранены.</h3>
			</div>
			<table class="rup hasitog" border="1" id="rup">
				<thead id="headgroup">
					<tr>
						<th rowspan="2">Группа</th>
						<th rowspan="2">Подгруппа</th>
						<th rowspan="2">Преподаватели</th>
						<th rowspan="2">Наименование предмета</th>
						<th colspan="3">Распределение по семестрам</th>
						<th rowspan="2"><div>Контрольные работы</div></th>
						<th colspan="3">по РУП</th>
						<th rowspan="2"><div>Всего часов на учебный год</div></th>
						<th rowspan="2"><div>Снятие на ПД</div></th>
						<th rowspan="2"><div>Из них теоретических</div></th>
						<th rowspan="2"><div>Из них ЛПР</div></th>
						<th rowspan="2"><div>Из них курсовые работы</div></th>
						<th colspan="3">1 семестр</th>
						<th colspan="3">2 семестр</th>
						<th rowspan="2"><div>Консультации</div></th>
						<th rowspan="2"><div>Экзамены</div></th>
						<th rowspan="2"><div>Всего за год</div></th>
						<th rowspan="2">кол-во уч-ся ХР</th>
						<th rowspan="2">всего часов ХР</th>
						<th rowspan="2">всего часов МБ</th>
					</tr>
					<tr>
						<th><div>экзамены</div></th>
						<th><div>зачеты</div></th>
						<th><div>курсовые работы</div></th>
						<th><div>всего по РУП</div></th>
						<th><div>теоретические занятия</div></th>
						<th><div>лабораторно-практ. занятия</div></th>
						<th><div>Количество нед.</div></th>
						<th><div>часов в нед.</div></th>
						<th><div>часов в семестр</div></th>
						<th><div>Количество нед.</div></th>
						<th><div>часов в нед.</div></th>
						<th><div>часов в семестр</div></th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
	<footer></footer>
	<script type="text/javascript">
		$('#menucheck').attr('checked', 'checked');
		$(document).ready(function(){
		$.ajax({
			url: 'rups/getrup.php?group='+$('#groupselect').val()+'&kurs='+$('#kursselect').val(),
			dataType: 'html',
			method: 'GET',
			success: function(response) {
				$('#rup tbody').html(response);
				$('#downloadrup').attr('href', 'rups/downloadrup.php?group='+$('#groupselect').val()+'&kurs='+$('#kursselect').val());
				$('#generateup').attr('href', 'ups/generateup.php?group='+$('#groupselect').val());
				$('#group').val($('#groupselect').val());
			},
			error: function() {
				alert('error');
			}
		});
		$('#save').click(function(e){	
			e.preventDefault();		
			var res=[];
			$('#rup tbody').find('tr.edited').each(function(i){
				var temp=[];
				$(this).find('td').each(function(i){
					temp.push($(this).hasClass('teacherinput')?$(this).data('id'):$(this).html());
				});
				temp.push($('#kursselect').val());
				temp.push($(this).attr('id'));
				res.push(temp);
			});
			$.ajax({
				url: 'rups/updaterup.php',
				dataType: 'html',
				method: 'POST',
				data: 'group='+$('#groupselect').val()+'&kurs='+$('#kursselect').val()+'&data='+JSON.stringify(res),
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
		    	let a=tr.find('td.totalkurs-td').html()==''?0:parseInt(tr.find('td.totalkurs-td').html(),10);
		    	let b=tr.find('td.lpr-td').html()==''?0:parseInt(tr.find('td.lpr-td').html(),10);
		    	let c=tr.find('td.kurs-td').html()==''?0:parseInt(tr.find('td.kurs-td').html(),10);
		    	let d=tr.find('td.pd-td').html()==''?0:parseInt(tr.find('td.pd-td').html(),10);
		    	let e=tr.find('td.theory-td').html()==''?0:parseInt(tr.find('td.theory-td').html(),10);
		    	tr.find('td.theory-td').html(a-b-c-d==0?'':a-b-c-d);

		    	let at=tr.find('td.totalrup-td').html()==''?0:parseInt(tr.find('td.totalrup-td').html(),10);
		    	let bt=tr.find('td.lprrup-td').html()==''?0:parseInt(tr.find('td.lprrup-td').html(),10);
		    	tr.find('td.theoryrup-td').html(at-bt==0?'':at-bt);

		    	let w1=tr.find('td.week1-td').html()==''?0:parseInt(tr.find('td.week1-td').html(),10);
		    	let s1=tr.find('td.sem1-td').html()==''?0:parseInt(tr.find('td.sem1-td').html(),10);
		    	tr.find('td.hoursperweek1-td').html(s1/w1==0?'':Math.floor(s1/w1));

		    	let w2=tr.find('td.week2-td').html()==''?0:parseInt(tr.find('td.week2-td').html(),10);
		    	let s2=tr.find('td.sem2-td').html()==''?0:parseInt(tr.find('td.sem2-td').html(),10);
		    	tr.find('td.hoursperweek2-td').html(s2/w2==0?'':Math.floor(s2/w2));

		    	let ex=tr.find('td.examens-td').html()==''?0:parseInt(tr.find('td.examens-td').html(),10);
		    	let con=tr.find('td.consul-td').html()==''?0:parseInt(tr.find('td.consul-td').html(),10);
		    	tr.find('td.totalyear-td').html(s1+s2+ex+con==0?'':s1+s2+ex+con);

		    	let x=tr.find('td.totalyear-td').html()==''?0:parseInt(tr.find('td.totalyear-td').html(),10);
		    	let y=tr.find('td.hourxp-td').html()==''?0:parseInt(tr.find('td.hourxp-td').html(),10);
		    	tr.find('td.res-td').html(x-y==0?'':x-y);

		    	let totalrup=0;
		    	let totalyear=0;
		    	let totalkurs=0;
		    	let theoryrup=0;
		    	let lprrup=0;
		    	let theory=0;
		    	let lpr=0;
		    	let sem1=0;
		    	let sem2=0;
		    	let hourxp=0;
		    	let stdxp=0;
		    	let examens=0;
		    	let consul=0;
		    	let res=0;
		    	$('td.totalrup-td').each(function(i) {
		    		totalrup+=$(this).html()==''?0:parseInt($(this).html(),10);
		    	});
		    	$('td.totalkurs-td').each(function(i) {
		    		totalkurs+=$(this).html()==''?0:parseInt($(this).html(),10);
		    	});
		    	$('td.totalyear-td').each(function(i) {
		    		totalyear+=$(this).html()==''?0:parseInt($(this).html(),10);
		    	});
		    	$('td.theory-td').each(function(i) {
		    		theory+=$(this).html()==''?0:parseInt($(this).html(),10);
		    	});
		    	$('td.lpr-td').each(function(i) {
		    		lpr+=$(this).html()==''?0:parseInt($(this).html(),10);
		    	});
		    	$('td.theoryrup-td').each(function(i) {
		    		theoryrup+=$(this).html()==''?0:parseInt($(this).html(),10);
		    	});
		    	$('td.lprrup-td').each(function(i) {
		    		lprrup+=$(this).html()==''?0:parseInt($(this).html(),10);
		    	});
		    	$('td.sem1-td').each(function(i) {
		    		sem1+=$(this).html()==''?0:parseInt($(this).html(),10);
		    	});
		    	$('td.sem2-td').each(function(i) {
		    		sem2+=$(this).html()==''?0:parseInt($(this).html(),10);
		    	});
		    	$('td.hourxp-td').each(function(i) {
		    		hourxp+=$(this).html()==''?0:parseInt($(this).html(),10);
		    	});
		    	$('td.stdxp-td').each(function(i) {
		    		stdxp+=$(this).html()==''?0:parseInt($(this).html(),10);
		    	});
		    	$('td.examens-td').each(function(i) {
		    		examens+=$(this).html()==''?0:parseInt($(this).html(),10);
		    	});
		    	$('td.consul-td').each(function(i) {
		    		consul+=$(this).html()==''?0:parseInt($(this).html(),10);
		    	});
		    	$('td.res-td').each(function(i) {
		    		res+=$(this).html()==''?0:parseInt($(this).html(),10);
		    	});
		    	$('td.itogo-totalkurs-td').html(totalkurs==0?'':totalkurs);
		    	$('td.itogo-totalyear-td').html(totalyear==0?'':totalyear);
		    	$('td.itogo-theory-td').html(theory==0?'':theory);
		    	$('td.itogo-lpr-td').html(lpr==0?'':lpr);
		    	$('td.itogo-theoryrup-td').html(theoryrup==0?'':theoryrup);
		    	$('td.itogo-lprrup-td').html(lprrup==0?'':lprrup);
		    	$('td.itogo-sem1-td').html(sem1==0?'':sem1);
		    	$('td.itogo-sem2-td').html(sem2==0?'':sem2);
		    	$('td.itogo-hourxp-td').html(hourxp==0?'':hourxp);
		    	$('td.itogo-stdxp-td').html(stdxp==0?'':stdxp);
		    	$('td.itogo-examens-td').html(examens==0?'':examens);
		    	$('td.itogo-consul-td').html(consul==0?'':consul);
		    	$('td.itogo-res-td').html(res==0?'':res);

		    	if((b+c+d+e)!=(s1+s2)) {
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
		$('table').on('click', 'td.teacherinput', function() {
			if($(this).find('input').length==0) {
				var text=$(this).html();
				$('td.teacherinput').each(function() {
					$(this).html($(this).find('input').val());
				});
				$(this).html($('#ihelpyou').html());
				$(this).find('input').val(text);
				$(this).find('input').focus();
			}
		});
		$(document).mouseup(function (e){ // событие клика по веб-документу
			var div = $("td.teacherinput"); // тут указываем ID элемента
			if (!div.is(e.target) // если клик был не по нашему блоку
			    && div.has(e.target).length === 0) { // и не по его дочерним элементам
				$('td.teacherinput').each(function() {
					$(this).html($(this).find('input').val());
				});
			}
		});
		$('table').on('change blur input focus', 'td.teacherinput input', function() {
			$(this).parent().parent().attr('class', 'edited');
			const $this=$(this);
			var has='';
			/*$('#teachers').find('option').each(function(i){
				if($(this).html()==$this.val())	{
					has=$(this).data('id');
				}
			});*/
			$(this).parent().find('.teachers').find('p').not('.optgroup').each(function(i){
				if($(this).html().toLowerCase().indexOf($this.val().toLowerCase())!=-1) {
					$(this).show();
				} else {
					$(this).hide();
				}
				if($(this).html()==$this.val())	{
					has=$(this).data('id');
				}
			});
			$this.parent().attr('data-id', has);
		});
		$('#sync').click(function(e) {
			e.preventDefault();
			var res=[];
			var was=[];
			$('#rup tbody').find('tr[data-general]').each(function(i) {
				if($.inArray($(this).data('general'), was)==-1) {
					var temp=[];
					temp.push($(this).find('td.theoryrup-td').html()==''?0:$(this).find('td.theoryrup-td').html());
					temp.push($(this).find('td.lprrup-td').html()==''?0:$(this).find('td.lprrup-td').html());
					temp.push($(this).data('general'));
					res.push(temp);
				}
				was.push($(this).data('general'));
			});
			$.ajax({
				url: 'ups/syncup.php',
				data: 'data='+JSON.stringify(res),
				dataType: 'html',
				method: 'POST',
				success: function(response) {
					$('#success').css('display', 'block');
					setTimeout(function(){
						$('#success').css('display', 'none');
					}, 2000);
				},
				error: function() {
					$('#error').css('display', 'block');
					setTimeout(function(){
						$('#error').css('display', 'none');
					}, 2000);
				}
			});
		});

		$('table').on('click', '.subgroup', function(){
			let sg=$(this).html().trim()=='1'?'2':'1';
			$('tr[data-general='+$(this).parent().data('general')+']').find('.subgroup').html($(this).html());
			$(this).html(sg);
			$('tr[data-general='+$(this).parent().data('general')+']').addClass('edited');
			$(this).parent().addClass('edited');
		});

		/*$('table').on('click', '.teachers p.optgroup', function(){
			$(this).parent().find('p').not('.optgroup').hide();
			$(this).parent().find('p[data-cmk='+$(this).data('cmk')+']').show();
		});*/

		$('table').on('click', '.teachers p:not(.optgroup)', function(){
			$(this).parent().parent().find('input').val($(this).html());
			//$(this).parent().parent().attr('data-id', $(this).data('id'));
			$('td.teacherinput').each(function() {
				$(this).html($(this).find('input').val());
			});
			$(this).parent().parent().find('input').trigger('change');
		});
	});
	</script>
</body>
</html>