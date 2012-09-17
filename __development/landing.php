<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');
foreach (glob(CLASS_PATH.'/*.php') as $filename) { 
  require_once $filename; 
}  
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>My Class Too:: Making Class Schedules Social</title>

<style>
body { background: url(/img/layout/splash_coming_soon.png) top center no-repeat;

</style>


</head>

<body>

  <!-- Inline JavaScript -->
  <?php include(JS_PATH.'/inline.php'); ?>
</body>
</html>