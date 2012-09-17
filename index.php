<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');
//require_once(AUTH_PATH.'/fbmain.php');
foreach (glob(CLASS_PATH.'/*.php') as $filename) { 
  require_once $filename; 
}  

?>
<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7 ]> <html class="no-js ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]>    <html class="no-js ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]>    <html class="no-js ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">

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
  <script src="js/libs/modernizr-1.7.min.js"></script>

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
    	
        <?php include(MODULE_PATH.'/notifications/alerts.php');?>
        
        <div id="banner"></div>
        
        <div id="home_lower">
        
            <div class="module home_mod" id="home_mod_current">
                <h3>Current Users</h3>
                <iframe src="http://www.facebook.com/plugins/facepile.php?app_id=171083009618346&amp;size=small&amp;width=250&amp;max_rows=6" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:250px;" allowTransparency="true"></iframe>
            </div>
            
            <div class="module home_mod" id="home_mod_schools">
                <h3>Most Popular Schools</h3>
                <?php include(MODULE_PATH.'/activity/top_schools.php');?>
            </div>
            
            <div class="module home_mod" id="home_mod_activity">
                <h3>Activity Feed</h3>
                <iframe src="http://www.facebook.com/plugins/activity.php?site=http%3A%2F%2Fmyclasstoo.com&amp;width=250&amp;height=254&amp;header=false&amp;colorscheme=light&amp;font&amp;border_color=%23FFF&amp;recommendations=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:250px; height:254px;" allowTransparency="true"></iframe>
            </div>
        
        </div>
        
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
  <div id="ui_dialog_container"></div>
</body>
</html>

