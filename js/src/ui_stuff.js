//JavaScript Document
//Jquery UI scripts
//Dialog calls, confirmation messages etc

$(document).ready(function() {
	
	$(".ui_ajax_dialog").click(function(event) {
		
		//stop default click action
		event.preventDefault();
		
		var dialog = $("#ui_dialog_container");
		
		//get the url to be loaded
		var dialogSrc = $(this).attr("href")+'?ajax=true';
		
		var height = $(this).attr("data-dialog_height");
		var width = $(this).attr("data-dialog_width");
		
		//define config object
		var dialogOpts = {
				title: $(this).attr("title"),
				modal: true,
				height: height,
				width: width,
				position: 'center'
		};
				
		dialog.dialog(dialogOpts);
		
		dialog.html('<div class="big_loader"><img src="/img/layout/big_loader.gif" class="load_gif"></div>');
				
		dialog.load(dialogSrc);
					
		
	});
	
	
	
	
	
	
	
	
	
});