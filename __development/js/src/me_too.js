// JavaScript Document
// Script to say 'me too' to a class --> add it to schedule or wishlist

$(document).ready(function() {
	
	// add class to a users sched/wishlist from view_full
	$(".sched_me_too").click(function(event) {
		event.preventDefault();
		var ce_id= $(this).attr("data-ce_id");
		var ce_cal = $(this).attr("data-ce_cal");
		var ce_class_id = $(this).attr("data-ce_class_id");
		var height = 150;
		var width = 300;
		var dialog = $("#sched_me_too_dialog");
		var url = '/resources/scripts/php/me_too.php?ce_id='+ce_id+'&ce_cal='+ce_cal+'&ce_class_id='+ce_class_id;
		
		dialog.load(url)
		//dialog.html('<ul><li><a href="/resources/scripts/php/me_too.php?type=1&ce_id='+ce_id+'&ce_cal='+ce_cal+'" class="sched_me_too_action" data-type="1">Add to schedule</a></li><li><a href="/resources/scripts/php/me_too.php?type=0&ce_id='+ce_id+'&ce_cal='+ce_cal+'" class="sched_me_too_action" data-type="0">Add to wishlist</a></li></ul>');
		
		var dialogOpts = {
			title: "Class Tools",
			modal: true,
			height: height,
			width: width,
			position: 'center',
			draggable: false,
			resizable: false,
			close: function(event,ui) {
				//clean out the dialog div for the next dialog instance
				dialog.html('');
			}
		}
		
		dialog.dialog(dialogOpts);
		
	});
	
	//functionality to update the action above ^^
	$(".sched_me_too_action").live('click',function(event) {
		
		event.preventDefault();
		var container = $("#sched_me_too_dialog");
		//var type = $(this).attr("data-type");
		var url = $(this).attr("href")+'&ajax=true';
		var data = '';
		$.ajax({
			url: url,
			type: 'get',
			data: data,
			cache: false,
			success: function(data) {
/*				if(type=='0') {
					var where = 'Wishlist';
				}else if(type=='1') {
					var where = 'Schedule';
				}*/
				container.html(data);
			}
			
			
		});
	});
	
	
	$(".wish_action").click(function(event) {
		
		event.preventDefault();
		var url = $(this).attr("href");
		var c = $("#ui_ajax_dialog");
		var title = $(this).attr("title");
		c.html('<div class="big_loader" style="overflow:hidden"><img src="/img/layout/big_loader.gif" class="load_gif"></div>');
		
		var dialogOpts = {
			title: title,
			modal: true,
			height: 200,
			width: 300,
			position: 'center',
			draggable: false,
			resizable: false,
			close: function(event,ui) {
				//clean out the dialog div for the next dialog instance
				c.html('');
/*				var redirect =window.location.href;
				top.location.href = redirect;
*/				window.location.reload()
			}
		}
		c.dialog(dialogOpts);
		
		$.ajax({
			url: url,
			data: '',
			type: 'get',
			cache: false,
			success: function(data) {
				var d = $("#response",data);
				
				c.html(d);
			}
			
		});
		
	});
	
});