// JavaScript Document
// Autocomplete search friends

$(document).ready(function() {
	
	$('.user_search').live('keyup',function() {
	
		$(this).autocomplete({
	
			source: function(request, response) {
				$.ajax({
					url: '/resources/scripts/php/autocomplete_user_search.php',
					dataType: 'json',
					data: {
						term: request.term
					},
					success: function(data) {
						//response(data);
						var suggestions = [];
						//var class_name = [];
						$.each(data, function(i, val) {
							var lbl = val.u_first_name+' '+val.u_last_name;
							suggestions.push({label:lbl, value:val.u_id, real_label: lbl});
							//class_name.push(val.cl_class_name);
						});
						
						response(suggestions);
						//alert(class_name);
					},
					
				});
				
			},
			focus: function(event, ui){ 
				if(ui.item.value==0) {
					$(ui.item).disable();
				}
			},
			select: function(event, ui) {
			  var u_id = ui.item.value;
			  var lbl = ui.item.real_label;
			  if(u_id==0) {
				  $(ui.item).disable();
			  } else {
				  //alert(lbl);
				 $(this).val(lbl);
				  //$(this).val(ui.item.real_label);
				  top.location.href="/account/schedule/view.php?u_id="+u_id;
			  }
			},
	
			minLength: 2
			
			
		});
	
	});
	
});
