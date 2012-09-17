<?php
require_once('../Connections/myclasstoo.php');
include_once('fbmain.php');
/*

if (!$user) {
	echo '<a href="'.$login_url.'">Facebook Login</a>';
} else {
	echo '<a href="'.$logout_url.'">Facebook Logout</a>';
}

*/

$sql_user_exists = "SELECT * FROM tbl_Users WHERE u_oauth_provider = 'facebook' AND u_oauth_uid = {$userInfo['id']}";
$query_user_exists = mysql_query($sql_user_exists) or die(mysql_error());
$user_exists = mysql_fetch_array($query_user_exists);

if(empty($user_exists)) {
	$raw_birthday = $userInfo['birthday'];
	$birthday = date("Y-m-d", strtotime($raw_birthday));
	$sql_insert_user = "INSERT INTO tbl_Users (u_oauth_provider, u_oauth_uid, u_email, u_first_name, u_last_name, u_dob, u_gender, u_profile_link) VALUES ('facebook', {$userInfo['id']}, '{$userInfo['email']}', '{$userInfo['first_name']}', '{$userInfo['last_name']}', '{$birthday}', '{$userInfo['gender']}', '{$userInfo['link']}')";
	
	//echo $sql_insert_user;
	$query_insert_user = mysql_query($sql_insert_user) or die (mysql_error());
	$sql_new_user = "SELECT * FROM tbl_Users WHERE u_id = ".mysql_insert_id();
	$query_new_user = mysql_query($sql_new_user) or die (mysql_error());
	$user_exists = mysql_fetch_array($query_new_user);

}

d($user_exists);
?>
