// JavaScript Document
// Add AJAX functionality to forms with the 'jq_ajax_submit' class

$(document).ready(function() {
	
	$('.jq_ajax_submit').submit(function(event) {
		
		event.preventDefault();
		var form = $(this);
		var url = this.action+'?ajax=true';
		var method = this.method;	
		var data = $(this).serialize();
		
		form.fadeOut('slow',function() {
			form.html('<div class="big_loader"><img src="/img/layout/big_loader.gif" class="load_gif"></div>');
			form.css('display','block'); 
		});
		
		$.ajax({
			
			url: url,
			type: method,
			data: data,
			cache: false,
			success: function(data) {
				var response = $('#response',data);
//				alert(response);
				form.replaceWith(response);
				form.fadeIn('slow');
			}
			
			
		});
		
	});
	
	
	
	
	
	
});