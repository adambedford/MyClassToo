// JavaScript Document
// Autocomplete feature

$(document).ready(function() {
	
	//var autocomplete_element = this;
	var cl_college_id = $("#cl_college_id").val();
	$('.sched_create_search').autocomplete({
		
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
						var lbl = val.cl_course_id+': '+val.cl_class_name;
						suggestions.push({label:lbl, value:lbl, real_value:val.cl_id});
						//class_name.push(val.cl_class_name);
					});
					
					response(suggestions);
					//alert(class_name);
				},
				
			});
			
		},
		select: function(event, ui) {
		  $(this).val(ui.item.label);
		  $(this).siblings().val(ui.item.real_value);
		  //$("#sched_create_id_0").val(ui.item.real_value);
		},

		minLength: 2
		
		
	});
	
	
	
});



//'http://myclasstoo.com/resources/scripts/php/autocomplete_class_name.php?cl_college_id='+cl_college_id,