<?php

$step = 1;					//	New to the page, show step 1 form first.

if(isset($_POST['frm_create_study_group']) && $_POST['frm_create_study_group']=='y') {
	
	//form submitted...
	
	$step++;				//	Step 1 form submitted, increment counter to display next step next.
	
	$env_type = 1;			//	Creating study group, so type = 1.
	
	$sql_new_sg = sprintf("INSERT INTO tbl_Environments (en_type,en_name,en_cause,en_description,en_owner) VALUES (%d, %s, %d, %s, %d)",
		mysql_real_escape_string($env_type),
		mysql_real_escape_string($_POST['c_sg_name']),
		mysql_real_escape_string($_POST['c_sg_class_id']),
		mysql_real_escape_string($_POST['c_sg_description']),
		mysql_real_escape_string($user['u_id'])					// Parent page defines $user function
		);
		
	echo $sql_new_sg;
	
}

?>

<?php if ($step == 1) { ?>

<form name="frm_create_study_group" id="frm_create_study_group" class="int_frm" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
	
    <h4>Step 1: Study Group Information</h4>
    
    <div class="form_row">
    	<label for="c_sg_name">Study Group Name:</label>
        <input type="text" name="c_sg_name" />
    </div>
    
    <div class="form_row">
    	<label for="c_sg_class_id">Related Class (optional):</label>
        <input type="text" name="c_sg_class_id" />
    </div>
    
    <div class="form_row">
    	<label for="c_sg_description">Description:</label>
        <textarea name="c_sg_description"></textarea>
    </div>
    
    <button type="submit" class="ui_button">Create</button>
    <input type="hidden" name="frm_create_study_group" value="y" />
    
</form>

<?php } ?>

<?php if ($step == 2) { ?>

<form name="frm_create_study_group_2" id="frm_create_study_group" class="int_frm" action="<?php $_SERVER['PHP_SELF']; ?>" method="post">
	
    <h4>Step 2: Invite Some Classmates</h4>
    
    <div class="form_row">
    	<label for="c_sg_add_classmates">Select Classmates:</label>
        <select name="c_sg_add_classmates">
        	<?php
			$connections = new Connections();
			$level = 2;			// level 2 = classmates.
			$classmates = $connections->accessible_users($user['u_id'],$level,$term,$_SESSION['u_college_id']);
			
			foreach ($classmates as $key => $val) {
				echo '<option value="'.$val['u_id'].'">'.$val['u_first_name'].' '.$val['u_last_name'].'</option>< /br>';
			}
			?>
        </select>
    </div>


</form>

<?php } ?>