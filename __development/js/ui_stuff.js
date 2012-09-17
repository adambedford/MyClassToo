//JavaScript Document
//Jquery UI scripts
//Dialog calls, confirmation messages etc

$(document).ready(function() {
	
	$(".ui_ajax_dialog").click(function(event) {
		
		//$('body').append('<div id="ui_dialog_container"></div>');
		
		//stop default click action
		event.preventDefault();
		//get the url to be loaded
		var dialogSrc = $(this).attr("href");
		var isolate = $(this).attr("isol");
		
		if(!$(this).attr("d_height")) {
			var height = 'auto';
		} else {
			var height = $(this).attr("d_height");
		}
		
		if (!$(this).attr("d_width")) {
			var width = 'auto';
		} else {
			var width = $(this).attr("d_width");
		}
		
		var title = $(this).attr("title");
		//define config object
		var dialogOpts = {
				title: title,
				modal: true,
				height: height,
				width: width,
				};
				
		$("#ui_dialog_container").load(dialogSrc+isolate,'',function() {
			
			$("#ui_dialog_container").dialog(dialogOpts);
		});		

					
		
	});
	
	
	
	
	
	
	
	
	
});