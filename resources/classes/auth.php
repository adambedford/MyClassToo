<?php

if(!isset($_SESSION)) {
	session_start();
}

class Authentication {
	
	function check_login() {
		//require_once(LIBRARY_PATH.'/facebook/facebook.php');
		require($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');
		require(AUTH_PATH.'/fbmain.php');
		
/*		if(is_null($facebook->getUser())) {
			header ('Location: http://bbc.co.uk');
			header($config['urls']['baseUrl']);
			exit;
			
		}
*/		
		$user = $facebook->getUser();
		
		if($user) {
			//user is authenticated and connected
			
			if($_SESSION['u_id']) {
				//return true
				return true;
			} else {
				//session no longer valid
				return false; 
			}
		} else {
			//user either isn't logged in or isnt connected to app
			//return false
			return false;
		}
		
	}
	
	
	function get_users_info($u_id) {
		
		require($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');
		
		$sql_u_info = sprintf("SELECT * FROM tbl_Users WHERE u_id = %d",
			mysql_real_escape_string($u_id)
		);
		
		$query_u_info = mysql_query($sql_u_info) or die(mysql_error());
		
		$u_info = mysql_fetch_assoc($query_u_info);
		
		return $u_info;
	}
	
	function mct_session_start() {
		
		//custom session start function. extend life beyond ordinary
		if(!$_SESSION) {
			session_start();
		} 
		
	}
	
}