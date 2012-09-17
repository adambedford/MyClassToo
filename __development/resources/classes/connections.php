<?php

class Connections {
	
	public function established_friends($u_college_id = NULL) {
		
		session_start();
		require($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');
		require(AUTH_PATH.'/fbmain.php');
		
		$friend_list = $facebook->api('me/friends/');
	   
	    $established_friends = array();
	    //$u_college_id = $_SESSION['u_college_id'];
		foreach ($friend_list as $key=>$value) {
		  
			foreach ($value as $fkey=>$fvalue) {
				
				//echo $fvalue['id'].': '.$fvalue['name'].'<br>';
					  
				$sql_connected = "SELECT * FROM tbl_Users WHERE u_oauth_uid = '{$fvalue['id']}'";
				$query_connected = mysql_query($sql_connected) or die(mysql_error());
				$connected = mysql_fetch_array($query_connected);
				
				$sql_established = "SELECT * FROM tbl_ClassEntries LEFT JOIN tbl_ClassList ON tbl_ClassEntries.ce_class_id = tbl_ClassList.cl_id WHERE tbl_ClassEntries.ce_uid = '{$fvalue['id']}' AND (@$u_college_id IS NULL OR tbl_ClassList.cl_college_id = @$u_college_id)";
				$query_established = mysql_query($sql_established) or die(mysql_error());
				$is_established = mysql_fetch_array($query_established);
				
				if(!empty($connected)/* && !empty($is_established)*/) {
					
					$established_friends[] = array(
						'u_id'				=> $connected['u_id'],
						'u_email'			=> $connected['u_email'],
						'u_first_name'		=> $connected['u_first_name'],
						'u_last_name'		=> $connected['u_last_name'],
						'u_gender'			=> $connected['u_gender'],
						'u_college_id'		=> $connected['u_college_id']
					);
					
					
					
				}
				  
			}
			
		}
		
		return $established_friends;
				
	}
	
	
/*	public function accessible_users($uid,$level,$term,$u_college_id='') {
		
//			Inputs:
//				(1) User ID (required)
//				(2) Level of access (1-5) (required)
//					1 = FB friends
//						- All (if $u_college_id left null)
//						- At user's school
//					2 = Classmates - same CLASSES
//					3 = Classmates - same CLASS SECTIONS
//					4 = Schoomates ($u_college_id MUST be specified)
//					5 = Public profiles
//				(3) Term (required)
//				(4) College ID (optional for level 1, required for level 4)
//				
//			Generates a list of MCT users accesible to the current user
//			Based on: FB friends, classmates, schoolmates & public users
//			
//			Returns: list of accessible users based on level of privacy requested
		
		
		session_start();
		require($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');
		
		//$u_college_id = $_SESSION['u_college_id'];
		$u_college_id = 1;
		//$sql_users = "SELECT * FROM tbl_Users WERE u_privacy_opt = '".$level.'"';
		
		if($level == 5) {
			//Looking for all public users. Return everyone who's profile is public
			$sql = "SELECT * FROM tbl_Users WHERE u_privacy_opt = 4";
			
		}
		
		if($level == 4) {
			//Looking for schoolmates. Return everyone at  user's school.
			$sql = "SELECT * FROM tbl_Users WHERE u_privacy_opt = 3 AND u_college_id = $u_college_id";
			
		}
		
		if($level == 3 || 2) {
			//Looking for classmates. Return all users with classes in common with user's latest schedule.
			$sched = new Schedule();
			$latest_term = $sched->latest_term($uid);
			$u_sched = $sched->gen_schedule($uid,$u_college_id,$latest_term);
			$user_classes = array();
			
			echo "<pre>";
			print_r($u_sched);
			echo "</pre>";
			
			foreach($u_sched as $key=>$val) {
				foreach($val as $fkey=>$fval) {
					$user_classes[] = $fval['ce_class_id'];
				}
			}
			
			echo "<pre>";
			print_r($user_classes);
			echo "</pre>";
			
			$sql = "SELECT * FROM tbl_ClassEntries LEFT JOIN tbl_Users ON tbl_Users.u_id = tbl_ClassEntries.ce_uid WHERE tbl_Users.u_privacy_opt = 2 AND tbl_ClassEntries.ce_class_id IN ('".implode("','",$user_classes)."')";
			
			echo $sql;
			
		}
		
		if($level == 1) {
			//Looking for only FB friends
			$connections = new Connections();
			$fb_friends = $connections->established_friends($u_college_id);
			
			//array_push(
		}
		
		if($level != 1) {
			//Level 1 does not require querying DB
			$query = mysql_query($sql) or die(mysql_error());
			$results = mysql_fetch_assoc($query);	
		}
			
		
	}*/
	
	
	public function accessible_users($uid,$level,$term,$college_id = NULL) {
		
		$sql = "SELECT * FROM tbl_Users WHERE u_id != $uid";
		$query = mysql_query($sql) or die(mysql_error());
		
		$acc_fr = array();
		
		while($access = mysql_fetch_array($query)) {
			
			$rel = $this->user_relationship($uid,$access['u_id'],$term);
			$per = $this->has_permission($uid,$access['u_id'],$term);
			
			if($rel == $level && $per == true) {
				//User relationship matches search, add them to results array
				$acc_fr[] = array(
					"u_id"			=>	$access['u_id'],
					"u_oauth_uid"	=>	$access['u_oauth_uid'],
					"u_first_name"	=>	$access['u_first_name'],
					"u_last_name"	=>	$access['u_last_name'],
					"u_dob"			=>	$access['u_dob'],
					"u_gender"		=>	$access['u_gender'],
					"u_college_id"	=>	$access['u_college_id']
				);
					
			}
			
		}
		
		return $acc_fr;
		
	}
	
	
	public function user_relationship($uid1,$uid2,$term) {
		
		/*
			Establishes the relationship between two users.
			Judged on levels:
				- 1: FB friends
				- 2: Classmates
				- 3: Past classmates
				- 4: Schoolmates
				- 5: No relationship
				
		*/
		$rel = array();
		$rel2 = array();
		
		$rel[] = $this->is_fb_friend($uid1,$uid2);
		$rel[] = $this->is_classmate($uid1,$uid2,$term);
		$rel[] = $this->is_past_classmate($uid1,$uid2);
		$rel[] = $this->is_schoolmate($uid1,$uid2);
		
		foreach($rel as $val) {
			if($val > 0) $rel2[] = $val;
		}
		
		sort($rel2,SORT_ASC);
		
		$relationship = $rel2[0];
		
		if($relationship == 0) {
			//No relationship
			$relationship = 5;
		}
		
		return $relationship;

		
	}
	
	function has_permission($uid1,$uid2,$term) {
		
		$rel = $this->user_relationship($uid1,$uid2,$term);
		
		$sql_u2 = "SELECT * FROM tbl_Users WHERE u_id = $uid2";
		$query_u2 = mysql_query($sql_u2) or die(mysql_error());
		$u2 = mysql_fetch_array($query_u2);
		$u2p = $u2['u_privacy_opt'];
		
		if ($rel <= $u2p) {
			//User has permission
			return true;
		} else {
			return false;
		}
		
	}
	
	
	/*
		Some level-specific functions relating to user relationships
	*/
	
	function is_fb_friend($uid1,$uid2) {
		
		$fb_friends = $this->established_friends();
		$fb = 0;
		
		foreach($fb_friends as $key=>$val) {
			if($uid2 == $val['u_id']) $fb = 1;
		}
		
		return $fb;
		
	}
	
	function is_classmate($uid1,$uid2,$term = NULL) {
		
		//Set return value to 0 here. If function returns true, will be set to 2.
		$cm = 0;
		
		$sql_u1_class = "SELECT * FROM tbl_ClassEntries LEFT JOIN tbl_ClassList ON tbl_ClassEntries.ce_class_id = tbl_ClassList.cl_id WHERE (@$term IS NULL OR ce_cal = @$term) AND ce_uid = $uid1";
		$query_u1_class = mysql_query($sql_u1_class) or die(mysql_error());
		
		$u1_classes = array();
		while($u1_class = mysql_fetch_array($query_u1_class)) {
			$u1_classes[] = $u1_class['ce_class_id'];
		}
		
		
		$sql_u2_class = "SELECT * FROM tbl_ClassEntries LEFT JOIN tbl_ClassList ON tbl_ClassEntries.ce_class_id = tbl_ClassList.cl_id WHERE (@$term IS NULL OR ce_cal = @$term) AND ce_uid = $uid2 AND ce_class_id IN('".implode("','",$u1_classes)."')";
		$query_u2_class = mysql_query($sql_u2_class) or die(mysql_error());
		
		if(mysql_num_rows($query_u2_class) > 0) {
			//Classmates, return true.
			$cm = 2;
		}
		
		return $cm;
		
	}
	
	function is_past_classmate($uid1,$uid2) {
		//Recycle function: is_classmate...just don't pass a term variable - therefore search all class entries
		$pcm = 0;
		$f_pcm = $this->is_classmate($uid1,$uid2);
		
		if($f_pcm > 0) $pcm = 3;
		
		return $pcm;
		
	}
	
	function is_schoolmate($uid1,$uid2) {
		
		$sm = 0;
		$sql_u1 = "SELECT * FROM tbl_Users WHERE u_id = $uid1 AND u_college_id = (SELECT u_college_id FROM tbl_Users WHERE u_id = $uid2)";
		$query_u1 = mysql_query($sql_u1) or die(mysql_error());
		
		if(mysql_num_rows($query_u1) > 0) $sm = 4;
		
		return $sm;
		
	}
	
	
	
	
	function get_college_name($college_id) {
		
		$sql_get_college_name = "SELECT * FROM tbl_Colleges WHERE c_id = '$college_id' LIMIT 1";
		$query_get_college_name = mysql_query($sql_get_college_name) or die(mysql_error());
		$get_college_name = mysql_fetch_array($query_get_college_name);
		
		return $get_college_name['c_name'];
		
	}
	
		
}


?>