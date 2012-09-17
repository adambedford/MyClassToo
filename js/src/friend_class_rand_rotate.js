//JavaScript Document

//jQuery AJAX fetch random user class entries. Limit 10.


$.ajaxSetup ({
    // Disable caching of AJAX responses
    cache: false
});

$("#m_friend_class_more").click(function(event) {
	
	event.preventDefault();
//	var form = $("#m_friend_class_filter_frm");
	var data = $("#m_friend_class_filter_frm").serialize();
//	var method = $("#m_friend_class_filter_frm").method;
	var url = '/resources/modules/schedule/friends_classes_min.php?ajax=true #m_friend_class_content';

	if($("#m_friend_class_filter_timespan").val() == 'latest') {
		// do something
		var start_count = $("#m_friend_class_filter_start_count").val();
		data = data + '&start='+start_count;
//		alert(data);
		start_count = parseInt(start_count)+parseInt(10)
		$("#m_friend_class_filter_start_count").val(start_count);
//		alert($("#m_friend_class_filter_start_count").val());
	} else {
		//do something
	}
	
	var container = $("#m_friend_class_content");
	var height = container.css('height');
	container.fadeOut('slow',function() { 
		container.html('<div class="big_loader"><img src="/img/layout/big_loader.gif" class="load_gif"></div>');
		container.css('display','block'); 
		});
	container.height(height);
	
	
	container.load(url,data,function() {
		
		container.fadeIn('slow');
	});
	
});

/*
$("#m_friend_class_more").click(function() {
	var container = $("#m_friend_class_content");
	var height = container.css('height');
	container.fadeOut('slow',function() { 
		container.html('<div class="big_loader"><img src="/img/layout/big_loader.gif" class="load_gif"></div>');
		container.css('display','block'); 
		});
	container.height(height);
	container.load('/resources/modules/schedule/friends_classes_min.php?ajax=true',
				  function() {
					  container.fadeIn('slow');
				  });
		
	
});

*/

$('#m_friend_class_filter_frm').submit(function(event) {
	
	event.preventDefault();
	var form = $(this);
	var data = $(this).serialize();
	var method = this.method;
	var url = '/resources/modules/schedule/friends_classes_min.php?ajax=true #m_friend_class_content';
	//alert(data);
/*	$.ajax({
		
		url: url,
		type: method,
		data: data,
		cache: false,
		success: function(data) {
			//alert(data);
			form.replaceWith(data);
			var response = $("#m_friend_class_content",data).html();
			alert(response);
			$("#m_friend_class_content").html(response);
		}
		
	});
*/	
	
	var container = $("#m_friend_class_content");
	var height = container.css('height');
	container.fadeOut('slow',function() { 
		container.html('<div class="big_loader"><img src="/img/layout/big_loader.gif" class="load_gif"></div>');
		container.css('display','block'); 
		});
	container.height(height);
	
	
	container.load(url,data,function() {
		
		container.fadeIn('slow');
	});
	
});