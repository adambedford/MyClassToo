// JavaScript Document
// Autocomplete search friends

$(document).ready(function() {
	
	$('#m_search_txt').autocomplete({
		
		source: function(request, response) {
			$.ajax({
				url: '/resources/scripts/php/autocomplete_user_search.php',
				dataType: 'json',
				data: {
					term: request.term,
				},
				success: function(data) {
					//response(data);
					var suggestions = [];
					//var class_name = [];
					
					$.each(data, function(i, val) {
						var lbl = val.u_first_name+val.u_last_name;
						suggestions.push({label:lbl, value:u_id});
						//class_name.push(val.cl_class_name);
					});
					
					response(suggestions);
					//alert(class_name);
				},
				
			});
			
		},
		select: function(event, ui) {
		  var u_id = val(ui.item.u_id);
		  top.location.href="/account/schedule/view.php?u_id="+u_id;
		  //$("#sched_create_id_0").val(ui.item.real_value);
		},

		minLength: 2
		
		
	});
	
});
