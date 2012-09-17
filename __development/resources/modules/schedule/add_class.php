<?php 
session_start();
if($_GET['ajax']==true && $_POST['is_sent']=='y') {
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');
/*  require_once(SCRIPT_PATH.'/js/merge.php');
  require_once(TEMPLATES_PATH.'/css/merge.php');
  foreach (glob(CLASS_PATH.'.php') as $filename) { 
	require_once $filename; 
  }  
*/}

/*
	Get the college name from ID
*/
$sql_get_college = sprintf("SELECT * FROM tbl_Colleges WHERE c_id = %d LIMIT 1",
	mysql_real_escape_string($_SESSION['u_college_id'])
);
$query_get_college = mysql_query($sql_get_college) or die(mysql_error());
$get_college = mysql_fetch_array($query_get_college);


if($_POST && $_POST['is_sent']=='y') {
	echo '<div id="wrapper">';
	
	//$cl_course_id = str_replace(' ','',$_POST['sched_add_class_course_id']);
	$cl_course_id = $_POST['sched_add_class_course_id'];
	
	$sql_check_existing = sprintf("SELECT * FROM tbl_ClassList WHERE tbl_ClassList.cl_course_id = '%s'",
		mysql_real_escape_string($cl_course_id)
	);
	$query_check_existing = mysql_query($sql_check_existing) or die(mysql_error());
	
	if(mysql_num_rows($query_check_existing) > 0) {
		echo '<div id="response" class="error ui-state-error ui-corner-all" style="margin-top:30px;"><span class="icon ui-icon ui-icon-alert"></span>The class you are trying to add may already exist. Please check and try again.</div>';
		
	} else {
	
	  $sql_new_class = sprintf("INSERT INTO tbl_ClassList (cl_course_id, cl_class_name, cl_college_id) VALUES ('%s', '%s', %d)",
	  	mysql_real_escape_string($cl_course_id),
		mysql_real_escape_string($_POST['sched_add_class_class_name']),
		mysql_real_escape_string($_SESSION['u_college_id'])
	  );
	  $query_new_class = mysql_query($sql_new_class) or die(mysql_error());
	  //$query_new_class = true;
	  
	  if($query_new_class) {
		  echo '<div id="response" class="success ui-state-success ui-corner-all" style="margin-top:30px;"><span class="icon ui-icon ui-icon-check"></span>The class was added to the system successfully.</div>';
	  } else {
		  echo '<div id="response" class="error ui-state-error ui-corner-all" style="margin-top:30px;"><span class="icon ui-icon ui-icon-alert"></span>There was an error. Please try again.</div>';
	  }
	  
	}
	echo '</div>';
	
	
} else { 
	//form not sent yet, so show it

?>
<p>&nbsp;</p>
<h3>Add new class for <?php echo $get_college['c_name'].', '.strtoupper($get_college['c_state']); ?></h3>

<form name="sched_add_class" id="sched_add_class" class="jq_ajax_submit" action="/resources/modules/schedule/add_class.php" method="post">

<div class="form_row">
  <label for="sched_add_class_course_id">Course ID (eg. BUS100):</label>
  <input type="text" name="sched_add_class_course_id" id="sched_add_class_course_id" placeholder="eg. BUS100">
</div>

<div class="form_row">
  <label for="sched_add_class_class_name">Class Name (eg. Intro to Business):</label>
  <input type="text" name="sched_add_class_class_name" id="sched_add_class_class_name" placeholder="eg. Introduction to Business">
</div>

<button type="submit" class="ui_button">Add class</button>
<input type="hidden" name="is_sent" value="y">
</form>

<?php } ?>