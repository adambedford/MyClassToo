<?php    
	require_once($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');
	
	//facebook application
	$fbconfig = array(
		'appid'		=> '171083009618346',
		'secret' 	=> '4ced15e77743a942939ef34b0e60a33a',
		'loginurl'	=> 'http://myclasstoo.com/resources/authentication/fblogin.php',
		'baseurl' 	=> 'http://myclasstoo.com/'
		);

    //
    if (isset($_GET['request_ids'])){
        //user comes from invitation
        //track them if you need
    }
    
    $user            =   null; //facebook user uid
    try{
        include_once (LIBRARY_PATH.'/facebook/facebook.php');
    }
    catch(Exception $o){
        error_log($o);
    }
    // Create our Application instance.
    $facebook = new Facebook(array(
      'appId'  => $fbconfig['appid'],
      'secret' => $fbconfig['secret'],
      'cookie' => false,
    ));


    //Facebook Authentication part
    $user       = $facebook->getUser();
    // We may or may not have this data based 
    // on whether the user is logged in.
    // If we have a $user id here, it means we know 
    // the user is logged into
    // Facebook, but we don't know if the access token is valid. An access
    // token is invalid if the user logged out of Facebook.
    
    
   

    if ($user) {
      try {
        // Proceed knowing you have a logged in user who's authenticated.
        $user_profile = $facebook->api('/me');
      } catch (FacebookApiException $e) {
        //you should use error_log($e); instead of printing the info on browser
        d($e);  // d is a debug function defined at the end of this file
        $user = null;
      }
    }
   
    
    //if user is logged in and session is valid.
    if ($user){
        //get user basic description
        $userInfo           = $facebook->api("/$user");
		
	}

/*
	Generate the login and logout URLs that are processed through the Facebook API
*/

    $loginUrl   = $facebook->getLoginUrl(
            array(
                'redirect_uri'	=> $fbconfig['loginurl'],
				'cancel_url' 	=> $fbconfig['baseurl'],
                'scope'			=> 'email,publish_stream,user_birthday,user_location,user_work_history,user_about_me,user_hometown'
            )
    );
    
    $logoutUrl  = $facebook->getLogoutUrl();
	
/////////////////////////////////////////////////////////////////////////	
    function d($d){
        echo '<pre>';
        print_r($d);
        echo '</pre>';
    }
?>
