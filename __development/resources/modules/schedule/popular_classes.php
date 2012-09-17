<?php

session_start();
require($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');
/*  require_once(AUTH_PATH.'/fbmain.php');
  foreach (glob(CLASS_PATH.'/*.php') as $filename) { 
	require $filename; 
  }
*/  

$cur_term =  Schedule::current_term();

$sql_pop_class = "SELECT * FROM tbl_ClassEntries LEFT JOIN tbl_ClassList ON tbl_ClassEntries.ce_class_id = tbl_ClassList.cl_id WHERE tbl_ClassEntries.ce_cal = $cur_term AND tbl_ClassList.cl_college_id = '{$_SESSION['u_college_id']}'";
//echo $sql_pop_class;
$query_pop_class = mysql_query($sql_pop_class) or die(mysql_error());

$classes = array();
while($pop_class = mysql_fetch_assoc($query_pop_class)) {
	//loop through all classes for selected semester and construct array of info + occurence count
	$classes[] = array(
		"cl_id"		=>	$pop_class['cl_id'],
		"cl_course_id"	=>	$pop_class['cl_course_id'],
		"cl_class_name"	=>	$pop_class['cl_class_name'],
		"cl_count"		=>	mysql_num_rows(mysql_query("SELECT * FROM tbl_ClassEntries WHERE ce_class_id = '{$pop_class['cl_id']}'"))
	);
}
echo "<pre>";
print_r($classes);
echo "</pre>";
?>