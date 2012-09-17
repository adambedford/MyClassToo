<?php
session_start();
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');
  
  $u_id = $_SESSION['u_id'];
  
  $sql_college_list = "SELECT * FROM tbl_Colleges ORDER BY c_name ASC";
  $query_college_list = mysql_query($sql_college_list) or die(mysql_error());
  $c = '';
  
  $sql_sem_type = "SELECT * FROM tbl_Calendar";
  $query_sem_type = mysql_query($sql_sem_type) or die(mysql_error());
  
  $query_complete_reg = false;
  
  if(isset($_POST['is_sent']) && $_POST['is_sent']=='y') {
	  
	  $college_id = $_POST['reg_college'];
	  //$sem_type = $_POST['reg_sem_type'];
	  
	  $sql_complete_reg = sprintf("UPDATE tbl_Users SET u_college_id = %d WHERE u_id = %d",
	  	mysql_real_escape_string($_POST['reg_college']),
		mysql_real_escape_string($_SESSION['u_id'])
	  );
	  //echo $sql_complete_reg;
	  $query_complete_reg = mysql_query($sql_complete_reg) or die(mysql_error());
	  
	  if($query_complete_reg) {
		 echo UI::notification(1,'Your college information was updated successfully. Click <a href="/account/home/">here</a> to continue.');
	  } else {
		  echo UI::notification(3,'There was an error. Please try again');
	  }
	  /*
	  	Add the college ID to a session for easy access later
	  */
	  $_SESSION['u_college_id'] = $college_id;
  }

  
  if(!$_POST) { 
	
?>

<form name="complete_fb_reg" id="complete_fb_reg" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">

<div class="form_row">
  <label for="reg_college">Select school:</label>
  <select name="reg_college">
	<?php while($college_list = mysql_fetch_array($query_college_list)) { 
		echo '<option value="'.$college_list['c_id'].'"';
		echo ($college_list['c_id']==$_SESSION['u_college_id']) ? 'selected="selected"' : '';
		echo '>'.$college_list['c_name'].'</option>';
		$c = $college_list['c_state'];
    } ?>
  </select>
</div>

<button type="submit" class="ui_button">Complete</button>
<input type="hidden" name="is_sent" value="y">

</form>

<?php } ?>
