<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');
require_once(SCRIPT_PATH.'/js/merge.php');
require_once(TEMPLATES_PATH.'/css/merge.php');

if($_POST && $_POST['is_sent']=='y') {
	$cl_course_id = str_replace(' ','',$_POST['sched_add_class_course_id']);
	$sql_new_class = "INSERT INTO tbl_ClassList (cl_course_id, cl_class_name, cl_college_id) VALUES ('$cl_course_id', '{$_POST['sched_add_class_class_name']}', {$_GET['cl_college_id']})";
	$query_new_class = mysql_query($sql_new_class) or die(mysql_error());
	
	if($query_new_class) { echo 'success'; } else { echo 'error'; }
	
	
	
} else { 
	//form not sent yet, so show it

?>
<form name="sched_add_class" id="sched_add_class" action="<?php $_SERVER['PHP_SELF'];?>" method="post">

<div class="form_field">
  <label for="sched_add_class_course_id">Course ID (eg. BUS100):</label>
  <input type="text" name="sched_add_class_course_id" id="sched_add_class_course_id" placeholder="eg. BUS100">
</div>

<div class="form_field">
  <label for="sched_add_class_class_name">Class Name (eg. Intro to Business):</label>
  <input type="text" name="sched_add_class_class_name" id="sched_add_class_class_name" placeholder="eg. Introduction to Business">
</div>

<button type="submit" class="ui_button">Add class</button>
<input type="hidden" name="is_sent" value="y">
</form>

<?php } ?>