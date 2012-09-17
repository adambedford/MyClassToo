<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');

//Determine what action the user wants to take: schedule or wishlist

if(isset($_GET['is_sent']) && $_GET['is_sent']=='true') {

	$sql_class_info = sprintf("SELECT * FROM tbl_ClassEntries LEFT JOIN tbl_ClassList ON tbl_ClassEntries.ce_class_id = tbl_ClassList.cl_id WHERE tbl_ClassEntries.ce_id = '%s' LIMIT 1", 
		mysql_real_escape_string($_GET['ce_id'])
	);
	$query_class_info = mysql_query($sql_class_info) or die(mysql_error());
	$class_info = mysql_fetch_array($query_class_info);
	
	if($_GET['update']==true) {
		
		$sql_me_too = sprintf("UPDATE tbl_ClassEntries SET ce_active = '%s' WHERE ce_class_id = %d AND ce_cal = %d AND ce_uid = %d",
			mysql_real_escape_string($_GET['ce_active']),
			mysql_real_escape_string($_GET['ce_class_id']),
			mysql_real_escape_string($_GET['ce_cal']),
			mysql_real_escape_string($_SESSION['u_id'])
		);
		
	} else {
	
		$sql_me_too = sprintf("INSERT INTO tbl_ClassEntries (ce_class_id, ce_recurrence, ce_start_time, ce_end_time, ce_professor_name, ce_uid, ce_cal, ce_active) VALUES (%d, '%s', '%s', '%s', '%s', %d, %d, '%s')",
			mysql_real_escape_string($class_info['ce_class_id']),
			mysql_real_escape_string($class_info['ce_recurrence']),
			mysql_real_escape_string($class_info['ce_start_time']),
			mysql_real_escape_string($class_info['ce_end_time']),
			mysql_real_escape_string($class_info['ce_professor_name']),
			mysql_real_escape_string($_SESSION['u_id']),
			mysql_real_escape_string($_GET['ce_cal']),
			mysql_real_escape_string($_GET['ce_active'])
		);
	
	}
	//echo $sql_me_too;
	$query_me_too = mysql_query($sql_me_too) or die(mysql_error());
	//$query_me_too = true;
	$where = ($_GET['ce_active']=='1') ? 'Schedule' : 'Wishlist';

	if($query_me_too) {
		echo '<div id="response" class="success ui-state-success ui-corner-all" style="margin-top:30px;"><span class="icon ui-icon ui-icon-check"></span>The class was added to your '.$where.'</div>';
	} else {
			echo '<div id="response" class="success ui-state-success ui-corner-all" style="margin-top:30px;"><span class="icon ui-icon ui-icon-check"></span>There was an error. Please try again.</div>';
	}

} else {
	
	/*
		Generate and deliver the content to display in the 'Me Too' dialog box.
		Checks first to see if the user is already in the class/has added it to wishlist (both for current term)
		If not, display links to add to schedule and wishlist.
	*/
	
//	First check if the user already has a connection to the class (in it or wishlist)
	$sql_already = sprintf("SELECT * FROM tbl_ClassEntries WHERE ce_class_id = %d AND ce_cal = %d AND ce_uid = %d",
		mysql_real_escape_string($_GET['ce_class_id']),
		mysql_real_escape_string($_GET['ce_cal']),
		mysql_real_escape_string($_SESSION['u_id'])
	);
	//echo $sql_already;
	$query_already = mysql_query($sql_already) or die(mysql_error());
	$already = mysql_fetch_assoc($query_already);
	
	if(!$already) {
//		User hasn't made a connection with the class yet this term so show them the options
		echo '<ul id="sched_me_too_opts"><li><a href="/resources/scripts/php/me_too.php?ce_active=1&ce_id='.$_GET['ce_id'].'&ce_cal='.$_GET['ce_cal'].'&is_sent=true" class="sched_me_too_action" data-type="1">Add to schedule</a></li><li><a href="/resources/scripts/php/me_too.php?ce_active=0&ce_id='.$_GET['ce_id'].'&ce_cal='.$_GET['ce_cal'].'&is_sent=true" class="sched_me_too_action" data-type="0">Add to wishlist</a></li></ul>';
		
	} else {
//		User has already made a connection. Lets find out what it is.
//		If they've added the class to the wishlist, offer them the chance to add to schedule. Also can remove.
//		If its in their schedule, tell them. Can't remove/change that from here.
		
		if($already['ce_active']=='0') {
			//wishlist
			$where = 'Wishlist';
			echo '<div id="response" class="success ui-state-success ui-corner-all" style="margin-top:30px;"><span class="icon ui-icon ui-icon-check"></span>This class is in your '.$where.'. Would you like to <a href="/resources/scripts/php/me_too.php?ce_active=1&ce_class_id='.$_GET['ce_class_id'].'&ce_cal='.$_GET['ce_cal'].'&update=true&is_sent=true" id="wish_to_sched" class="sched_me_too_action" data-type="1">add it to your schedule?</a></div>';
			
		} elseif($already['ce_active']=='1') {
			//schedule
			$where = 'Schedule';
			echo '<div id="response" class="success ui-state-success ui-corner-all" style="margin-top:30px;"><span class="icon ui-icon ui-icon-check"></span>This class is already in your '.$where.'.</div>';
		}
		
	}
		
}