<?php

if(isset($_GET['alert']) && $_GET['alert']==true) {
	
	echo UI::notification($_GET['alert_type'],$_GET['alert_content']);
	
	
	
}


?>
