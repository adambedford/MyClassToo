// JavaScript Document
// Add more class entry rows to the form



$(document).ready(function() {
	
	function reloadStylesheets() {
		var queryString = '&reload=' + new Date().getTime();
		$('link[rel="stylesheet"]').each(function () {
			this.href = this.href.replace(/\?.*|$/, queryString);
		});
	}

	
	
	var counter = 5;

	$("#new_row_click").click(function(event) {
		event.preventDefault();
		var form = $(this).parent().parent();
		
		var content = '<div class="form_row clearfix"><div class="form_row_element create_sched_field"><label for="sched_create['+counter+'][search]">Course ID:</label><input type="text" name="sched_create['+counter+'][search]" class="class_search" id="sched_create_search_'+counter+'>" placeholder="Search for a class by code (eg. BUS100) or name"><input type="hidden" name="sched_create['+counter+'][id]" class="sched_create_id" id="sched_create_id_'+counter+'"><a href="/account/schedule/add_class.php" class="ui_button ui_ajax_dialog" title="Add a new class" data-dialog_width="500" data-dialog_height="250">+</a></div><div class="form_row_element create_sched_field"><label for="sched_create['+counter+'][start_time]">Start time:</label><input type="time" value="09:00" step="300" name="sched_create['+counter+'][start_time]" id="sched_create_start_time_'+counter+'"></div><div class="form_row_element create_sched_field"><label for="sched_create['+counter+'][start_time]">End time:</label><input type="time" value="09:00" step="300" name="sched_create['+counter+'][end_time]" id="sched_create_end_time_'+counter+'"></div><div class="form_row_element create_sched_field"><label for="sched_create['+counter+'][recurrence]">Recurrence:</label><div class="ui_buttonset" style="display:inline-block;"><input type="checkbox" name="sched_create['+counter+'][recurrence][]" id="sched_create_recurrence_'+counter+'_m" value="m"><label for="sched_create_recurrence_'+counter+'_m">M</label><input type="checkbox" name="sched_create['+counter+'][recurrence][]" id="sched_create_recurrence_'+counter+'_t" value="t"><label for="sched_create_recurrence_'+counter+'_t">T</label><input type="checkbox" name="sched_create['+counter+'][recurrence][]" id="sched_create_recurrence_'+counter+'_w" value="w"><label for="sched_create_recurrence_'+counter+'_w">W</label><input type="checkbox" name="sched_create['+counter+'][recurrence][]" id="sched_create_recurrence_'+counter+'_th" value="th"><label for="sched_create_recurrence_'+counter+'_th">Th</label><input type="checkbox" name="sched_create['+counter+'][recurrence][]" id="sched_create_recurrence_'+counter+'_f" value="f"><label for="sched_create_recurrence_'+counter+'_f">F</label></div></div><div class="form_row_element create_sched_field"><label for"sched_create['+counter+'][professor_name]">Professor\'s name:</label><input type="text" name="sched_create['+counter+'][professor_name]" id="sched_create_professor_name'+counter+'"></div></div><br />';

		
		//form.append(content)
		$(this).parent().before(content);
		$('.ui_button').button();
		$('.ui_buttonset').buttonset();
		
		//reloadStylesheets();
		counter++;
	});
	
	
	// time selector
	$('input[type="time"]').timepicker({
		timeFormat: 'hh:mm',
		stepMinute: 5,
		hourMin: 7
	});
		
});