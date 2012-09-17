//JavaScript Document

$(document).ready(function() {
	
	$('#m_sched_termselect_sel').change(function() {
			
		var container = $("#m_sched_content");
		var height = container.css('height');
		container.fadeOut('slow',function() { 
			container.html('<div class="big_loader"><img src="/img/layout/big_loader.gif" class="load_gif"></div>');
			container.css('display','block'); 
		});
	//container.height(height);
		
		$("#m_sched_content").fadeOut('slow');
		var term = $(this).val();
		string = 'term='+term;
		$.ajax({
			url: '/resources/modules/schedule/view_min.php?ajax=true',
			dataType: 'html',
			type: 'GET',
			data: string,
			cache: false,
			success: function (data) {
				container.html(data);
				container.fadeIn('slow');
			}
		});
		
	});
	
	
});