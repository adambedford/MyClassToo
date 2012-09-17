<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');
foreach (glob(CLASS_PATH.'/*.php') as $filename) { 
  require_once $filename; 
}  


$connections = new Connections();
//$accessible = $connections->accessible_users(1,2);

$classmates = $connections->is_classmate(1,50);
$fb = $connections->is_fb_friend(1,42);
$cm = $connections->is_classmate(1,8,1105);
$sm = $connections->is_schoolmate(1,43);
/*print_r($fb);

print_r($sm);*/
print_r($cm);
$rel = $connections->user_relationship(1,8,1105);
print_r($rel);
?>