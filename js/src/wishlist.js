// JavaScript Document
// JS and jQuery scripts relating to the Wishlist function

$(document).ready(function() {
	
	$("#wishlist_term_select_sel").change(function() {
		
		var redirect = $(this).val();
		
		top.location.href = redirect;
		
	});
	
	
	
});