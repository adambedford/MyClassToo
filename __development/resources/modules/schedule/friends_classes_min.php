<?php
/*
	Check if the request is AJAX (defined in config) and if so load the config files
*/

if(isset($_GET['ajax']) && $_GET['ajax']==true) {
  require($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');
  require_once(AUTH_PATH.'/fbmain.php');
/*  foreach (glob(CLASS_PATH.'.php') as $filename) { 
	require $filename; 
  }  
*/  
  require(CLASS_PATH.'/connections.php');
  require(CLASS_PATH.'/schedule.php');
}

$sql_terms = sprintf("SELECT DISTINCT * FROM tbl_ClassEntries LEFT JOIN tbl_Calendar ON SUBSTR(tbl_ClassEntries.ce_cal, 3) = tbl_Calendar.cal_code WHERE tbl_ClassEntries.ce_uid = %d GROUP BY tbl_ClassEntries.ce_cal ORDER BY tbl_ClassEntries.ce_cal ASC",
	mysql_real_escape_string($_SESSION['u_id'])
);
$query_terms = mysql_query($sql_terms) or die(mysql_error());
$t = '';


$friend_schedule = new Schedule();
//$rand_classes = $friend_schedule->rand_friends_classes(10);

$timespan = (isset($_GET['timespan']))? $_GET['timespan'] : 'latest';
$who = (isset($_GET['who']))? $_GET['who'] : 'all';
$start = (isset($_GET['start']))? $_GET['start'] : 0;
$limit = (isset($_GET['limit']))? $_GET['limit'] : 10;
$term = (isset($_GET['term']))? $_GET['term'] : Schedule::latest_term($_SESSION['u_id']);
//$term = (isset($_GET['term']))? $_GET['term'] : 1105;

//if(isset($_GET['timespan'])) { $timespan = $_GET['timespan']; } else {$timespan = 'rand'; }

?>

<form name="m_friend_class_filter_frm" id="m_friend_class_filter_frm" action="<?php $_SERVER['PHP_SELF'];?>" method="GET">

<select name="timespan" id="m_friend_class_filter_timespan">
	<option value="rand" <?php if($timespan=='rand') echo ' selected="selected"';?>>Assorted</option>
    <option value="latest" <?php if($timespan=='latest') echo ' selected="selected"';?>>Latest</option>
</select>

<select name="who" id="m_friend_class_filter_who">
	<option value="all" <?php if($who=='all') echo ' selected="selected"';?>>All</option>
    <option value="me" <?php if($who=='me') echo ' selected="selected"';?>>Me</option>
</select>

<select name="term" id="m_friend_class_filter_term">
	<?php
    while($terms = mysql_fetch_array($query_terms)) {
        if($t != $terms['ce_cal']) {
        echo '<option value="'.$terms['ce_cal'].'"';
        if($term == $terms['ce_cal']) { echo ' selected="selected"'; } 
        echo '>'.ucwords($terms['cal_label'].' '.substr($terms['ce_cal'],0,2)).'</option>';
        }
        $t = $terms['ce_cal'];
    } 
    ?>
</select>

<button type="submit" class="ui_button" id="m_friend_class_filter_submit">Filter</button>
<input type="hidden" name="start_count" id="m_friend_class_filter_start_count" value="<?php echo $start;?>">
</form>

<?php
echo '<div id="m_friend_class_content">';

//print_r($friend_schedule->classmates_min_select('rand','me',1105,0,10));
$f_s = $friend_schedule->classmates_min_select($timespan,$who,$term,$start,$limit);
if(!empty($f_s)) {
  foreach ($f_s as $key=>$val) {
	  
	  echo '<div class="m_friend_class_element">';
	  if($who=='me') {
		  echo '<a href="/account/schedule/view/'.$val['u_id'].'/">'.$val['u_first_name'].'</a> is in your <a href="/account/schedule/classmates.php?ce_class_id='.$val['cl_id'].'">'.$val['cl_course_id'].' '.$val['cl_class_name'].'</a>';
	  } else {
		  echo '<a href="/account/schedule/view/'.$val['u_id'].'/">'.$val['u_first_name'].'</a> is taking <a href="/account/schedule/classmates.php?ce_class_id='.$val['cl_id'].'">'.$val['cl_course_id'].' '.$val['cl_class_name'].'</a> with '.$val['ce_professor_name'];
	  }
	  echo '</div>';
	  
  }
} else {
	
	echo '<div class="alert ui-state-highlight ui-corner-all"><span class="icon ui-icon ui-icon-info"></span>Your search returned no matches.</div>';
	
}
	
echo '</div>';

if(!isset($_GET['ajax']) && $_GET['ajax']==false) { echo '<div id="m_friend_class_more"><a href="#">Show More</a></div>'; }


?>