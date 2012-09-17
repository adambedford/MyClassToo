<?php 
   session_start();
	$fbconfig = array(
		'appid'		=> '171083009618346',
		'secret' 	=> '4ced15e77743a942939ef34b0e60a33a',
		'baseurl' 	=> 'http://myclasstoo.com/test/oauth.php'
		);

   $code = $_REQUEST["code"];

   if(empty($code)) {
     $_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
     $dialog_url = "http://www.facebook.com/dialog/oauth?client_id=" 
       . $fbconfig['appid'] . "&redirect_uri=" . urlencode($fbconfig['baseurl']) . "&state="
       . $_SESSION['state'];

     echo("<script> top.location.href='" . $dialog_url . "'</script>");
   }

   if($_REQUEST['state'] == $_SESSION['state']) {
     $token_url = "https://graph.facebook.com/oauth/access_token?"
       . "client_id=" . $fbconfig['appid'] . "&redirect_uri=" . urlencode($fbconfig['baseurl'])
       . "&client_secret=" . $fbconfig['secret'] . "&code=" . $code;

     $response = file_get_contents($token_url);
     $params = null;
     parse_str($response, $params);

     $graph_url = "https://graph.facebook.com/me?access_token=" 
       . $params['access_token'];

     $user = json_decode(file_get_contents($graph_url));
	 
	 //header("Location: http://myclasstoo.com");
	 echo "<pre>";
	 print_r($user);
	 echo "</pre>";
     //echo("Hello " . $user->name);
   }
   else {
     echo("The state does not match. You may be a victim of CSRF.");
   }

 ?>