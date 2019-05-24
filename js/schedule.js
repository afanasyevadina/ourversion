function Modal(text) {
		$('.modal').html(text);
		$('.modal').show();
		setTimeout(function(){
			$('.modal').hide();
		}, 5000);
	}

	function Numerate() {
		$('tbody').each(function(d){
			let day=$(this).data('day');
			$(this).find('td.list_box').each(function(i) {
				$(this).find('.sortable').each(function(j){
					$(this).attr('data-num', i+1);
					$(this).attr('data-day', day);
					if($(this).parent().find('.separator').length>0) {
						$(this).attr('data-week', $(this).nextAll('.separator').length>0 ? 1 : 2);
					}
					else {
						$(this).attr('data-week', 0);
					}
					$(this).find('li').each(function(e){
						$(this).attr('data-num', i+1);
						$(this).attr('data-day', day);
					});
				});
			});			
		});
	}

	function Update() {
		$('table').find('span').remove();
		$( ".sortable" ).sortable({
			revert: true,
			connectWith: ".sortable",
			receive: function(e,ui){
				var res=[];
				if($('table').hasClass('changes')) {
					res.push($('#date').val());
				}
				else {
					res.push($(this).data('day'));
				}

				res.push($(this).data('num'));
				res.push($('#courses').val());
				res.push($('#sems').val());
				res.push(ui.item.data('teacher'));
				
				const $this=$(this);
				var url=$('table').hasClass('changes')?'schedule/checkchange.php':'schedule/checkmain.php';

				$.ajax({
					url: url,
					method: 'POST',
					dataType: 'html',
					data: 'data='+JSON.stringify(res),
					success: function(response) {
						if(response) {
							Modal(response);
							console.log(response);
							$this.find('li[data-id='+ui.item.data('id')+']').last().css('background-color', '#FCDD9E');
						}
					},
					error: function() {
						alert('error');
					}

				});

				if($(this).find('li').not('.empty').length>1) {

					if($(this).find('li[data-teacher='+ui.item.data('teacher')+']').length>1) {
						$(this).find('li[data-teacher='+ui.item.data('teacher')+']').first().remove();
					}

					if(!ui.item.hasClass('half')&&$(this).find('li').not('.empty').length>2) {
						$(this).find('li[data-num]').remove();
					}
					if($(this).find('li').not('.empty').length>1&&
						($(this).find('li').length>2||
						$(this).find('li').not('.half').length>1)) {
						$(this).find('li[data-num]').first().remove();
					}
					if($(this).find('li.half').length>=1) {
						if(!ui.item.hasClass('half')) {
							$(this).find('li[data-num]').first().remove();
						}
					}					
				}	
				$('.sortable[data-day='+ui.item.data('day')+'][data-num='+ui.item.data('num')+']').each(function(){	
				console.log(ui.item.data('num'));
					if($(this).find('li').length<1) {
						$(this).append('<li class="empty ui-sortable-handle"></li>');
					}
				});		
				$(this).find('.empty').last().remove();
				$(this).find('li[data-id='+ui.item.data('id')+']').addClass('inner_lesson');
				Update();
				Numerate();
			}
		});
		$( "#droppable" ).droppable({
	      drop: function( event, ui ) {
	      	if(!ui.draggable.hasClass('empty')&&ui.draggable.is('table li')) {
	      		$('.sortable[data-num='+ui.draggable.data('num')+'][data-day='+ui.draggable.data('day')+']')
	      		.append('<li class="empty ui-sortable-handle"></li>');
	      		ui.draggable.remove();
	      		Numerate();
	      	}	        
	      }
	    });
		$( "ul, li" ).disableSelection();
	}
	$(document).ready(function() {
		Update();
		Numerate();		

		$('table').on('click', '.divide', function(){
			if($(this).parent().find($('.separator')).length==0) {
				$(this).parent().find('.list_box').append('<div class="separator"></div>');
				let ul=$(this).parent().find('.sortable').clone();
				let li=ul.find('li').first().clone();
				if(!li.hasClass('empty')) {
					li.addClass('empty');
					li.removeAttr('data-teacher');
					li.removeAttr('data-id');
					li.html('');
				}
				ul.html(li);
				$(this).parent().find('.list_box').append(ul);
				Update();
			}	
			else {
				$(this).parent().find('.separator').nextAll().remove();
				$(this).parent().find('.separator').remove();
			}	
			Update();	
		});

		$('#saverasp').click(function(){
			let res=[];
			$('.sortable li').not('.empty').each(function(i)
			{
				let temp=[];
				temp.push($(this).data('num'));
				temp.push($(this).data('day'));
				temp.push($(this).data('id'));
				temp.push($('#sems').val());
				temp.push($('#groups').val());
				temp.push($(this).parent().data('week'));
				res.push(temp);
			});
			$.ajax({
				url: 'schedule/saveschedule.php',
				method: 'POST',
				dataType: 'html',
				data: 'data='+JSON.stringify(res)+'&group='+$('#groups').val(),
				success: function(response) {
					console.log(response);
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

		$('#savechanges').click(function(){
			let res=[];
			$('.sortable li').not('.empty').each(function(i)
			{
				let temp=[];
				temp.push($('#date').val());
				temp.push($(this).data('num'));
				temp.push($(this).data('id'));
				res.push(temp);
			});
			$.ajax({
				url: 'schedule/savechanges.php',
				method: 'POST',
				dataType: 'html',
				data: 'data='+JSON.stringify(res)+'&group='+$('#groups').val()+'&date='+$('#date').val(),
				success: function(response) {
					console.log(response);
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

		$('table').on('click', '.cab_num', function(){
			console.log('schedule/main_cabinets.php?day='
				+$(this).parent().find('.sortable').data('day')
				+'&num='+$(this).parent().find('.sortable').data('num'));
			Load('schedule/main_cabinets.php?day='
				+$(this).parent().find('.sortable').data('day')
				+'&num='+$(this).parent().find('.sortable').data('num'),
				 '#cabs_list');
			$('#cabs_list').show();
		});
	});
