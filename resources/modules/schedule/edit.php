<?php
session_start();

echo '<h3>Edit your '.Schedule::term_to_label($_GET['term']).' schedule</h3>';

/*require_once($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');
require_once(JS_PATH.'/merge.php');
require_once(STYLE_PATH.'/merge.php');
foreach (glob(CLASS_PATH.'/*.php') as $filename) { 
  include $filename; 
}  
*/
/*
	Fetch the current user's information.
	We'll use u_college_id later 
*/
$sql_user_info = sprintf("SELECT * FROM tbl_Users WHERE u_id = %d",
	mysql_real_escape_string($_SESSION['u_id'])
);
$query_user_info = mysql_query($sql_user_info) or die(mysql_error());
$user_info = mysql_fetch_assoc($query_user_info);

if($_POST && $_POST['is_sent']=='y') {
	
	$u_id = $_SESSION['u_id'];
	
	$recurrence = '';
	$partial_sql_create_sched = array();
	$update_count = 0;
	
	foreach($_POST['sched_edit'] as $key=>$val) {
	  
		foreach($val as $akey=>$aval) {
			if($akey=='recurrence') {
				$recurrence = implode(',',$aval);
			}
		}
	  
	  
		
	  /*
		No errors, run the update query
		Can't construct a multi-row query and update at once, so we'll loop through records and update one
		at a time.
	  */
	  $sql_update_sched = sprintf("UPDATE tbl_ClassEntries SET ce_recurrence = '%s', ce_start_time = '%s', ce_end_time = '%s', ce_professor_name = '%s' WHERE ce_id = %d",
	  mysql_real_escape_string($recurrence),
	  mysql_real_escape_string($val['start_time']),
	  mysql_real_escape_string($val['end_time']),
	  mysql_real_escape_string($val['professor_name']),
	  mysql_real_escape_string($val['id'])
	  );
	  $query_update_sched = mysql_query($sql_update_sched) or die(mysql_error());
//	  echo $sql_update_sched.'<br><br>';
	  if($query_update_sched) { $update_count++; };			  
		
	}
	
	
	if($update_count >= 1) {

		echo UI::notification(1,'You have updated information for '.$update_count.' classes!');
	} else {
		echo UI::notification(3,'There was an error. Please try again.');
	}
	
} else {

/*
	Return the list of classes for the user & term
*/	

$sql_user_classes = sprintf("SELECT * FROM tbl_ClassEntries LEFT JOIN tbl_ClassList	ON tbl_ClassEntries.ce_class_id = tbl_ClassList.cl_id WHERE tbl_ClassEntries.ce_uid = %d AND tbl_ClassEntries.ce_cal = '%s' AND tbl_ClassEntries.ce_active = '1'",
	mysql_real_escape_string($_SESSION['u_id']),
	mysql_real_escape_string($_GET['term'])
);
$query_user_classes = mysql_query($sql_user_classes) or die(mysql_error());

?>
<form name="sched_edit" id="sched_edit" action="<?php $_SERVER['PHP_SELF'];?>" method="post">

<?php
$i=0;
while($user_classes = mysql_fetch_array($query_user_classes)) {

/*
	Split recurrence up into array for later 
*/
$recurrence = explode(',',$user_classes['ce_recurrence']);

?>
<div class="form_row clearfix">
  <div class="form_row_element create_sched_field">
    <label for="sched_edit[<?php echo $i;?>][search]">Course ID:</label>
    <input type="text" name="sched_edit[<?php echo $i;?>][label]" class="class_search" id="sched_edit_label_<?php echo $i;?>" disabled="disabled" value="<?php echo $user_classes['cl_course_id'].': '.$user_classes['cl_class_name'];?>">
    <input type="hidden" name="sched_edit[<?php echo $i;?>][id]" class="sched_edit_id" id="sched_edit_id_<?php echo $i;?>" value="<?php echo $user_classes['ce_id'];?>">
  </div>
  <div class="form_row_element create_sched_field">
    <label for="sched_edit[<?php echo $i;?>][start_time]">Start time:</label>
    <input type="time" step="300" name="sched_edit[<?php echo $i;?>][start_time]" id="sched_edit_start_time_<?php echo $i;?>" value="<?php echo $user_classes['ce_start_time'];?>">
  </div>
  
  <div class="form_row_element create_sched_field">
    <label for="sched_edit[<?php echo $i;?>][start_time]">End time:</label>
    <input type="time" step="300" name="sched_edit[<?php echo $i;?>][end_time]" id="sched_edit_end_time_<?php echo $i;?>" value="<?php echo $user_classes['ce_end_time'];?>">
  </div>
  
  <div class="form_row_element create_sched_field">
    <label for="sched_edit[<?php echo $i;?>][recurrence]">Recurrence:</label>
    
    <div class="ui_buttonset" style="display:inline-block;">
      <input type="checkbox" name="sched_edit[<?php echo $i;?>][recurrence][]" id="sched_edit_recurrence_<?php echo $i;?>_m" value="m" <?php if(in_array('m',$recurrence)) { echo 'checked="checked"'; }?>>
      <label for="sched_edit_recurrence_<?php echo $i;?>_m">M</label>
      
      <input type="checkbox" name="sched_edit[<?php echo $i;?>][recurrence][]" id="sched_edit_recurrence_<?php echo $i;?>_t" value="t" <?php if(in_array('t',$recurrence)) { echo 'checked="checked"'; }?>>
      <label for="sched_edit_recurrence_<?php echo $i;?>_t">T</label>
      
      <input type="checkbox" name="sched_edit[<?php echo $i;?>][recurrence][]" id="sched_edit_recurrence_<?php echo $i;?>_w" value="w" <?php if(in_array('w',$recurrence)) { echo 'checked="checked"'; }?>>
      <label for="sched_edit_recurrence_<?php echo $i;?>_w">W</label>
      
      <input type="checkbox" name="sched_edit[<?php echo $i;?>][recurrence][]" id="sched_edit_recurrence_<?php echo $i;?>_th" value="th" <?php if(in_array('th',$recurrence)) { echo 'checked="checked"'; }?>>
      <label for="sched_edit_recurrence_<?php echo $i;?>_th">Th</label>
      
      <input type="checkbox" name="sched_edit[<?php echo $i;?>][recurrence][]" id="sched_edit_recurrence_<?php echo $i;?>_f" value="f"<?php if(in_array('f',$recurrence)) { echo 'checked="checked"'; }?>>
      <label for="sched_edit_recurrence_<?php echo $i;?>_f">F</label>
    </div>

  </div>
  
  <div class="form_row_element create_sched_field">
    <label for"sched_edit[<?php echo $i;?>][professor_name]">Professor's name:</label>
    <input type="text" name="sched_edit[<?php echo $i;?>][professor_name]" id="sched_edit_professor_name<?php echo $i;?>" value="<?php echo $user_classes['ce_professor_name'];?>">
  </div>
  <div class="sched_edit_delete"><a href="/resources/scripts/php/delete_class_entry.php?ce_id=<?php echo $user_classes['ce_id'];?>" class="ui_button sched_edit_delete_link">x</a>
  </div>
</div>
<br />
<?php 
$i++;
} ?>

<button type="submit" class="ui_button">Update</button>
<input type="hidden" name="u_id" value="<?php echo $_GET['u_id'];?>">
<input type="hidden" name="is_sent" value="y">
<input type="hidden" name="cl_college_id" id="cl_college_id" value="<?php echo $user_info['u_college_id'];?>" />

</form>

<div id="ui_dialog_container"></div>

<?php
}
    function d($d){
        echo '<pre>';
        print_r($d);
        echo '</pre>';
    }


?>