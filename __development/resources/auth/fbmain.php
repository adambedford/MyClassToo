<?php    
	if(!$_SESSION) session_start();
	
	require_once ($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');
	require_once (LIBRARY_PATH.'/facebook/facebook.php');
	
	//facebook application
	$fbconfig = array(
		'appid'		=> '171083009618346',
		'secret' 	=> '4ced15e77743a942939ef34b0e60a33a',
		'loginurl'	=> 'http://myclasstoo.com/resources/auth/fbregister.php',
		'baseurl' 	=> 'http://myclasstoo.com/'
		);

    //
    if (isset($_GET['request_ids'])){
        //user comes from invitation
        //track them if you need
    }
    
    //$user = null; //facebook user uid
/*    try{
        require_once (LIBRARY_PATH.'/facebook/facebook.php');
    }
    catch(Exception $o){
        error_log($o);
		//d($o);
    }
*/    // Create our Application instance.
    $facebook = new Facebook(array(
      'appId'  => $fbconfig['appid'],
      'secret' => $fbconfig['secret']
    ));
	
	
/*
	Generate the login and logout URLs that are processed through the Facebook API
*/

    $loginUrl   = $facebook->getLoginUrl(
            array(
                'redirect_uri'	=> $fbconfig['loginurl'],
				'cancel_url' 	=> $fbconfig['baseurl'],
                'scope'			=> 'email,offline_access,publish_stream,user_birthday,user_about_me'
            )
    );
    
    $logoutUrl  = $facebook->getLogoutUrl(
			array(
				'next'			=> $fbconfig['baseurl']
			)
	);
	
	
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
       // d($e);  // d is a debug function defined at the end of this file
        $user = null;
		//invalid access token. need to authenticate
		//header('Location:http://myclasstoo.com');
      }
    }
  
    
    //if user is logged in and session is valid.
    if ($user){
        //get user basic description
        $userInfo           = $facebook->api("/$user");
	} else {
		//header('Location:http://myclasstoo.com');
		//$userInfo = $user_profile;
		//header('Location: '.$loginUrl);
		echo("<script> top.location.href='" . $loginUrl . "'</script>");
	}

/*
	Generate the login and logout URLs that are processed through the Facebook API
*/

    $loginUrl   = $facebook->getLoginUrl(
            array(
                'redirect_uri'	=> $fbconfig['loginurl'],
				'cancel_url' 	=> $fbconfig['baseurl'],
                'scope'			=> 'email,offline_access,publish_stream,user_birthday,user_about_me'
            )
    );
    
    $logoutUrl  = $facebook->getLogoutUrl(
			array(
				'next'			=> $fbconfig['baseurl']
			)
	);
	
/////////////////////////////////////////////////////////////////////////	
/*    function d($d){
        echo '<pre>';
        print_r($d);
        echo '</pre>';
    }
*/?>
