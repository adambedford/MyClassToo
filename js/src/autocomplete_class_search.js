// JavaScript Document
// Autocomplete feature

$(document).ready(function() {
	
	//var autocomplete_element = this;
	var cl_college_id = $("#cl_college_id").val();
	
	/*
		Bind autocomplete to keyup event with jQuery's live function so new DOM elements
		also get the function assigned.
	*/
	
	$('.class_search').live('keyup',function() {
	
		$(this).autocomplete({
			
			source: function(request, response) {
				$.ajax({
					url: 'http://myclasstoo.com/resources/scripts/php/autocomplete_class_name.php',
					dataType: 'json',
					data: {
						term: request.term,
						cl_college_id: cl_college_id
					},
					success: function(data) {
						//response(data);
						var suggestions = [];
						//var class_name = [];
						
						$.each(data, function(i, val) {
							if(val.cl_id==0) {
								var lbl = val.cl_course_id+' '+val.cl_class_name;
							} else {
								var lbl = val.cl_course_id+': '+val.cl_class_name;
							}
							suggestions.push({label:lbl, value:lbl, real_value:val.cl_id});
							//class_name.push(val.cl_class_name);
						});
						
						response(suggestions);
						//alert(class_name);
					},
					
				});
				
			},
			focus: function(event, ui){ 
				if(ui.item.real_value==0) {
					$(ui.item).disable();
				}
			},
			select: function(event, ui) {
			  if(ui.item.real_value==0) {
				  $(ui.item).disable();
			  } else {
			  $(this).val(ui.item.label);
			  $(this).siblings().val(ui.item.real_value);
			  }
			},
	
			minLength: 2
			
			
		});	//end autocomplete
		
	});
	
	
	
});



//'http://myclasstoo.com/resources/scripts/php/autocomplete_class_name.php?cl_college_id='+cl_college_id,