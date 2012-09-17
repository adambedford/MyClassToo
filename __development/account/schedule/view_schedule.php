<?php
session_start();
header("Content-Type: text/html;charset=utf-8");
require_once($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');
require_once(AUTH_PATH.'/fbmain.php');
foreach (glob(CLASS_PATH.'/*.php') as $filename) { 
  include $filename; 
}  
/*
	Check that user has a valid session in progress. Funtion redirects to homepage otherwise
*/  
$active = new Authentication();
$active->check_login();	

/*
	Initialize a new instance of class 'schedule' and pass through a user id and the logged-in user's college id to
	function 'schedule'.
	Also check to see if the current schedule being viewed belongs to the logges in user (for special priviledges).
	Uses the function 'is_owner' of same class.
*/
$schedule = new Schedule();
$sched = $schedule->gen_schedule($_GET['u_id'],$_SESSION['u_college_id'],$_GET['term']);
$is_owner = $schedule->is_owner($_GET['u_id']);

$day_label = "";
foreach(array_sort_by_day($sched) as $day=>$classes) {
	if($day_label != $day) echo "<h3>".$day."</h3>";
	
	foreach($classes as $class) {
		echo "<pre>";
		echo $class['cl_course_id'].': '.$class['cl_class_name'].' | '.$class['ce_start_time'].' - '.$class['ce_end_time'].' | ';
		if($is_owner == true) {
			echo '<a href="'.$config['urls']['baseUrl'].'/account/schedule/classmates.php?ce_class_id='.$class['ce_class_id'].'&ce_recurrence='.$class['ce_recurrence'].'&ce_start_time='.$class['ce_start_time'].'">View classmates</a>';
		}
		echo "</pre>";
		
	}
	
	$day_label = $day;
}


/*echo "<pre>";
print_r(array_sort_by_day($sched));
echo "</pre>";
*/
if($is_owner == true) echo '<p><b>This is your schedule</b></p>';

function array_sort_by_day($values){ 
    $search_strings = array("Monday","Tuesday","Wednesday","Thursday","Friday");
    $replace_string = array('0','1','2','3','4');
    $sort_key = array_map('ucfirst', $values);
    $sort_key = str_replace($search_strings, $replace_string, $sort_key);
    array_multisort($sort_key, SORT_ASC, SORT_STRING, $values);
    return $values;
}

?>