<?php

class Schedule {
	
	function is_owner($u_sched_viewed) {
		
		require($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');
		require(AUTH_PATH.'/fbmain.php');
		
		$sql_u_info = "SELECT * FROM tbl_Users WHERE u_oauth_uid = '{$userInfo['id']}'";
		$query_u_info = mysql_query($sql_u_info) or die(mysql_error());
		$u_info = mysql_fetch_array($query_u_info);
		//echo $sql_u_info;

		if($u_sched_viewed == $u_info['u_id']) {
			$owner = true;
		} else {
			$owner = false;
		}
		
		return $owner;
		
	}
	
	
	
	function gen_schedule($u_id,$u_college_id='',$term) {
		require($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');
/*		$u_id = 1;
		$u_college_id = 1;
		$term = 1105;
*//*		echo $term;
		echo $u_id.':'.$u_college_id;
*/		//$cur_yr = date('y');
/*		$sql_term = "SELECT * FROM tbl_Calendar LEFT JOIN tbl_Colleges ON tbl_Calendar.cal_Type = tbl_Colleges.c_term_type LEFT JOIN tbl_ClassEntries ON CONCAT($cur_yr,tbl_Calendar.cal_code) = tbl_ClassEntries.ce_cal WHERE tbl_ClassEntries.ce_uid = $u_id AND tbl_ClassEntries.ce_cal = $term";
		$query_term = mysql_query($sql_term) or die(mysql_error());
*/		
		$sql_find_schedule = sprintf("SELECT * FROM tbl_ClassEntries LEFT JOIN tbl_ClassList ON tbl_ClassEntries.ce_class_id = tbl_ClassList.cl_id WHERE ce_active = '1' AND ce_uid = %d AND tbl_ClassList.cl_college_id = %d AND tbl_ClassEntries.ce_cal = %d ORDER By tbl_ClassEntries.ce_start_time ASC",
			mysql_real_escape_string($u_id),
			mysql_real_escape_string($u_college_id),
			mysql_real_escape_string($term)
		);
		$query_find_schedule = mysql_query($sql_find_schedule) or die(mysql_error());
		//echo $sql_find_schedule;
		$sched=array();
		$day_counter = '';
		$day_names = array("Monday","Wednesday","Thursday","Friday","Tuesday");
		$day_index = array(0,2,3,4,1);
		$day_abbrv = array("m","w","th","f","t");									//'t' at the end so t and th arent confused
		//$sched = str_replace($day_abbrv,$day_names,$sched);
		
		while($find_schedule = mysql_fetch_array($query_find_schedule)) {
			
			$recurrence = explode(',',$find_schedule['ce_recurrence']);
			
			foreach($recurrence as $day) {
				
				$day = str_replace($day_abbrv,$day_index,$day);

				$sched[$day][]=array(
					"ce_id"				=>	$find_schedule['ce_id'],
					"ce_class_id"		=>	$find_schedule['ce_class_id'],
					"cl_course_id"		=>	$find_schedule['cl_course_id'],
					"cl_class_name"		=>	$find_schedule['cl_class_name'],
					"ce_start_time"		=>	$find_schedule['ce_start_time'],
					"ce_end_time"		=>	$find_schedule['ce_end_time'],
					"ce_professor_name"	=>	$find_schedule['ce_professor_name'],
					"ce_recurrence"		=>	$find_schedule['ce_recurrence'],
					"ce_cal"			=>	$find_schedule['ce_cal'],
					"ce_day"			=>	str_replace($day_index,$day_names,$day)
				);

				$day_counter = $day;	
			}
			
		}
		
		return Sort::arrayByDay($sched);

		
	}
	
	
	function gen_wishlist($u_id,$u_college_id='',$term) {
		
		require($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');

		$sql_find_wishlist = sprintf("SELECT * FROM tbl_ClassEntries LEFT JOIN tbl_ClassList ON tbl_ClassEntries.ce_class_id = tbl_ClassList.cl_id WHERE ce_active = '0' AND ce_uid = %d AND tbl_ClassList.cl_college_id = %d AND tbl_ClassEntries.ce_cal = %d ORDER By tbl_ClassEntries.ce_start_time ASC",
			mysql_real_escape_string($u_id),
			mysql_real_escape_string($u_college_id),
			mysql_real_escape_string($term)
		);
		
		$query_find_wishlist = mysql_query($sql_find_wishlist) or die(mysql_error());

		$wishlist=array();
		$day_counter = '';
		$day_names = array("Monday","Wednesday","Thursday","Friday","Tuesday");
		$day_abbrv = array("m","w","th","f","t");									//'t' at the end so t and th arent confused
		
		while($find_wishlist = mysql_fetch_array($query_find_wishlist)) {
			
			$recurrence = explode(',',$find_wishlist['ce_recurrence']);
			foreach($recurrence as $day) {
				
				$day = str_replace($day_abbrv,$day_names,$day);

				@array_push($wishlist[$day][]=array(
					"ce_id"				=>	$find_wishlist['ce_id'],
					"ce_class_id"		=>	$find_wishlist['ce_class_id'],
					"cl_course_id"		=>	$find_wishlist['cl_course_id'],
					"cl_class_name"		=>	$find_wishlist['cl_class_name'],
					"ce_start_time"		=>	$find_wishlist['ce_start_time'],
					"ce_end_time"		=>	$find_wishlist['ce_end_time'],
					"ce_professor_name"	=>	$find_wishlist['ce_professor_name'],
					"ce_recurrence"		=>	$find_wishlist['ce_recurrence'],
					"ce_cal"			=>	$find_wishlist['ce_cal'],
					"ce_day"			=>	$day
				));
				
				$day_counter = $day;	
			}
			
		}
		
		return $wishlist;
		
		
		
	}
	
	
	
	function classmates($ce_class_id,$ce_recurrence,$ce_start_time,$term) {
		require($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');
		//require(CLASS_PATH.'/connections.php');
//		echo (CLASS_PATH.'/connections.php');
		
		require(AUTH_PATH.'/fbmain.php');
		
//		$friend_list = $facebook->api('me/friends/');
//		echo "<pre>";
//		print_r($friend_list);
//		echo "</pre>";
//		$friend_ids = array();
//		foreach($friend_list as $key=>$val) {
//			
//			
//			foreach ($val as $fkey=>$friend) {
//							
//				$sql_friend_info = "SELECT * FROM tbl_Users WHERE u_oauth_uid = '{$friend['id']}'";
//				$query_friend_info = mysql_query($sql_friend_info) or die(mysql_error());
//				$friend_info = mysql_fetch_array($query_friend_info);
//				
//				if(!empty($friend_info)) {
//				  //print_r($friend_info);
//				  array_push($friend_ids,$friend_info['u_id']);
//				  //$friend_ids[] = 
//				}
//				
//			}
//		}

		
/*		
		Initialize a new instance of class Connection
*/		
		$connections = new Connections();
		$connected = $connections->established_friends();
//		print_r($connected_friends->established_friends());
		
		$level = 2;
		
		$established = $connections->accessible_users($_SESSION['u_id'],$level,$term,$_SESSION['u_college_id']);
		
		
		
		
		$friend_ids = array();
		
		
		
		
		foreach($established as $key=>$val) {
			array_push($friend_ids, $val['u_id']);
		}
		
		$sql_classmates = "SELECT * FROM tbl_ClassEntries LEFT JOIN tbl_ClassList ON tbl_ClassEntries.ce_class_id = tbl_ClassList.cl_id LEFT JOIN tbl_Users ON tbl_ClassEntries.ce_uid = tbl_Users.u_id WHERE tbl_ClassEntries.ce_active = '1' AND ";
		
		if($ce_class_id != '') { $sql_classmates .= "tbl_ClassList.cl_id = '{$ce_class_id}' AND "; }
		
		if($ce_recurrence != '') { $sql_classmates .= "tbl_ClassEntries.ce_recurrence = '{$ce_recurrence}' AND "; }
		
		if($ce_start_time != '') { $sql_classmates .= "tbl_ClassEntries.ce_start_time = '{$ce_start_time}' AND "; }
		
		if($term != '') { $sql_classmates .= "tbl_ClassEntries.ce_cal = '$term' AND "; }
				
		$sql_classmates .= "tbl_ClassEntries.ce_uid IN ('".implode("','",$friend_ids)."')";
		$query_classmates = mysql_query($sql_classmates) or die(mysql_error());
		//echo $sql_classmates;
		
		$classmates = array();
		
		while($row_classmates = mysql_fetch_array($query_classmates)) {
			
			array_push($classmates, array(
				"u_id"			=>	$row_classmates['u_id'],
				"u_oauth_uid"	=>	$row_classmates['u_oauth_uid'],
				"u_first_name"	=>	$row_classmates['u_first_name'],
				"u_last_name"	=>	$row_classmates['u_last_name'],
				"cl_course_id"	=>	$row_classmates['cl_course_id'],
				"cl_class_name"	=>	$row_classmates['cl_class_name'],
				"ce_recurrence"	=>	$row_classmates['ce_recurrence'],
				"ce_start_time"	=>	$row_classmates['ce_start_time']
			));
			
		}
		
		if(!empty($classmates)) {
		  return $classmates;
		} else {
			echo '<div class="alert ui-state-highlight ui-corner-all"><span class="icon ui-icon ui-icon-info"></span>None of your friends are in this class section</div>';
		}
				
	}
	
	
	
	function latest_term($u_id) {
		
		$sql_latest_term = "SELECT * FROM tbl_ClassEntries AS tbl_CE1 WHERE (SELECT COUNT(*) FROM tbl_ClassEntries AS tbl_CE2 WHERE tbl_CE2.ce_cal > tbl_CE1.ce_cal) = 0";
		$query_latest_term = mysql_query($sql_latest_term) or die(mysql_error());
		
		$latest_term = mysql_fetch_array($query_latest_term);
		
		return $latest_term['ce_cal'];
		
	}
	
	
	
	function current_term() {
		
		session_start();
		
		$sql_college_term_type = sprintf("SELECT * FROM tbl_Colleges WHERE c_id = '%s'",
			mysql_real_escape_string($_SESSION['u_college_id'])
		);
		$query_college_term_type = mysql_query($sql_college_term_type) or die(mysql_error());
		$college_term_type = mysql_fetch_array($query_college_term_type);
		
		//$cur_month = date('m');
		$cur_month = '08';
		$cur_term = '';
		if($college_term_type['c_term_type']=='1') {
			//semester system
			//now determine what semester we're currently in based on the month and term type.
			
			if($cur_month=='01') { 	//january
				//january might be interterm or xmas holidays.
				//query tbl_ClassEntries to see if anyone at the college has entered anything for interterm -->
				//	-if they have then interterm exists at the school
				//	-if they haven't, then it probably doesnt, so ignore it.
				$cal_code = array();
				$cal_code[] = date('y').'01';	//01 is the code for interterm
//				$cal_code[] = (date('y') + 1).'01';;
				$sql_interterm_exists = sprintf("SELECT * FROM tbl_ClassEntries LEFT JOIN tbl_ClassList ON tbl_ClassEntries.ce_class_id = tbl_ClassList.cl_id WHERE tbl_ClassEntries.ce_active = '1' AND tbl_ClassList.cl_college_id = '%s' AND tbl_ClassEntries.ce_cal IN(".implode(',',$cal_code).")",
					mysql_real_escape_string($_SESSION['u_college_id'])
				);
				$query_interterm_exists = mysql_query($sql_interterm_exists) or die(mysql_error());
				if(mysql_num_rows($query_interterm_exists) > 0) {
					//entries for interterm for the current year exist
					$cur_term = '01';
				} else {
					//no classes listed for current term --> probably doesnt exist
					//do nothing
				}
			} elseif($cur_month=='02' || $cur_month=='03' || $cur_month=='04' || $cur_month=='05') {
				// month is between feb and may inclusive --> spring semester
				$cur_term = '02';	//spring=02
			} elseif($cur_month=='08' || $cur_month=='09' || $cur_month=='10' || $cur_month=='11' || $cur_month=='12') {
				$cur_term = '05';	//fall=05
			}
				
			
		 } elseif($college_term_type['c_term_type']=='2') {
			if($cur_month=='01' || $cur_month=='02' || $cur_month=='03') {
				$cur_term = '06';
			} elseif($cur_month=='04' || $cur_month=='05' || $cur_month=='06') {
				$cur_term = '07';
			} elseif($cur_month=='09' || $cur_month=='10' || $cur_month=='11' || $cur_month=='12') {
				$cur_term = '10';
			}
		}
		
		if($cur_term == '') {
			//no current semester found --> probably summer, which isnt supported yet
			//now find the latest semester in the past
			
			$cur_term= substr($this->latest_term($_SESSION['u_id']),2);
		}
		
		return date('y').$cur_term;
		
	}
	
	
	function rand_friends_classes($limit) {
		
		$friends = new Connections();
		$friend_ids = array();
		foreach($friends->established_friends() as $friend) {
			$friend_ids[] = $friend['u_id'];
		}
		$friend_ids[] = "''";
		
		$sql_rand_friend_classes = "SELECT * FROM tbl_ClassEntries LEFT JOIN tbl_ClassList ON tbl_ClassEntries.ce_class_id = tbl_ClassList.cl_id LEFT JOIN tbl_Users ON tbl_ClassEntries.ce_uid = tbl_Users.u_id WHERE tbl_ClassEntries.ce_active = '1' AND ce_uid IN (".implode(',',$friend_ids).") ORDER BY RAND() LIMIT $limit";
		$query_rand_friend_classes = mysql_query($sql_rand_friend_classes) or die(mysql_error());
		//echo $sql_rand_friend_classes;	
		$arr_rand_classes = array();
		
		while($rand_friend_classes = mysql_fetch_assoc($query_rand_friend_classes)) {
			array_push($arr_rand_classes,$rand_friend_classes);
		}
		
		return $arr_rand_classes;
	}
	
	
	
	
	function classmates_min_select($timespan,$who,$term,$start=0,$limit=10) {
		
		session_start();
		$friends = new Connections();
		$friend_ids = array();
		foreach($friends->established_friends() as $friend) {
			$friend_ids[] = $friend['u_id'];
		}

		//$friend_ids[] = "''";
		
		$sql_classmates_min = "SELECT * FROM tbl_ClassEntries LEFT JOIN tbl_ClassList ON tbl_ClassEntries.ce_class_id = tbl_ClassList.cl_id LEFT JOIN tbl_Users ON tbl_ClassEntries.ce_uid = tbl_Users.u_id WHERE ce_active = '1' AND ce_cal = {$term} AND ";
		
		if($who=='me') {
			
			$sql_get_user_classes = sprintf("SELECT * FROM tbl_ClassEntries LEFT JOIN tbl_ClassList ON tbl_ClassEntries.ce_class_id = tbl_ClassList.cl_id WHERE tbl_ClassEntries.ce_uid = '%s'",
				mysql_real_escape_string($_SESSION['u_id'])
			);
			$query_get_user_classes = mysql_query($sql_get_user_classes) or die(mysql_error());
			
			$user_classes = array();
			while($get_user_classes = mysql_fetch_assoc($query_get_user_classes)) {
				$user_classes[] = $get_user_classes['cl_id'];
			}
			
			$sql_classmates_min .= "cl_id IN (".implode(',',$user_classes).") AND ce_uid IN (".implode(',',$friend_ids).") ";
			
		} elseif($who=='all') {
			$sql_classmates_min .= "ce_uid IN (".implode(',',$friend_ids).") ";
		}
			
		if($timespan=='latest') {
			$sql_classmates_min .= "ORDER BY ce_date_created DESC ";
		} elseif($timespan=='rand') {
			$sql_classmates_min .= "ORDER BY RAND() ";
		}
		
		$sql_classmates_min .= "LIMIT $start,$limit";
		
		
		
		
		$query_classmates_min = mysql_query($sql_classmates_min) or die(mysql_error());
		//echo $sql_rand_friend_classes;	
		$arr_classmates_min = array();
		
		while($classmates_min = mysql_fetch_assoc($query_classmates_min)) {
			array_push($arr_classmates_min,$classmates_min);
		}
		
//		echo "<pre>";
		return $arr_classmates_min;
//		echo "</pre>";
	}
	
		
	
	function term_to_label($term) {
		
		$year = substr($term,0,2);
		$period = substr($term,2);

		$sql_get_label = sprintf("SELECT * FROM tbl_Calendar WHERE cal_code = '%s' LIMIT 1",
			mysql_real_escape_string($period)
		);
		$query_get_label = mysql_query($sql_get_label) or die(mysql_error());
		$get_label = mysql_fetch_array($query_get_label);
		
		return ucwords($get_label['cal_label']).' '.$year;
		
	}
	
	function day_string_to_days($days) {
		
		$day_keys = array("m","th","w","t","f");
		$day_labels = array("Monday","Thursday","Wednesday","Tuesday","Friday");
		$days = explode(',',$days);
		$days = str_replace($day_keys,$day_labels,$days);
		$days = implode(', ',$days);
		
		return $days;
		
	}
		
	
	
}


?>