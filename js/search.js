$('.query').on('input', function() {
	var query = $(this).val();
	$('.searchable').each(function() {
		if($(this).html().toLowerCase().indexOf(query.toLowerCase()) != -1) {
			$(this).show();
		} else {
			$(this).hide();
		}
	});
});