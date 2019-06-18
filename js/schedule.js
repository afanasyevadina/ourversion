var toDelete=[];
function Modal(text) {
		$('.modal').html(text);
		$('.modal').show();
		setTimeout(function(){
			$('.modal').hide();
		}, 5000);
	}

	function Numerate() {
		//all schedule
		$('tbody').each(function(d){
			//current day
			let day=$(this).data('day');
			//each cell in table
			$(this).find('td.list_box').each(function(i) {
				//each item of schedule
				$(this).find('.sortable').each(function(j){
					$(this).attr('data-num', i+1); //number of lesson
					$(this).attr('data-day', day); //day of week

					//if divided to ch/zn
					if($(this).parent().find('.separator').length>0) {
						//before or after separator
						$(this).attr('data-week', $(this).nextAll('.separator').length>0 ? 1 : 2);
					}
					else {
						$(this).attr('data-week', 0);
					}
					//numerating all items of list
					$(this).find('li').each(function(e){
						$(this).attr('data-num', i+1);
						$(this).attr('data-day', day);
					});
				});
			});			
		});
	}

	function FillEmpty() {
		$('.sortable').each(function() {
			if($(this).find('li').length<1) {
				$(this).append('<li class="empty ui-sortable-handle"></li>');
			}
		});
	}

	function Update() {
		//removing count of gone lessons
		$('table').find('i.hours').remove();
		$( ".sortable" ).sortable({
			revert: true,
			connectWith: ".sortable",
			receive: function(e,ui){
				//let's suppose that i try set some item to this place in schedule...
				var res={};
				//get the day which schedule is setted to
				if($('table').hasClass('changes')) {
					res['date']=$('#date').val();
				}
				else {
					res['date']=$(this).data('day');
					res['course']=$('#courses').val(); //num of course
					res['sem']=$('#sems').val(); //num of sem
				}

				res['num']=$(this).data('num'); //num of lesson
				res['teacher']=ui.item.data('teacher'); //who teaches this subject
				
				const $this=$(this);
				var url=$('table').hasClass('changes')?'schedule/checkchange.php':'schedule/checkmain.php'; //where should i send data to?

				$.ajax({
					url: url,
					method: 'POST',
					dataType: 'html',
					data: 'data='+JSON.stringify(res),
					success: function(response) {
						//НАЛОЖЕНИЕ!!1!
						if(response) {
							Modal(response);
							//highlight the item with НАЛОЖЕНИЕ
							$this.find('li[data-id='+ui.item.data('id')+']').last().css('background-color', '#FCDD9E');
						}
					},
					error: function() {
						alert('error');
					}

				});

				//ok, there is no conflict... yet...

				//if there already is something
				if($(this).find('li').not('.empty').length>1) {

					//if there is an item with the same teacher, remove it
					if($(this).find('li[data-teacher='+ui.item.data('teacher')+']').length>1) {
						$(this).find('li[data-teacher='+ui.item.data('teacher')+']').first().remove();
					} 

					//if i moved here an item with full group and here are more than 2 items, remove it
					if(!ui.item.data('subgroup')&&$(this).find('li').not('.empty').length>2) {
						$(this).find('li[data-num]').remove();
					}
					if($(this).find('li[data-subgroup=0]').length>0) {
						$(this).find('li[data-num]').first().remove();
					}
					if($(this).find('li[data-subgroup=1]').length>=1||$(this).find('li[data-subgroup=2]').length>=1) { //there is some place, but only for subgroup, not for you
						if(!ui.item.data('subgroup')) {
							$(this).find('li[data-num]').first().remove();
						}
					}					
				}

				FillEmpty();

				$(this).find('.empty').last().remove(); //now you aren't just an empty place

				$(this).find('li[data-id='+ui.item.data('id')+']').addClass('inner_lesson');

				//if i moved the item from list, i need to add a *cell* for cabinet number
				if(!ui.item.hasClass('inner_lesson')) {
					let cab = !! ui.item.data('c_name') ? ui.item.data('c_name') : '';
					$(this).find('li[data-id='+ui.item.data('id')+']').append('<div class="cab_num">'+cab+'</div>');
					$(this).find('li[data-id='+ui.item.data('id')+']').attr('data-cab', ui.item.data('cab'));
				}
				$(this).find('li[data-id='+ui.item.data('id')+']').addClass('edited');
				Update();
				Numerate();
			}
		});
		$( "#droppable" ).droppable({
	      drop: function( event, ui ) {
	      	FillEmpty();
	      	if(!ui.draggable.hasClass('empty')&&ui.draggable.is('table li')) {
	      		toDelete.push(ui.draggable.data('s_item'));
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
			//if there isn't an separator
			if($(this).parent().find($('.separator')).length==0) {
				//add line
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
				//append empty listbox after line
				$(this).parent().find('.list_box').append(ul);
				Update();
			}	
			else {
				//delete line and items after it
				$(this).parent().find('.separator').nextAll().remove();
				$(this).parent().find('.separator').remove();
			}	
			Update();	
		});

		$('#saverasp').click(function(){
			let res=[];
			$('.sortable li.edited').not('.empty').each(function(i)
			{
				let temp={};
				temp['num']=$(this).data('num');
				temp['day']=$(this).data('day');
				temp['cab']=!!$(this).data('cab') ? $(this).data('cab') : '';
				temp['id']=$(this).data('id');
				temp['course']=$('#courses').val();
				temp['sem']=$('#sems').val();
				temp['group']=$('#groups').val();
				temp['week']=$(this).parent().data('week');
				temp['subgroup']=$(this).data('subgroup');
				res.push(temp);
			});
			$.ajax({
				url: 'schedule/saveschedule.php',
				method: 'POST',
				dataType: 'html',
				data: 'data='+JSON.stringify(res)+'&group='+$('#groups').val()+'&delete='+JSON.stringify(toDelete),
				success: function(response) {
					console.log(response);
					$('.edited').removeClass('edited');
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
				let temp={};
				temp['date']=$('#date').val();
				temp['num']=$(this).data('num');
				temp['cab']=$(this).data('cab');
				temp['teacher']=$(this).data('teacher');
				temp['id']=$(this).data('id');
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

		$('table').on('click', '.teacher', function(){
			//setting the current cell which we're working with...
			$('.teacher').removeClass('current');
			$(this).addClass('current');

			//loading available cabinets...
			Load('schedule/loadteachers.php?date='
				+$('#date').val()
				+'&num='+$(this).parent().data('num'),
				 '#teachers_list');
			$('#teachers_list').show();
		});

		$('table').on('click', '.cab_num', function(){
			//setting the current cell which we're working with...
			$('.cab_num').removeClass('current');
			$(this).addClass('current');

			//loading available cabinets...
			if($('table').hasClass('changes')) {
				Load('schedule/cabinets_today.php?date='
				+$('#date').val()
				+'&num='+$(this).parent().data('num'),
				 '#cabs_list');
			} else {
				Load('schedule/main_cabinets.php?day='
				+$(this).parent().data('day')
				+'&num='+$(this).parent().data('num'),
				 '#cabs_list');
			}
			$('#cabs_list').show();
		});

		$(document).mouseup(function (e){ // событие клика по веб-документу
			var div = $("#cabs_list"); // тут указываем ID элемента
			if (!div.is(e.target) // если клик был не по нашему блоку
			    && div.has(e.target).length === 0) { // и не по его дочерним элементам
				$("#cabs_list").hide();
				$('.cab_num').removeClass('current');
			}
		});

		$(document).mouseup(function (e){ // событие клика по веб-документу
			var div = $("#teachers_list"); // тут указываем ID элемента
			if (!div.is(e.target) // если клик был не по нашему блоку
			    && div.has(e.target).length === 0) { // и не по его дочерним элементам
				$("#teachers_list").hide();
				$('.teacher').removeClass('current');
			}
		});

		$('#cabs_list').on('click', '.cabinet', function(){
			//setting data to item
			$('.cab_num.current').parent().attr('data-cab', $(this).data('id'));
			$('.cab_num.current').parent().addClass('edited');

			//showing name of cabinet
			$('.cab_num.current').html($(this).data('name'));
			$("#cabs_list").hide();
		});

		$('#teachers_list').on('click', '.teacher', function(){
			//setting data to item
			$('.teacher.current').parent().attr('data-teacher', $(this).data('id'));
			$('.teacher.current').parent().addClass('edited');

			//showing name of cabinet
			$('.teacher.current').html($(this).data('name'));
			$("#teachers_list").hide();
		});
	});
