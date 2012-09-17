<?php
$flag = false;
$u_notifications = array();
$today = date('Y-m-d');

$sql_notifications = "SELECT * FROM tbl_Notifications WHERE DATE(n_starts) <= CURDATE() AND DATE(n_expires) >= CURDATE()";
$query_notifications = mysql_query($sql_notifications) or die(mysql_error());

while($notifications = mysql_fetch_assoc($query_notifications)) {
	
	$affected_users = explode(',',$notifications['n_users_affected']);
	
	foreach($affected_users as $user) {
		
		if ($user==$_SESSION['u_id'] || $user =='0' || $user == '') {
			
			// flag that the user has a notification
			$flag = true;
			
			$u_notifications[] = $notifications;
			
		}
		
	}
	
}
/*echo "<pre>";
print_r($u_notifications);
echo "</pre>";
*/
if($flag) {
	
	echo '<div class="mod_notifications">';
	
	foreach($u_notifications as $key => $val) {
		
		echo UI::notification($val['n_severity'],$val['n_content']);
		
	}
	
	echo '</div>';
	
}


?>