// JavaScript Document
// Functions related to the edit classes page



$(document).ready(function() {
	
	
	/*
		Asynchronously delete a class from the users schedule
	*/
	$(".sched_edit_delete_link").click(function(event) {
		
		event.preventDefault();
		var container = $(this).parent().parent();
		var original_content = container.html();
		var url = $(this).attr("href");
		
		// Prepare the confirmation dialog
		var dialog = $("#ui_dialog_container");
		dialog.attr("title","Confirm class removal");
		dialog.html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>This class will be removed from your schedule permanently. Are you sure you want to continue?</p>');
		dialog.dialog({
			resizable:false,
			height: 160,
			modal:true,
			buttons: {
				"Delete class": function() {
					// Proceed with the delete
//					alert(url);
					$.ajax({
						url: url,
						type: 'GET',
						cache: false,
						success: function(data) {
							dialog.dialog( "close" );
							container.html(data)
							var div = $("#response",data);
							//check if its success or error
							//var response = $('#response',data);
							//response_html = response.html();
//							alert(div.html());
							var response = $("#response").attr("data-status");
//							alert(response);
							if(response=='success') {
								//successful
//								alert('successful');
							} else {
//								alert('error');
								setTimeout(function() {
									container.html(original_content);
								},3000);
							}
							
						}
						
					});

				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			}
		});
		
		
	});
	
	
	/*
		Add more rows to the class list. Users can add additional classes to their schedule.
	*/
	
	
});