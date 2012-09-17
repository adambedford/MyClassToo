<?php

if(isset($_GET['wish_element_delete']) && $_GET['wish_element_delete']==true) {
	//user has selected to delete an element from their wishlist
	
	$sql_delete_wish = sprintf("DELETE FROM tbl_ClassEntries WHERE ce_id = %d AND ce_active = '0' AND ce_uid = %d",
		mysql_real_escape_string($_GET['ce_id']),
		mysql_real_escape_string($_SESSION['u_id'])
	);
	$query_delete_wish = mysql_query($sql_delete_wish) or die(mysql_error());
	//$query_delete_wish = true;
	
	if($query_delete_wish) {
		echo '<div id="response" class="success ui-state-success ui-corner-all" style="margin:30px 0 30px 0;"><span class="icon ui-icon ui-icon-check"></span>The class was removed from your Wishlist.</div>';
	} else {
		echo '<div id="response" class="error ui-state-error ui-corner-all" style="margin:30px 0 30px 0;"><span class="icon ui-icon ui-icon-alert"></span>There was an error. Please try again.'.$sql_delete_wish.'</div>';
	}
	
	
}


if(isset($_GET['wish_element_firm']) && $_GET['wish_element_firm']==true) {
	//user has selected to move class from wishlist to schedule
	
	$sql_firm_wish = sprintf("UPDATE tbl_ClassEntries SET ce_active = '1' WHERE ce_id = %d AND ce_uid = %d",
		mysql_real_escape_string($_GET['ce_id']),
		mysql_real_escape_string($_SESSION['u_id'])
	);

	$query_firm_wish = mysql_query($sql_firm_wish) or die(mysql_error());

	if($query_firm_wish) {
		echo '<div id="response" class="success ui-state-success ui-corner-all" style="margin:30px 0 30px 0;"><span class="icon ui-icon ui-icon-check"></span>The class was added to your schedule.</div>';
	} else {
		echo '<div id="response" class="error ui-state-error ui-corner-all" style="margin:30px 0 30px 0;"><span class="icon ui-icon ui-icon-alert"></span>There was an error. Please try again.'.$sql_firm_wish.'</div>';
	}
	
}


$sql_terms = "SELECT DISTINCT * FROM tbl_ClassEntries LEFT JOIN tbl_Calendar ON SUBSTR(tbl_ClassEntries.ce_cal, 3) = tbl_Calendar.cal_code WHERE tbl_ClassEntries.ce_uid = {$user['u_id']} GROUP BY tbl_ClassEntries.ce_cal ORDER BY tbl_ClassEntries.ce_cal ASC";
$query_terms = mysql_query($sql_terms) or die(mysql_error());
$t = '';

$schedule = new Schedule();
$is_owner = $schedule->is_owner($user['u_id']);
$latest_term = $schedule->latest_term($user['u_id']);

if(!isset($_GET['term'])) {
	$term = $latest_term;
} else {
	$term = $_GET['term'];
}

/*
	Generate a select menu of all the users schedules
*/
?>
<div id="wishlist_term_select">
  <select name="wishlist_term_select_sel" id="wishlist_term_select_sel">
    <?php
    while($terms = mysql_fetch_array($query_terms)) {
        if($t != $terms['ce_cal']) {
        echo '<option value="/account/settings/index.php?term='.$terms['ce_cal'].'#/#Wishlist"';
        if($term == $terms['ce_cal']) { echo ' selected="selected"'; } 
        echo '>'.ucwords($terms['cal_label'].' '.substr($terms['ce_cal'],0,2)).'</option>';
        }
        $t = $terms['ce_cal'];
    } 
    ?>
  </select>
</div>
  
<?php

// bug fix for jq ui tabs+history;
$term = substr($term,0,4);
$wishlist = $schedule->gen_wishlist($user['u_id'],$_SESSION['u_college_id'],$term);

echo '<div id="sched_view">';

//if(!isset($_GET['term'])) { echo 'Please select a term\'s schedule to view above.'; }

if(!empty($wishlist)) {

	$day_label = "";
	foreach(Sort::arrayByDay($wishlist) as $day=>$classes) {
		if($day_label != $day) echo "<h4>".$day."</h4>";
		
		foreach($classes as $class) {
			echo '<div class="sched_view_element clearfix">';
			echo $class['cl_course_id'].': '.$class['cl_class_name'].' | '.$class['ce_start_time'].' - '.$class['ce_end_time'].' | ';
			echo '<div class="sched_view_element_tools">';
			if($is_owner == true) {
				echo '<a href="'.$config['urls']['baseUrl'].'/account/schedule/classmates.php?ce_class_id='.$class['ce_class_id'].'&ce_recurrence='.$class['ce_recurrence'].'&ce_start_time='.$class['ce_start_time'].'" class="view_classmates">View classmates</a> | ';
				echo '<a href="'.$_SERVER['PHP_SELF'].'?&term='.$_GET['term'].'&wish_element_delete=true&ce_id='.$class['ce_id'].'#/#Wishlist" class="wish_action" title="Remove from Wishlist">Remove</a> | ';
				echo '<a href="'.$_SERVER['PHP_SELF'].'?term='.$_GET['term'].'&wish_element_firm=true&ce_id='.$class['ce_id'].'#/#Wishlist" class="wish_action" title="Move class to Schedule">Add to Schedule</a>';
			}
			echo '</div></div>';
			
		}
		
		$day_label = $day;
	}

} else {
	
	echo '<div class="alert ui-state-highlight ui-corner-all" style="margin:30px 0 30px 0;"><span class="icon ui-icon ui-icon-info"></span>You have no classes in your wishlist for the selected term.</div>';
	
}

echo '</div>';
echo '<div id="ui_ajax_dialog"></div>';