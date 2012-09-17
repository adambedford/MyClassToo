<?php 
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');
foreach (glob(CLASS_PATH.'/*.php') as $filename) { 
  require_once $filename; 
}
?>

<style>
html {font: Arial, Helvetica, sans-serif; }
div.form_row { padding: 5px; margin: 0 0 10px 0; border-bottom: 1px dotted #999; }
h3 { display: block; margin: 0 0 10px 0; width: 100%; height: 30px; border-bottom: 1px dotted #666; font-size: 16px;}
h4 { display: block; padding: 2px; margin: 0 0 10px 0; }
input { width: 350px; }

</style>

<?php include(MODULE_PATH.'/schedule/add_class.php'); ?>


<!-- JavaScript at the bottom for fast page loading -->
<?php 
if($_GET['ajax']==false) {
  include(JS_PATH.'/merge.php'); 
} elseif($_GET['ajax']==true) { ?>
	<script src="<?php Cache::autoVer('/js/src/ajaxify.js'); ?>" type="text/javascript"></script>
<?php }
?>