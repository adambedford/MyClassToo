<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');
//
foreach (glob(CLASS_PATH.'/*.php') as $filename) { 
  require_once $filename; 
}  
/*
	Check that user has a valid session in progress. Function redirects to homepage otherwise
*/  
/*$auth = new Authentication();
$login = $auth->check_login();	
if($login) { echo "LOGGED IN"; }
*/?>
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
    	
        <?php include(STATIC_PATH.'/modules/'.$_GET['module'].'.php');?>
        
        
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

