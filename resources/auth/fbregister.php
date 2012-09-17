<?php
  session_start();
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');
  require(AUTH_PATH.'/fbmain.php');

  $new_user = false;
  
/*  echo "<pre>";
  print_r($userInfo);
  print_r($user);
  echo "</pre>";
*/  
  $sql_user_exists = sprintf("SELECT * FROM tbl_Users WHERE u_oauth_provider = 'facebook' AND u_oauth_uid = '%s'",
  	mysql_real_escape_string($userInfo['id'])
  );
  
//  echo "<pre>".$sql_user_exists."</pre>";
  
  $query_user_exists = mysql_query($sql_user_exists) or die(mysql_error());
  $user_exists = mysql_fetch_array($query_user_exists);
  
  if(empty($user_exists)) {
	  $new_user = true;							//flag for new user to complete app later
	  $raw_birthday = $userInfo['birthday'];
	  $birthday = date("Y-m-d", strtotime($raw_birthday));
	  $sql_insert_user = "INSERT INTO tbl_Users (u_oauth_provider, u_oauth_uid, u_email, u_first_name, u_last_name, u_dob, u_gender, u_profile_link) VALUES ('facebook', {$userInfo['id']}, '{$userInfo['email']}', '{$userInfo['first_name']}', '{$userInfo['last_name']}', '{$birthday}', '{$userInfo['gender']}', '{$userInfo['link']}')";
	  
	  $query_insert_user = mysql_query($sql_insert_user) or die (mysql_error());
	  $sql_new_user = "SELECT * FROM tbl_Users WHERE u_id = ".mysql_insert_id();
	  $query_new_user = mysql_query($sql_new_user) or die (mysql_error());
	  
	  $user_exists = mysql_fetch_array($query_new_user);
  
  }
  
  /*
  	Assign the users id (not fb id) to a session for easy access later
*/
	$_SESSION['u_id'] = $user_exists['u_id'];
  
  if(!$user_exists['u_college_id']) {
	  $redirect = $config['urls']['baseUrl'].'/account/complete_reg.php';
  } else {
  	  $_SESSION['u_college_id'] = $user_exists['u_college_id'];
	  $redirect = $config['urls']['baseUrl'].'/account/home/';
  }
  
  $_SESSION['u_id'] = $user_exists['u_id'];
  $_SESSION['u_first_name'] = $user_exists['u_first_name'];
  $_SESSION['u_last_name'] = $user_exists['u_last_name'];
/* */  

/*
	All registration has been done, now redirect user to their homepage
*/

  //header($config['urls']['baseUrl'].'account/home.php');
  
  echo("<script> top.location.href='" . $redirect . "'</script>");
  
?>
