function Load(url, body) {
	$.ajax({
		url: url,
		dataType: 'html',
		method: 'POST',
		success: function(response) {
			$(body).html(response);
		}
	});
}
function close() {
	$('#add').css('display', 'none');
	$('#fon').css('display', 'none');
	$('#uploadform').css('display', 'none');
	$('#groupform').attr('action', 'groups/savegroup.php');
	$('#teacherform').attr('action', 'teachers/saveteacher.php');
	$('#subjectform').attr('action', 'subjects/savesubject.php');
	$('#specform').attr('action', 'specializations/savespecialization.php');
	$('.delete').css('display', 'none');
	$('#groupform').trigger('reset');
	$('#teacherform').trigger('reset');
	$('#subjectform').trigger('reset');
	$('#specform').trigger('reset');
	$('#studentform').trigger('reset');
}
$(document).ready(function(){
	$('#new').click(function(e){
		e.preventDefault();
		$('#add').css('display', 'flex');
		$('#fon').css('display', 'block');
	});

	$('#upload').click(function(e) {
		e.preventDefault();
		$('#uploadform').css('display', 'flex');
		$('#fon').css('display', 'block');
	});

	$('.cancelnew').click(function(){
		close();
	});

	$('i').click(function(){
		var tr=$('tr').last();
		$('table').append("<tr>"+tr.html()+"</tr>");
		$('td').attr('contenteditable', 'true');
		$('tr').last().find('td').html('');
	});
	$('#groupform').ajaxForm({
		dataType: 'html',
		success: function(response) {
			close();
			Load('groups/getgroups.php', '#groups tbody');
		}
	});
	$('#teacherform').ajaxForm({
		dataType: 'html',
		success: function(response) {
			close();
			Load('teachers/getteachers.php', '#teachers tbody');
		}
	});
	$('#studentform').ajaxForm({
		dataType: 'html',
		success: function(response) {
			close();
			$.ajax({
				url: 'students/getstudents.php',
				method: 'POST',
				data: 'group='+$('#stdgroupselect').val()+'&subgroup='+$('#subgroupselect').val(),
				dataType: 'html',
				success: function(result) {
					if(!result.split('endcount')[0]) {
						$('.subgroup').hide();
						$('#subgroupselect').hide();
						$('#subgroupselect').val(0);
					} else {
						$('.subgroup').show();
						$('#subgroupselect').show();
					}
					$('#students tbody').html(result.split('endcount')[1]);
				}
			});
		}
	});
	$('#subjectform').ajaxForm({
		dataType: 'html',
		success: function(response) {
			close();
			Load('subjects/getsubjects.php', '#subjects tbody');
		}
	});	
	$('#specform').ajaxForm({
		dataType: 'html',
		success: function(response) {
			close();
			Load('specializations/getspecializations.php', '#specializations tbody');
		}
	});	
	$('#groups tbody').on('click', '.edit', function(){
		$.ajax({
			url: 'groups/aboutgroup.php',
			dataType: 'html',
			data: 'id='+$(this).attr('id'),
			method: 'POST',
			success: function(response) {
				result=$.parseJSON(response);
				$('#id').val(result.group_id);
				$('#name').val(result.group_name);
				$('#lang').val(result.lang);
				if(result.base==9) { $('#base9').attr('checked', 'checked'); }
				if(result.base==11) { $('#base11').attr('checked', 'checked'); }
				$('#specialization').val(result.specialization_id);
				$('#s1start').val(result.s1start);
				$('#s2start').val(result.s2start);
				$('#s3start').val(result.s3start);
				$('#s4start').val(result.s4start);
				$('#s5start').val(result.s5start);
				$('#s6start').val(result.s6start);
				$('#s7start').val(result.s7start);
				$('#s8start').val(result.s8start);
				$('#s1finish').val(result.s1finish);
				$('#s2finish').val(result.s2finish);
				$('#s3finish').val(result.s3finish);
				$('#s4finish').val(result.s4finish);
				$('#s5finish').val(result.s5finish);
				$('#s6finish').val(result.s6finish);
				$('#s7finish').val(result.s7finish);
				$('#s8finish').val(result.s8finish);
				$('#year').val(result.year);
				$('#count').html(result.count);
				$('#groupform').attr('action', 'groups/editgroup.php');
				$('#deletegroup').css('display', 'flex');
				$('#deletegroup').attr('href', 'groups/deletegroup.php?id='+result.group_id);
				$('#add').css('display', 'flex');
				$('#fon').css('display', 'block');
			},
			error: function() {
				alert('error');
			}
		});
	});
	$('#teachers tbody').on('click', '.edit', function(){
		$.ajax({
			url: 'teachers/aboutteacher.php',
			dataType: 'html',
			data: 'id='+$(this).attr('id'),
			method: 'POST',
			success: function(response) {
				result=$.parseJSON(response);
				$('#id').val(result.teacher_id);
				$('#fname').val(result.teacher_fname);
				$('#sname').val(result.teacher_sname);
				$('#tname').val(result.teacher_tname);
				$('#cmk').val(result.cmk_id);
				$('#teacherform').attr('action', 'teachers/editteacher.php');
				$('#deleteteacher').css('display', 'flex');
				$('#deleteteacher').attr('href', 'teachers/deleteteacher.php?id='+result.teacher_id);
				$('#add').css('display', 'flex');
				$('#fon').css('display', 'block');
			},
			error: function() {
				alert('error');
			}
		});
	});
	$('#students tbody').on('click', '.edit', function(){
		$.ajax({
			url: 'students/aboutstudent.php',
			dataType: 'html',
			data: 'id='+$(this).attr('id'),
			method: 'POST',
			success: function(response) {
				result=$.parseJSON(response);
				$('#id').val(result.student_id);
				$('#fname').val(result.student_fname);
				$('#sname').val(result.student_sname);
				$('#tname').val(result.student_tname);
				$('#group').val(result.group_id);
				$('#subgroup1').removeAttr('checked');
				$('#subgroup2').removeAttr('checked');
				if(result.subgroup=='1') { $('#subgroup1').attr('checked', 'checked'); }
				if(result.subgroup=='2') { $('#subgroup2').attr('checked', 'checked'); }
				$('#studentform').attr('action', 'students/editstudent.php');
				$('#deletestudent').css('display', 'flex');
				$('#deletestudent').attr('href', 'students/deletestudent.php?id='+result.student_id);
				$('#add').css('display', 'flex');
				$('#fon').css('display', 'block');
			},
			error: function() {
				alert('error');
			}
		});
	});
	$('#subjects tbody').on('click', '.edit', function(){
		$.ajax({
			url: 'subjects/aboutsubject.php',
			dataType: 'html',
			data: 'id='+$(this).attr('id'),
			method: 'POST',
			success: function(response) {
				result=$.parseJSON(response);
				$('#id').val(result.subject_id);
				$('#subjectname').val(result.subject_name);
				$('#subjectindex').val(result.subject_index);
				$('#pck').val(result.type_id);
				$('#cmk').val(result.cmk_id);
				$('#div' + result.divide).prop('checked', true);
				$('#subjectform').attr('action', 'subjects/editsubject.php');
				$('#deletesubject').css('display', 'flex');
				$('#deletesubject').attr('href', 'subjects/deletesubject.php?id='+result.subject_id);
				$('#add').css('display', 'flex');
				$('#fon').css('display', 'block');
			},
			error: function() {
				alert('error');
			}
		});
	});
	$('#specializations tbody').on('click', '.edit', function(){
		$.ajax({
			url: 'specializations/aboutspec.php',
			dataType: 'html',
			data: 'id='+$(this).attr('id'),
			method: 'POST',
			success: function(response) {
				result=$.parseJSON(response);
				$('#id').val(result.specialization_id);
				$('#name').val(result.specialization_name);
				$('#code').val(result.code);
				$('#courses').val(result.courses);
				$('#specform').attr('action', 'specializations/updatespecialization.php');
				$('#deletespec').css('display', 'flex');
				$('#deletespec').attr('href', 'specializations/deletespecialization.php?id='+result.specialization_id);
				$('#add').css('display', 'flex');
				$('#fon').css('display', 'block');
			},
			error: function() {
				alert('error');
			}
		});
	});
	$('#deletegroup').click(function(e){
		e.preventDefault();
		$.ajax({
			url: $(this).attr('href'),
			dataType: 'html',
			method: 'GET',
			success: function(response) {
				Load('groups/getgroups.php', '#groups tbody');
				close();
			},
			error: function() {
				alert('error');
			}
		});
	});
	$('#deletestudent').click(function(e){
		e.preventDefault();
		$.ajax({
			url: $(this).attr('href'),
			dataType: 'html',
			method: 'GET',
			success: function(response) {
				$.ajax({
				url: 'students/getstudents.php',
				method: 'POST',
				data: 'group='+$('#stdgroupselect').val()+'&subgroup='+$('#subgroupselect').val(),
				dataType: 'html',
				success: function(result) {
					if(!result.split('endcount')[0]) {
						$('.subgroup').hide();
						$('#subgroupselect').hide();
						$('#subgroupselect').val(0);
					} else {
						$('.subgroup').show();
						$('#subgroupselect').show();
					}
					$('#students tbody').html(result.split('endcount')[1]);
				}
			});
				close();
			},
			error: function() {
				alert('error');
			}
		});
	});
	$('#deletespec').click(function(e){
		e.preventDefault();
		$.ajax({
			url: $(this).attr('href'),
			dataType: 'html',
			method: 'GET',
			success: function(response) {
				Load('specializations/getspecializations.php', '#specializations tbody');
				close();
			},
			error: function() {
				alert('error');
			}
		});
	});
	$('#deleteteacher').click(function(e){
		e.preventDefault();
		$.ajax({
			url: $(this).attr('href'),
			dataType: 'html',
			method: 'GET',
			success: function(response) {
				Load('teachers/getteachers.php', '#teachers tbody');
				close();
			},
			error: function() {
				alert('error');
			}
		});
	});
	$('#deletesubject').click(function(e){
		e.preventDefault();
		$.ajax({
			url: $(this).attr('href'),
			dataType: 'html',
			method: 'GET',
			success: function(response) {
				Load('subjects/getsubjects.php', '#subjects tbody');
				close();
			},
			error: function() {
				alert('error');
			}
		});
	});
	$('#teacherselect').change(function(){
		$.ajax({
			url: 'personal/getpersonal.php?teacher='+$(this).val()+'&kurs='+$('#tkursselect').val(),
			dataType: 'html',
			method: 'GET',
			success: function(response) {
				$('#personal tbody').html(response);
				$('#downloadnagr').attr('href', 'personal/downloadnagr.php?teacher='+$('#teacherselect').val()+'&kurs='+$('#tkursselect').val());
			},
			error: function() {
				alert('error');
			}
		});
	});	
	$('#tkursselect').change(function(){
		$.ajax({
			url: 'personal/getpersonal.php?teacher='+$('#teacherselect').val()+'&kurs='+$('#tkursselect').val(),
			dataType: 'html',
			method: 'GET',
			success: function(response) {
				$('#personal tbody').html(response);
				$('#downloadnagr').attr('href', 'personal/downloadnagr.php?teacher='+$('#teacherselect').val()+'&kurs='+$('#tkursselect').val());
				$('#downloadform3').attr('href', 'personal/downloadform3.php?kurs='+$('#tkursselect').val());
			},
			error: function() {
				alert('error');
			}
		});
	});
	$('#groupselect').change(function(){
		$.ajax({
			url: 'rups/getrup.php?group='+$(this).val()+'&kurs='+$('#kursselect').val(),
			dataType: 'html',
			method: 'GET',
			success: function(response) {
				$('#rup tbody').html(response);
				$('#downloadrup').attr('href', 'rups/downloadrup.php?group='+$('#groupselect').val()+'&kurs='+$('#kursselect').val());
				$('#group').val()=$('#groupselect').val();
			},
			error: function() {
				alert('error');
			}
		});
	});
	$('#kursselect').change(function(){
		$.ajax({
			url: 'rups/getrup.php?group='+$('#groupselect').val()+'&kurs='+$(this).val(),
			dataType: 'html',
			method: 'GET',
			success: function(response) {
				$('#rup tbody').html(response);
				$('#downloadrup').attr('href', 'rups/downloadrup.php?group='+$('#groupselect').val()+'&kurs='+$('#kursselect').val());
			},
			error: function() {
				alert('error');
			}
		});
	});
	$('#upgroupselect').change(function(){
		$.ajax({
			url: 'ups/getup.php?group='+$(this).val(),
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
	});
	$('#stdgroupselect').change(function(){
		$.ajax({
			url: 'students/getstudents.php',
			method: 'POST',
			data: 'group='+$(this).val()+'&subgroup=0',
			dataType: 'html',
			success: function(result) {
				if(!result.split('endcount')[0]) {
					$('.subgroup').hide();
					$('#subgroupselect').hide();
				} else {
					$('.subgroup').show();
					$('#subgroupselect').show();
				}
				$('#students tbody').html(result.split('endcount')[1]);
			}
		});
	});

	$('#subgroupselect').change(function(){
		$.ajax({
			url: 'students/getstudents.php',
			method: 'POST',
			data: 'group='+$('#stdgroupselect').val()+'&subgroup='+$(this).val(),
			dataType: 'html',
			success: function(result) {
				$('#students tbody').html(result.split('endcount')[1]);
			}
		});
	});

	$('table').on('change', 'th input[type=checkbox]', function(){
		$('table').find('input[type=checkbox]').attr('checked', $(this).prop('checked'));
	});
	$('table').on('change', 'input[type=checkbox]', function(){
		if($('input[type=checkbox]:checked').length>0) {
			$('input[type=submit].generate').css('display', 'block');
		} else {
			$('input[type=submit].generate').css('display', 'none');
		}
	});
});