<?php
session_start();
/*
	The following files are included home.php (includes this file) but independant AJAX calls are
	also made to this page so they are included again if the GET protocol is in action.
*/
require($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');

if(isset($_GET['ajax']) && $_GET['ajax']==true) {
  require_once(AUTH_PATH.'/fbmain.php');
  foreach (glob(CLASS_PATH.'/*.php') as $filename) { 
	require $filename; 
  }  
}
/*
	User's schedule
*/
$sql_u_info = "SELECT * FROM tbl_Users WHERE u_oauth_uid = '{$userInfo['id']}'";
$query_u_info = mysql_query($sql_u_info) or die(mysql_error());
$u_info = mysql_fetch_array($query_u_info);

$sql_terms = "SELECT DISTINCT * FROM tbl_ClassEntries LEFT JOIN tbl_Calendar ON SUBSTR(tbl_ClassEntries.ce_cal, 3) = tbl_Calendar.cal_code WHERE tbl_ClassEntries.ce_uid = '{$u_info['u_id']}' GROUP BY tbl_ClassEntries.ce_cal ORDER BY tbl_ClassEntries.ce_cal ASC";
$query_terms = mysql_query($sql_terms) or die(mysql_error());
$t = '';

/*
	Return the code for the latest schedule entered by the user.
	Used for default schedule view and for the select menu
*/
$latest_term = new Schedule();
$latest_term = $latest_term->latest_term($u_info['u_id']);


/*
	Generate a select menu of all the users schedules
*/
if(!isset($_GET['ajax']) && $_GET['ajax']==false) {
?>
  <div id="m_sched_termselect">
    <select name="m_sched_termselect_sel" id="m_sched_termselect_sel">
	  <?php
      while($terms = mysql_fetch_array($query_terms)) {
          if($t != $terms['ce_cal']) {
          echo '<option value="'.$terms['ce_cal'].'"';
          if($latest_term == $terms['ce_cal']) { echo ' selected="selected"'; } 
          echo '>'.ucwords($terms['cal_label'].' '.substr($terms['ce_cal'],0,2)).'</option>';
          }
          $t = $terms['ce_cal'];
      } 
      ?>
    </select>
  </div>
<?php } ?>
<div id="m_sched_content">
<?php
/*
	Initialize a new instance of class 'schedule' and pass through a user id and the logged-in user's college id to
	function 'schedule'.
	Also check to see if the current schedule being viewed belongs to the logged in user (for special priviledges).
	Uses the function 'is_owner' of same class.
*/
if(!isset($_GET['term'])) {
	$term = $latest_term;
} else {
	$term = $_GET['term'];
}

$schedule = new Schedule();
$sched = $schedule->gen_schedule($u_info['u_id'],$_SESSION['u_college_id'],$term);
$is_owner = $schedule->is_owner($u_info['u_id']);


if(!empty($sched)) {
  
  $day_label = "";
  foreach ($sched as $day=>$classes) {
	  
	  // Switch out the numerical index in the array for human friendly labels that we can display as headers
	  $day_names = array("Monday","Tuesday","Wednesday","Thursday","Friday");
	  $day_abbrv = array(0,1,2,3,4);
	  $day = str_replace($day_abbrv,$day_names,$day);
	  
	  if($day_label != $day) echo '<div class="sched_row_header">'.$day.'</div>';
	  
	  foreach($classes as $class) {
		  echo '<div class="sched_row_element clearfix">'.$class['cl_course_id'].': '.$class['cl_class_name'].' | '.$class['ce_start_time'].' - '.$class['ce_end_time'];
		  if($is_owner == true) {
			  echo '<span class="sched_row_element_classmates"><a href="'.$config['urls']['baseUrl'].'/account/schedule/classmates.php?ce_class_id='.$class['ce_class_id'].'&ce_recurrence='.$class['ce_recurrence'].'&ce_start_time='.$class['ce_start_time'].'&ce_term='.$class['ce_cal'].'">View classmates</a></span>';
		  }
		  echo '</div>';
	  }
	  
	  $day_label = $day;
  }

} else {
	
	echo	'<div class="alert ui-state-highlight ui-corner-all"><span class="icon ui-icon ui-icon-info"></span>You haven\'t added any classes to your schedule yet.</div>
			 <p class="sched_empty">Would you like to :
		  		<ul>
					<li><a href="/account/schedule/create/">Create your schedule now</a></li>
					<li><a href="/account/schedule/classmates/">See what classes your friends are taking?</a></li>
				</ul>
		  	 </p>';
	
}

?>
</div>
