<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');
  
  $sql_college_list = "SELECT * FROM tbl_Colleges ORDER BY c_name ASC";
  $query_college_list = mysql_query($sql_college_list) or die(mysql_error());
  
  if(isset($_POST['is_sent']) && $_POST['is_sent']=='y') {
	  //form has been submitted...lets validate
	  
	  $errors = false;
	  if($_POST['register_f_name']=='') $errors = true;
	  if($_POST['register_l_name']=='') $errors = true;
	  if($_POST['register_email']=='') $errors = true;
	  if($_POST['register_password']=='') $errors = true;
	  if($_POST['register_dob_m'] < 0 ||
	  	 $_POST['register_dob_d'] < 0 ||
		 $_POST['register_dob_y'] < 0) $errors = true;
	  if($_POST['register_gender'] == '0') $errors = true;
	  if($_POST['register_college'] == '0') $errors = true;
	  
	  if(!$errors) {
		  //no errors, form submitted correctly and fully
		  
		  foreach($_POST as $key=>$val) {
			  echo $val;
		  }
			  
	  }
  }
  
?>

<!-- Non-FB user registration form -->

<h3>Sign Up For My Class Too!</h3>

<form name="frm_register" id="frm_register" class="ui_frm_validate" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
	<?php if($errors) echo UI::notification(3,'Please ensure all fields are completed.','0 0 10px 0'); ?>
    
	<div class="form_row">
    	<label for="register_f_name">First Name:</label>
        <input type="text" name="register_f_name" id="register_f_name" class="required">
    </div>
    
	<div class="form_row">
    	<label for="register_l_name">Last Name:</label>
        <input type="text" name="register_l_name" id="register_l_name" class="required">
    </div>
    
	<div class="form_row">
    	<label for="register_email">Email Address:</label>
        <input type="text" name="register_email" id="register_email" class="required email">
    </div>
    
    <div class="form_row">
    	<label for="register_password">New Password:</label>
        <input type="password" name="register_password" id="register_password" class="required">
    </div>
    
	<div class="form_row">
    	<label for="register_dob">Date of Birth:</label>
        <select name="register_dob_m" class="required">
        	<option value="-1">Month:</option>
        	<option value="01">January</option>
            <option value="02">February</option>
            <option value="03">March</option>
            <option value="04">April</option>
            <option value="05">May</option>
            <option value="06">June</option>
            <option value="07">July</option>
            <option value="08">August</option>
            <option value="09">September</option>
            <option value="10">October</option>
            <option value="12">November</option>
            <option value="12">December</option>
        </select>
        <select name="register_dob_d" class="required">
        	<option value="-1">Day:</option>
        	<?php for($x=01;$x<=31;$x++) {
				echo '<option value="'.str_pad($x, 2, '0', STR_PAD_LEFT).'">'.$x.'</option>';
			}
			?>
        </select>
        
		<select name="register_dob_y" class="required">
        	<option value="-1">Year:</option>
			<?php $end = date("Y");
			$start = $end - 100;
			$range = range($end,$start);
			foreach($range as $year) {
				echo '<option value="'.$year.'">'.$year.'</option>';
			}
			?>
        </select>
  </div>
  
  <div class="form_row">
  		<label for="register_gender">Gender:</label>
        <select name="register_gender" class="required">
        	<option value="0">Select:</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>
  </div>
  
  <div class="form_row">
  		<label for="register_college">Select College:</label>
        <select name="register_college" class="required">
        	<option value="0">Select:</option>
			<?php while($college_list = mysql_fetch_array($query_college_list)) { 
            echo '<option value="'.$college_list['c_id'].'">'.$college_list['c_name'].'</option>';
            $c = $college_list['c_state'];
            } ?>
  		</select>
  </div>
  
  <button type="submit" class="ui_button">Register!</button>
  <input type="hidden" name="is_sent" value="y" />


</form>
