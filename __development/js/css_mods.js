//JavaScript document

/*
	jQuery commands to apply jQuery UI to elements
*/

$(document).ready(function() {
	$('.ui_button').button();
	
	$('.ui_search_button').button({
		icons: {
			primary: "ui-icon-search"
		},
		text: false
	});
	
	$('.ui_edit_button').button({
		icons: {
			primary: "ui-icon-pencil"
		}
	});
	
	$('.ui_new_button').button({
		icons: {
			primary: "ui-icon-plus"
		}
	});
	
	$('.ui_share_button').button({
		icons: {
			primary: "ui-icon-comment"
		}
	});
	
	$('.ui_buttonset').buttonset();
	
	$('.ui_selectmenu').selectmenu();
	
});