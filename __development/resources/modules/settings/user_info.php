<?php
session_start();
require($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');

if(!isset($_GET['u_u_info_is_sent'])) {
	$sql_u_info = sprintf("SELECT * FROM tbl_Users WHERE u_id = %d LIMIT 1",
		mysql_real_escape_string($_SESSION['u_id'])
	);
	$query_u_info = mysql_query($sql_u_info) or die(mysql_error());
	$u_info = mysql_fetch_array($query_u_info);
}

if(isset($_GET['u_u_info_is_sent']) && $_GET['u_u_info_is_sent']=='y') {
	$sql_update_user = sprintf("UPDATE tbl_Users SET u_first_name = '%s', u_last_name = '%s', u_email = '%s' WHERE u_id = '{$_SESSION['u_id']}'",
		mysql_real_escape_string($_GET['u_u_info_f_name']),
		mysql_real_escape_string($_GET['u_u_info_l_name']),
		mysql_real_escape_string($_GET['u_u_info_email'])
	);
	$query_update_user = mysql_query($sql_update_user) or die(mysql_error());
	
	if($query_update_user) {
		echo UI::notification(1,'Your user information was successfully updated.');
	} else {
		echo UI::notification(3,'There was an error. Please try again');
	}
	  
	// requery the DB to get new/updated info for the user
	$sql_u_info = sprintf("SELECT * FROM tbl_Users WHERE u_id = %d LIMIT 1",
		mysql_real_escape_string($_SESSION['u_id'])
	);
	$query_u_info = mysql_query($sql_u_info) or die(mysql_error());
	$u_info = mysql_fetch_array($query_u_info);

}

?>

<form name="update_u_info" id="update_u_info" action="<?php $_SERVER['PHP_SELF'];?>" method="GET">

<div class="form_row">
<label for="u_u_info_f_name">First Name:</label>
<input type="text" name="u_u_info_f_name" id="u_u_info_f_name" class="update_u_info_txt" value="<?php echo $u_info['u_first_name'];?>">
</div>

<div class="form_row">
<label for="u_u_info_l_name">Last Name:</label>
<input type="text" name="u_u_info_l_name" id="u_u_info_l_name" class="update_u_info_txt" value="<?php echo $u_info['u_last_name'];?>">
</div>

<div class="form_row">
<label for="u_u_info_email">Email:</label>
<input type="text" name="u_u_info_email" id="u_u_info_email" class="update_u_info_txt" value="<?php echo $u_info['u_email'];?>">
</div>

<button class="ui_button">Update</button>
<input type="hidden" name="u_u_info_is_sent" value="y">

</form>