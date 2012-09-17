<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');
require_once(SCRIPT_PATH.'/js/merge.php');
require_once(TEMPLATES_PATH.'/css/merge.php');
foreach (glob(CLASS_PATH.'/*.php') as $filename) { 
  include $filename; 
}  

/*
	Fetch the current user's information.
	We'll use u_college_id later 
*/
$sql_user_info = "SELECT * FROM tbl_Users WHERE u_id = '{$_GET['u_id']}'";
$query_user_info = mysql_query($sql_user_info) or die(mysql_error());
$user_info = mysql_fetch_assoc($query_user_info);

if($_POST && $_POST['is_sent']=='y') {
	
	$u_id = $_GET['u_id'];
	
	$recurrence = '';
	$partial_sql_create_sched = array();
	$count_entries = 0;
	
	foreach($_POST['sched_create'] as $key=>$val) {
		
		if($val['search']) {
			$count_entries++;
			foreach($val as $akey=>$aval) {
				if($akey=='recurrence') {
					$recurrence = implode(',',$aval);
				}
			}
	  
		
			
		/*
			No errors, construct query string to add class
		*/
			$partial_sql_create_sched[] = '("'.$val['id'].'", "'.$recurrence.'", "'.$val['start_time'].'", "'.$val['end_time'].'", "'.$val['professor_name'].'", '.$u_id.', '.$_POST['sched_create_term'].')';
			  
			  
		
		}
		
	}
	
	
	$sql_create_sched = "INSERT INTO tbl_ClassEntries (ce_class_id, ce_recurrence, ce_start_time, ce_end_time, ce_professor_name, ce_uid, ce_cal) VALUES ".implode(',',$partial_sql_create_sched);
	
	if($count_entries >= 1) {
		$query_create_sched = mysql_query($sql_create_sched) or die(mysql_error());
	}
	
} else {
	//query the db to get info about semester/quarter
	$sql_college_term = "SELECT c_term_type FROM tbl_Colleges WHERE c_id = '{$_SESSION['u_college_id']}'";
	$query_college_term = mysql_query($sql_college_term) or die(mysql_error());
	$college_term = mysql_fetch_array($query_college_term);
	
	$sql_term_options = "SELECT * FROM tbl_Calendar WHERE cal_type = '{$college_term['c_term_type']}'";
	$query_term_options = mysql_query($sql_term_options) or die(mysql_error());
	
	$term_list = array();
	$cur_year = date('y');
	while($term_options = mysql_fetch_array($query_term_options)) {
/*		switch($term_options['cal_code']) {
			case  1 || 6:
				$term_list[] = 'Fall';
				break;
			case 2:
				$term_list[] = 'Interterm';
				break;
			case 7:
				$term_list[] = 'Winter';
				break;
			case 3 || 8:
				$term_list[] = 'Spring';
				break;
			case 4 || 9:
				$term_list[] = 'Summer I';
				break;
			case 5 || 10:
				$term_list[] = 'Summer II';
				break;
		}
*/		
		for($y=$cur_year;$y<$cur_year+2;$y++) {
			
			$term_list[] = array(
				"id"		=>	$y.str_pad($term_options['cal_code'],2,'0',STR_PAD_LEFT),
				"label"		=>	ucwords($term_options['cal_label'].' '.$y)
			);
			
/*			if($term_options['cal_code'] == 01 || $term_options['cal_code'] == 06) {
				$term_list[] = array(
					"id"	=> 	$y.str_pad($term_options['cal_code'],2,'0',STR_PAD_LEFT),
					"label"	=>	"Fall ".$y
					);
			} elseif($term_options['cal_code'] == 02) {
				$term_list[] = array(
					"id"	=> 	$y.str_pad($term_options['cal_code'],2,'0',STR_PAD_LEFT),
					"label"	=>	"Interterm ".$y
					);
			} elseif($term_options['cal_code'] == 07) {
				$term_list[] = array(
					"id"	=> 	$y.str_pad($term_options['cal_code'],2,'0',STR_PAD_LEFT),
					"label"	=>	"Winter ".$y
					);
			} elseif($term_options['cal_code'] == 03 || $term_options['cal_code'] == 08) {
				$term_list[] = array(
					"id"	=> 	$y.str_pad($term_options['cal_code'],2,'0',STR_PAD_LEFT),
					"label"	=>	"Spring ".$y
					);
			} elseif($term_options['cal_code'] == 04 || $term_options['cal_code'] == 09) {
				$term_list[] = array(
					"id"	=> 	$y.str_pad($term_options['cal_code'],2,'0',STR_PAD_LEFT),
					"label"	=>	"Summer I ".$y
					);
			} elseif($term_options['cal_code'] == 05 || $term_options['cal_code'] == 10) {
				$term_list[] = array(
					"id"	=> 	$y.str_pad($term_options['cal_code'],2,'0',STR_PAD_LEFT),
					"label"	=>	"Summer II ".$y
					);
			}
*/		
		}
	}
	echo "<pre>";
	print_r($term_list);
	echo "</pre>";
	
/*
	Call the orderBy function to sort the array by the field 'id'. This will put the term options in chronological order
*/
    $term_list = Sort::orderBy($term_list,'id');
	
	//the form hasnt been submitted yet, so display it
?>

<form name="sched_create" id="sched_create" action="<?php $_SERVER['PHP_SELF'];?>" method="post">
<select name="sched_create_term">
<?php
foreach($term_list as $key=>$val) {

	echo '<option value="'.$val['id'].'">'.$val['label'].'</option>';
	foreach($val as $tkey=>$tval) {
	}
}
?>
</select>
<?php
$repeat = 5;
for($i=0;$i<$repeat;$i++) {

?>

<div class="form_field">
  <label for="sched_create[<?php echo $i;?>][search]">Course ID:</label>
  <input type="text" name="sched_create[<?php echo $i;?>][search]" class="sched_create_search" id="sched_create_search_<?php echo $i;?>">
  <input type="hidden" name="sched_create[<?php echo $i;?>][id]" class="sched_create_id" id="sched_create_id_<?php echo $i;?>">
  <a href="<?php echo $config['urls']['baseUrl'].'/resources/templates/includes/create_schedule_add_class.php?cl_college_id='.$user_info['u_college_id'];?>" class="ui_button">+</a>
</div>
<div class="form_field">
  <label for="sched_create[<?php echo $i;?>][start_time]">Start time:</label>
  <input type="time" value="09:00" step="300" name="sched_create[<?php echo $i;?>][start_time]" id="sched_create_start_time_<?php echo $i;?>">
</div>

<div class="form_field">
  <label for="sched_create[<?php echo $i;?>][start_time]">End time:</label>
  <input type="time" value="09:00" step="300" name="sched_create[<?php echo $i;?>][end_time]" id="sched_create_end_time_<?php echo $i;?>">
</div>

<div class="form_field">
  <label for="sched_create[<?php echo $i;?>][recurrence]">Recurrence:</label>
  <input type="checkbox" name="sched_create[<?php echo $i;?>][recurrence][]" value="m">
  <input type="checkbox" name="sched_create[<?php echo $i;?>][recurrence][]" value="t">
  <input type="checkbox" name="sched_create[<?php echo $i;?>][recurrence][]" value="w">
  <input type="checkbox" name="sched_create[<?php echo $i;?>][recurrence][]" value="th">
  <input type="checkbox" name="sched_create[<?php echo $i;?>][recurrence][]" value="f">
</div>

<div class="form_field">
  <label for"sched_create[<?php echo $i;?>][professor_name]">Professor's name:</label>
  <input type="text" name="sched_create[<?php echo $i;?>][professor_name]" id="sched_create_professor_name<?php echo $i;?>">
</div>
<br />
<?php } ?>

<button type="submit" class="ui_button">Create!</button>
<input type="hidden" name="u_id" value="<?php echo $_GET['u_id'];?>">
<input type="hidden" name="is_sent" value="y">
<input type="hidden" name="cl_college_id" id="cl_college_id" value="<?php echo $user_info['u_college_id'];?>" />

</form>



<?php
}
    function d($d){
        echo '<pre>';
        print_r($d);
        echo '</pre>';
    }


?>