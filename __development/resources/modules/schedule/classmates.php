<?php
/*
	Query and return the list of all terms the user has created schedules for.
*/
$sql_terms = "SELECT DISTINCT * FROM tbl_ClassEntries LEFT JOIN tbl_Calendar ON SUBSTR(tbl_ClassEntries.ce_cal, 3) = tbl_Calendar.cal_code WHERE tbl_ClassEntries.ce_uid = '{$_SESSION['u_id']}' GROUP BY tbl_ClassEntries.ce_cal ORDER BY tbl_ClassEntries.ce_cal ASC";
$query_terms = mysql_query($sql_terms) or die(mysql_error());
$t = '';


if(isset($_POST['is_sent']) && $_POST['is_sent'] == 'y') {
  
  /*
  	The form has been submitted. ie. the user has searched for a particular result. Give it to them!
  */

  /*
  	Get the values from the submitted search form.
  */
  
  $class_id = $_POST['classmates_search_class_ce_id'];
  foreach($_POST as $key=>$val) {
	if($key == 'classmates_search_recurrence') {
		$recurrence = implode(',',$val);
	}
  }
  $start_time = $_POST['classmates_search_class_start_time'];
  $term = $_POST['classmates_search_term'];
  
} else {
	
	/*
		The search form hasnt been used, so values will be in $_GET.
	*/
	$class_id = $_GET['ce_class_id'];
	$recurrence = $_GET['ce_recurrence'];
	$start_time = $_GET['ce_start_time'];
	$term = $_GET['ce_term'];

}



$classmates = new Schedule;
//echo "<pre>";
//print_r($classmates->classmates($_GET['ce_class_id'], $_GET['ce_recurrence'], $_GET['ce_start_time']));
//echo "</pre>";

$sql_get_classname = "SELECT * FROM tbl_ClassList WHERE cl_id = '$class_id'";
$query_get_classname = mysql_query($sql_get_classname) or die(mysql_error());
$get_classname = mysql_fetch_array($query_get_classname);

?>
<h3>Who's taking what classes?</h3>


<form name="classmates_search_form" id="classmates_search_form" class="ui-widget-header ui-corner-all clearfix" action"<?php $_SERVER['PHP_SELF'];?>" method="POST">

<div class="classmates_search_wrapper">
  <input type="text" name="classmates_search_class_search" id="classmates_search_class_search" class="class_search" placeholder="Enter a course code (eg. BUS100) or class name (eg. Intro to Business)">
  <input type="hidden" name="classmates_search_class_ce_id">
</div>

<div class="classmates_search_wrapper">
  <label for="classmates_search_class_start_time">Starting at: </label>
  <input type="time" value="09:00" step="300" name="classmates_search_class_start_time" id="classmates_search_class_start_time">
</div>

<div class="classmates_search_wrapper">
  <div class="ui_buttonset">
    <input type="checkbox" name="classmates_search_recurrence[]" id="classmates_search_recurrence_m" value="m">
    <label for="classmates_search_recurrence_m">Mon</label>
    <input type="checkbox" name="classmates_search_recurrence[]" id="classmates_search_recurrence_t" value="t">
    <label for="classmates_search_recurrence_t">Tues</label>
    <input type="checkbox" name="classmates_search_recurrence[]" id="classmates_search_recurrence_w" value="w">
    <label for="classmates_search_recurrence_w">Weds</label>
    <input type="checkbox" name="classmates_search_recurrence[]" id="classmates_search_recurrence_th" value="th">
    <label for="classmates_search_recurrence_th">Thurs</label>
    <input type="checkbox" name="classmates_search_recurrence[]" id="classmates_search_recurrence_f" value="f">
    <label for="classmates_search_recurrence_f">Fri</label>
  </div>
</div>
<div class="classmates_search_wrapper">
      <select name="classmates_search_term" id="classmates_search_term" class="classmates_search_term ui_selectmenu">
	  <?php
      while($terms = mysql_fetch_array($query_terms)) {
          if($t != $terms['ce_cal']) {
          echo '<option value="'.$terms['ce_cal'].'"';
          echo '>'.ucwords($terms['cal_label'].' '.substr($terms['ce_cal'],0,2)).'</option>';
          }
          $t = $terms['ce_cal'];
      }
      ?>
    </select>
</div>
<div class="classmates_search_wrapper">
  <button type="submit" class="ui_button">Search</button>
</div>
<input type="hidden" name="is_sent" value="y">
</form>

<?php
if($class_id != '') { echo '<h4>'.$get_classname['cl_course_id'].': '.$get_classname['cl_class_name'].'</h4>'; }

echo '<div id="classmates_search_criteria" style="margin: 0 0 20px 0">';
if($start_time != '') { echo '<p>Starting: '.$start_time.'</p>'; }
if($recurrence != '') {
  echo '<p>On: ';
  echo Schedule::day_string_to_days($recurrence);
  echo '</p>';
}
if($term != '') { echo '<p>'.Schedule::term_to_label($term).'</p>'; }
echo '</div>';

echo '<div id="classmates_view">';

$classmates = $classmates->classmates($class_id, $recurrence, $start_time, $term);

foreach($classmates as $key=>$val) {
	
	echo '<div class="user_view_element clearfix">';
	
	echo '<img src="http://graph.facebook.com/'.$val['u_oauth_uid'].'/picture">
		 <a href="'.$config['urls']['baseUrl'].'/account/schedule/view.php?u_id='.$val['u_id'].'">'.$val['u_first_name'].' '.$val['u_last_name'].' </a><span> is taking '.$val['cl_course_id'].': '.$val['cl_class_name'].' at '.$val['ce_start_time'].' on '.Schedule::day_string_to_days($val['ce_recurrence']).'</span><br>
	
		 </div>';
}

echo '</div>';
?>