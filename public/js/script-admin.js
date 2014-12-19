$('.popover-info').popover({
	trigger: 'hover',
	container: 'body',
	html: true,
	placement: 	'right'
});

$('.btn-group').mouseover(function() {
  	$('.popover-info').popover('hide')
});