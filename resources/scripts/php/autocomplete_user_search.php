<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');
require_once(AUTH_PATH.'/fbmain.php');
foreach (glob(CLASS_PATH.'/*.php') as $filename) { 
  require_once $filename; 
}  
if($_GET) {				
	
	/*
		Establish a new connection with FB and retrieve user's friend list.
		Then loop through returned friends and add IDs to array for later use in SQL query
	*/
	$friends = new Connections();
	$friend_ids = array();
	foreach($friends->established_friends() as $friend) {
		$friend_ids[] = $friend['u_id'];
	}
	$term = $_GET['term'];
	$sql_find_user = "SELECT * FROM tbl_Users WHERE u_first_name LIKE '$term%' OR u_last_name LIKE '$term%' AND u_id IN (".implode(',',$friend_ids).")";
	$query_find_user = mysql_query($sql_find_user) or die(mysql_error());
	
	
	if($_GET['term']) {							// 'term' is set --> request came from jQuery UI autocomplete
	
	  $json = array();
	  
	  if(mysql_num_rows($query_find_user) > 0) {
		  
		  while($find_user = mysql_fetch_assoc($query_find_user)) {
			  $json[] = $find_user;
		  }
	  
	  } else {
		  $json[] = array (
		  	"u_id"			=>	0,
			"u_first_name"	=>	"No",
			"u_last_name"	=>	"Results"
	  );
	  }
	  
	echo json_encode($json);  
	
	} elseif($_GET['m_search_txt']) {			// 'm_search_txt' is set --> request came from form submission. No AJAX here.
		
		if(mysql_num_rows($query_find_user) > 0) {
			$find_user = mysql_fetch_assoc($query_find_user);
			header("Location: ".$config['urls']['baseUrl']."/account/schedule/view.php?u_id=".$find_user['u_id']);
			
		}
		
	}
	
}

?>

