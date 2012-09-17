// JavaScript Document
//Switch the displayed term when dropdown changed in /resources/modules/schedule/view_full.php

$('#sched_termselect_sel').change(function() {
	
	var redirect = $(this).val();
	
	top.location.href = redirect;
	
});
