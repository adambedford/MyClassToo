<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');
foreach (glob(CLASS_PATH.'/*.php') as $filename) { 
  require_once $filename; 
}  


$schedule = new Schedule();
$sched = $schedule->gen_schedule('1','1','1105');

echo "<pre>";
print_r($sched);
echo "</pre>";

?>