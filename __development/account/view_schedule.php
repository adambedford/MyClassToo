<?php
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


$sql_u_info = "SELECT * FROM tbl_Users WHERE u_oauth_uid = '{$userInfo['id']}'";
$query_u_info = mysql_query($sql_u_info) or die(mysql_error());
$u_info = mysql_fetch_array($query_u_info);
//echo $sql_u_info;

$schedule = new Schedule;
$sched = $schedule->schedule($u_info['u_id']);

$day_label = "";
foreach(array_sort_by_day($sched) as $day=>$classes) {
	if($day_label != $day) echo "<h3>".$day."</h3>";
	
	foreach($classes as $class) {
		echo "<pre>";
		echo $class['cl_course_id'].': '.$class['cl_class_name'].' | '.$class['ce_start_time'].' - '.$class['ce_end_time'];
		echo "</pre>";
		
	}
	
	$day_label = $day;
}


/*echo "<pre>";
print_r(array_sort_by_day($sched));
echo "</pre>";
*/


function array_sort_by_day($values){ 
    $search_strings = array("Monday","Tuesday","Wednesday","Thursday","Friday");
    $replace_string = array('0','1','2','3','4');
    $sort_key = array_map('ucfirst', $values);
    $sort_key = str_replace($search_strings, $replace_string, $sort_key);
    array_multisort($sort_key, SORT_ASC, SORT_STRING, $values);
    return $values;
}

?>