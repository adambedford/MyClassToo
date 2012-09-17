<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');
require_once(AUTH_PATH.'/fbmain.php');
foreach (glob(CLASS_PATH.'/*.php') as $filename) { 
  require_once $filename; 
}  
/*
	Check that user has a valid session in progress. Function redirects to homepage otherwise
*/  
$auth = new Authentication();
$login = $auth->check_login();	
if(!$login) header('Location:http://myclasstoo.com');
/*
	Get users info for use on this page and in includes
*/
$user = $auth->get_users_info($_SESSION['u_id']);

/*
	Page content
*/  
?>
<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">

  <!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
       Remove this if you use the .htaccess -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

  <title><?php echo $config['info']['title'];?></title>
  <meta name="description" content="">
  <meta name="author" content="">

  <!-- Mobile viewport optimized: j.mp/bplateviewport -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Place favicon.ico & apple-touch-icon.png in the root of your domain and delete these references -->
  <link rel="shortcut icon" href="/favicon.ico">
  <link rel="apple-touch-icon" href="/apple-touch-icon.png">


  <!-- CSS: implied media="all" -->
  <?php include(STYLE_PATH.'/merge.php'); ?>

  <!-- Uncomment if you are specifically targeting less enabled mobile browsers
  <link rel="stylesheet" media="handheld" href="css/handheld.css?v=2">  -->

  <!-- All JavaScript at the bottom, except for Modernizr which enables HTML5 elements & feature detects -->
  <script src="/js/libs/modernizr-1.7.min.js"></script>

</head>

<body>

<section id="wrapper">

	<header class="clearfix">
		
        <?php include(CORE_PATH.'/header.php'); ?>
        
        <nav>
			<?php include(CORE_PATH.'/nav.php'); ?>
        </nav>
    
    </header>
    
    <section id="main" class="clearfix">
    
    	<?php include(MODULE_PATH.'/notifications/notifications.php');?>
        <?php include(MODULE_PATH.'/notifications/alerts.php');?>
        
        <div id="m_mod_sched" class="module mod_half clearfix">
        	<h3><a href="<?php echo '/account/schedule/view.php?u_id='.$_SESSION['u_id']; ?>">Your schedule</a></h3>
            <div id="m_sched_view">
            	<?php include(MODULE_PATH.'/schedule/view_min.php');?>
            </div>
        </div>
        
        <div id="m_mod_study_group" class="module mod_half clearfix">
        	<h3>Your Study Groups</h3>
       		<div id="m_study_group">
            	<?php include(MODULE_PATH.'/environments/study_group_min.php'); ?>
            </div> 
        </div>
    	
        <div id="m_mod_friends" class="module mod_half clearfix">
        	<h3>What your friends are taking</h3>
            <div id="m_friend_class_view">
            	<?php include(MODULE_PATH.'/schedule/friends_classes_min.php'); ?>
            </div>
        </div>
        
        <div id="m_mod_search" class="module mod_half clearfix">
        	<h3>Find a friends schedule</h3>
            <div id="m_search_view">
            	<?php include(MODULE_PATH.'/search/search_friends_min.php');?>
            </div>
        </div>

        <div id="m_mod_tools" class="module mod_half clearfix">
        	<h3><a href="/account/settings/index.php">Account tools</a></h3>
            <div id="m_tools_view">
            	<?php include(MODULE_PATH.'/settings/settings_min.php'); ?>
            </div>
        </div>
        
<!--        <div id="m_mod_popular" class="module mod_full clearfix">
        	<h3>Popular Classes at <?php //echo Connections::get_college_name($_SESSION['u_college_id']);?></h3>
            <div id="m_pop_view">
            	<?php //include(MODULE_PATH.'/activity/popular_classes.php');?>
            </div>
        </div>
-->
    </section>
    
    <footer class="clearfix">
		<?php include(CORE_PATH.'/footer.php'); ?>
    </footer>

</section>




  <!-- JavaScript at the bottom for fast page loading -->
  <?php include(JS_PATH.'/merge.php'); ?>


  <!--[if lt IE 7 ]>
    <script src="js/libs/dd_belatedpng.js"></script>
    <script>DD_belatedPNG.fix("img, .png_bg"); // Fix any <img> or .png_bg bg-images. Also, please read goo.gl/mZiyb </script>
  <![endif]-->


  <!-- Inline JavaScript -->
  <?php include(JS_PATH.'/inline.php'); ?>
</body>
</html>

