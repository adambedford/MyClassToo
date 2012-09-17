<?php
  require_once($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');
  
  $u_id = $_GET['u_id'];
  
  $sql_college_list = "SELECT * FROM tbl_Colleges";
  $query_college_list = mysql_query($sql_college_list) or die(mysql_error());
  
  $sql_sem_type = "SELECT * FROM tbl_Calendar";
  $query_sem_type = mysql_query($sql_sem_type) or die(mysql_error());
  
  $query_complete_reg = false;
  
  if($_POST && $_POST['is_sent']=='y') {
	  
	  $u_id = $_POST['u_id'];
	  $college_id = $_POST['reg_college'];
	  //$sem_type = $_POST['reg_sem_type'];
	  
	  $sql_complete_reg = "UPDATE tbl_Users SET u_college_id = '{$_POST['reg_college']}' WHERE u_id = '{$_POST['u_id']}'";
	  //echo $sql_complete_reg;
	  $query_complete_reg = mysql_query($sql_complete_reg) or die(mysql_error());
	  
	  
  }


?>

<h2>Complete your registration!</h2>

<?php 
  if($query_complete_reg) {
	  echo 'Your account is now complete! Click <a href="'.$config['urls']['baseUrl'].'/account/home.php">here</a> to continue';
  }
  
  if(!$_POST) { 
?>

<form name="complete_fb_reg" id="complete_fb_reg" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">

<div class="form_field">
  <label for="reg_college">Select school:</label>
  <select name="reg_college">
	<?php while($college_list = mysql_fetch_array($query_college_list)) { ?>
    <option value="<?php echo $college_list['c_id'];?>"><?php echo $college_list['c_name'];?></option>
    <?php } ?>
  </select>
</div>

<div class="form_field">
  <label for="reg_sem_type">Calendar type:</label>
  <?php while($sem_type = mysql_fetch_array($query_sem_type)) { ?>
  <input type="radio" name="reg_sem_type" value="<?php echo $sem_type['cal_id'];?>"><?php echo ucfirst($sem_type['cal_sem_type']);?><br>
  <?php } ?>
</div>

<button type="submit">Complete</button>
<input type="hidden" name="u_id" value="<?php echo $u_id;?>">
<input type="hidden" name="is_sent" value="y">

</form>

<?php } ?>
