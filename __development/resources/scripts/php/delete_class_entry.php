<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');
require_once(AUTH_PATH.'/fbmain.php');
foreach (glob(CLASS_PATH.'/*.php') as $filename) { 
  require_once $filename; 
}  
if(isset($_GET['ce_id'])) {				
	$ce_id = mysql_escape_string($_GET['ce_id']);
	$sql_delete_class = sprintf("DELETE FROM tbl_ClassEntries WHERE ce_id = %d LIMIT 1",
		mysql_real_escape_string($ce_id)
	);
	$query_delete_class = mysql_query($sql_delete_class) or die(mysql_error());
	//$query_delete_class = true;
	
	if($query_delete_class) {
		echo '<div id="response" class="success ui-state-success ui-corner-all" style="margin:20px 0 20px 0;" data-status="success"><span class="icon ui-icon ui-icon-check"></span>The class has been successfully removed from your schedule.</div>';
	} else {
		echo '<div id="response" class="error ui-state-error ui-corner-all" style="margin:20px 0 20px 0;" data-status="error"><span class="icon ui-icon ui-icon-alert"></span>There was an error. Please try again.</div>';
	}
	


}