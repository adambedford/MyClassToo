<?php
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');
require_once(AUTH_PATH.'/fbmain.php');
foreach (glob(CLASS_PATH.'/*.php') as $filename) { 
  require_once $filename; 
}  

if(isset($_GET['ajax']) && $_GET['ajax']==true) {

	$user = Authentication::get_users_info($_SESSION['u_id']);
	$img = 'http://graph.facebook.com/'.$user['u_oauth_uid'].'/picture';
	
	echo '<div id="nav_account_menu">
			<div id="nav_account_menu_top" class="clearfix">';
	echo		'<img src="'.$img.'" class="u_prof_pic">';
	echo		'<span class="u_name">'.$user['u_first_name'].' '.$user['u_last_name'].'</span>';
	echo	'</div>';
	
	echo	'<ul id="nav_account_opts">
				<li><a href="/account/home/">Account Home</a></li>
				<li><a href="/account/schedule/view/">View Schedule</a></li>
				<li><a href="/account/schedule/create/">New Schedule</a></li>
				<li><a href="/account/settings/">Settings</a></li>
			</ul>
			
		  </div>';
			
				



//echo '<img src="'.$img.'">';

}