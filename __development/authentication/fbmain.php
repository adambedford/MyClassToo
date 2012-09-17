<?php    

	//facebook application
	$fbconfig = array(
		'appid'		=> '171083009618346',
		'secret' 	=> '4ced15e77743a942939ef34b0e60a33a',
		'loginurl'	=> 'http://myclasstoo/authentication/fblogin.php',
		'baseurl' 	=> 'http://myclasstoo.com/'
		);

    //
    if (isset($_GET['request_ids'])){
        //user comes from invitation
        //track them if you need
    }
    
    $user            =   null; //facebook user uid
    try{
        include_once "../sdk/facebook/facebook.php";
    }
    catch(Exception $o){
        error_log($o);
    }
    // Create our Application instance.
    $facebook = new Facebook(array(
      'appId'  => $fbconfig['appid'],
      'secret' => $fbconfig['secret'],
      'cookie' => true,
    ));


    //Facebook Authentication part
    $user       = $facebook->getUser();
    // We may or may not have this data based 
    // on whether the user is logged in.
    // If we have a $user id here, it means we know 
    // the user is logged into
    // Facebook, but we don't know if the access token is valid. An access
    // token is invalid if the user logged out of Facebook.
    
    
    $loginUrl   = $facebook->getLoginUrl(
            array(
                'scope'         => 'email,offline_access,publish_stream,user_birthday,user_location,user_work_history,user_about_me,user_hometown',
                'redirect_uri'  => $fbconfig['loginurl']
            )
    );
    
    $logoutUrl  = $facebook->getLogoutUrl();
   

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
	
	
	
/////////////////////////////////////////////////////////////////////////	
    function d($d){
        echo '<pre>';
        print_r($d);
        echo '</pre>';
    }
?>
