<?php
session_start();
if(isset($_GET['u_id'])) {
	$u_id = $_GET['u_id'];
} else {
	$u_id = $_SESSION['u_id'];
}
/*
	Grab all the user's information
*/
$u_info = Authentication::get_users_info($u_id);

/*
	Initialize a new instance of class 'schedule' and pass through a user id and the logged-in user's college id to
	function 'schedule'.
	Also check to see if the current schedule being viewed belongs to the logges in user (for special priviledges).
	Uses the function 'is_owner' of same class.
*/

/*
	User's schedule
*/

/*
	Set the variables to null in case they don't get used
*/
$sched = false;
$is_owner = false;
$go = false;
$term_label = false;

$sql_terms = sprintf("SELECT DISTINCT * FROM tbl_ClassEntries LEFT JOIN tbl_Calendar ON SUBSTR(tbl_ClassEntries.ce_cal, 3) = tbl_Calendar.cal_code WHERE tbl_ClassEntries.ce_uid = %d GROUP BY tbl_ClassEntries.ce_cal ORDER BY tbl_ClassEntries.ce_cal ASC",
	mysql_real_escape_string($u_id)
);
$query_terms = mysql_query($sql_terms) or die(mysql_error());

$schedule = new Schedule();

/*
	Return the code for the latest schedule entered by the user.
	Used for default schedule view and for the select menu
*/
$latest_term = $schedule->latest_term($u_id);



/*if(!isset($_GET['u_id'])) {
	$u_id = $_SESSION['u_id'];
} else { 
	$u_id = $_GET['u_id'];
}
*/

$go = true;
if(isset($_GET['term'])) {
	$term = $_GET['term'];
} else {
	//do nothing
	$go = false;
}

if($go) $sched = $schedule->gen_schedule($u_id,$_SESSION['u_college_id'],$term);


$is_owner = $schedule->is_owner($u_id);


/*
	Generate a select menu of all the users schedules
*/
?>
  <div id="term_toggle">
  
	<?php
	$t = '';
    while($terms = mysql_fetch_array($query_terms)) {
        if($t != $terms['ce_cal']) {
        echo '<a href="/account/schedule/view/'.$u_id.'/'.$terms['ce_cal'].'"';
        if($_GET['term'] == $terms['ce_cal']) { echo ' class="selected"'; }
        echo '>'.ucwords($terms['cal_label'].' '.substr($terms['ce_cal'],0,2)).'</a>';
        }
        $t = $terms['ce_cal'];
		
		if($_GET['term'] == $terms['ce_cal']) {
			$term_label = ucwords($terms['cal_label'].' '.substr($terms['ce_cal'],0,2));
		}
    }
	
    ?>
  </div>
  
  <?php if(isset($sched) && $is_owner) { ?>
  <div id="sched_edit_links">
  	<a href="/account/schedule/edit/<?php echo $_GET['term'];?>" class="ui_edit_button">Edit</a>
    <a href="/account/schedule/create/" class="ui_new_button">New</a>
    <span class="ui_theme_sub"><a href="/account/schedule/share/?is_sent=true&term=<?php echo $term;?>" id="sched_share" class="ui_share_button">Share</a></span>
  </div>
<?php
  }

if($is_owner == true) { $user_label = 'Your '; } else { $user_label = $u_info['u_first_name'].'\'s '; }

echo '<h3>'.$user_label.$term_label.' schedule</h3>';



echo '<div id="sched_view">';

if(mysql_num_rows($query_terms)) {
	
	if(!isset($_GET['term'])) {
		
		echo 'Please select a term\'s schedule to view above.'; 
		
	} else {

		$day_label = "";
		foreach($sched as $day=>$classes) {
			
			// Switch out the numerical index in the array for human friendly labels that we can display as headers
			$day_names = array("Monday","Tuesday","Wednesday","Thursday","Friday");
			$day_abbrv = array("0","1","2","3","4");
			$day = str_replace($day_abbrv,$day_names,$day);
			
			if($day_label != $day) echo "<h4>".$day."</h4>";
			
			foreach($classes as $class) {
				echo '<div class="sched_view_element clearfix">';
				echo $class['cl_course_id'].': '.$class['cl_class_name'].' | '.$class['ce_start_time'].' - '.$class['ce_end_time'];
				echo '<div class="sched_view_element_tools">';
				if($is_owner) echo '<a href="'.$config['urls']['baseUrl'].'/account/schedule/classmates.php?ce_class_id='.$class['ce_class_id'].'&ce_recurrence='.$class['ce_recurrence'].'&ce_start_time='.$class['ce_start_time'].'">View classmates</a>';
				if(!$is_owner) echo ' | <a href="#" class="sched_me_too" data-ce_id="'.$class['ce_id'].'" data-ce_cal="'.$class['ce_cal'].'" data-ce_class_id="'.$class['ce_class_id'].'">Me Too</a>';
		
				echo "</div></div>";
				
			}
			
			$day_label = $day;
		}
	
	}
	
	
} else {
	
	//no schedule created
	echo UI::notification(2,$u_info['u_first_name']." hasn't created a schedule yet.");
	
}


if(isset($sched)) {
	
	

} else {
	
	
	
}


echo '</div>';

?>
<div id="sched_me_too_dialog"></div>