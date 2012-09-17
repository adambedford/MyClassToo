<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');
require_once(AUTH_PATH.'/fbmain.php');
foreach (glob(CLASS_PATH.'/*.php') as $filename) { 
  require_once $filename; 
}  

if(isset($_GET['is_sent']) && $_GET['is_sent']=='true') {
	//request comes from valid place
	$term = Schedule::term_to_label($_GET['term']);
		try {
			$publishStream = $facebook->api("/$user/feed", 'post', array(
				'message'		=>	"My class schedule for $term", 
				'link'			=>	'http://myclasstoo.com/account/schedule/view/'.$_SESSION['u_id'].'/'.$_GET['term'].'/',
				'picture'		=>	'http://myclasstoo.com/img/layout/mct_small.png',
				'name'			=>	'My Class Too.com',
				'description'	=>	'Making class schedules social.'
				)
			);
			
//			$publishStream = true;
        } catch (FacebookApiException $e) {
			error_log($e);
        }
	
	
	
	
	if(isset($_GET['ajax']) && $_GET['ajax']=='true') {
		//request is coming from ajax
		//show them the cofirmation/error message here
		//echo '<div id="content">';
		if($publishStream) {
			echo UI::notification(1,'Your schedule has been shared on Facebook!');
		} else {
			echo UI::notification(3,'There was an error. Please try again.');
		}
		//echo '<div/>';
		
	} else {
		//request is coming from elsewhere (direct link)
		//redirect back to where request came from and append confirmation/error message	
		if($publishStream) {
			$alert_type = 1;
			$alert_content = 'Your schedule has been shared on Facebook!';
		} else {
			$alert_type = 3;
			$alert_content = 'There was an error. Please try again.';
		}
		
		header('Location: /account/home/?alert=true&alert_type='.$alert_type.'&alert_content='.$alert_content);
		
	}
	
}

?>