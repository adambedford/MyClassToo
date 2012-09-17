<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');

$cl_course = $_GET['term'];
//$cl_college_id = $_GET['cl_college_id'];
$cl_college_id = $_SESSION['u_college_id'];

if(strlen($cl_course) > 0) {

	$sql_course_info = sprintf("SELECT * FROM tbl_ClassList WHERE cl_college_id = $cl_college_id AND (cl_course_id LIKE '%s' OR cl_class_name LIKE '%s') LIMIT 30",
		mysql_real_escape_string($cl_course.'%'),
		mysql_real_escape_string('%'.$cl_course.'%')
	);
	$query_course_info = mysql_query($sql_course_info) or die(mysql_error());
	
	//if($num_rows=mysql_num_rows($query_course_info)) {
		
		//matching course found at correct college
		
		//build array of results
		//$json = '[';
		$json = array();
		//$first = true;
		if(mysql_num_rows($query_course_info) > 0) {
		
			while($course_info = mysql_fetch_assoc($query_course_info)) {
				
	/*			if(!$first) { $json .= ','; } else { $first = false; }
				$json .= '{"cl_course_id":"'.$course_info['cl_course_id'].'", "cl_class_name":"'.$course_info['cl_class_name'].'", "cl_id":"'.$course_info['cl_id'].'"}';
	*/			
				$json[] = $course_info;
			}
			
		} else {
			$json[] = array (
				"cl_id"			=>	0,
				"cl_course_id"	=>	"No Classes",
				"cl_class_name"	=>	"Found"
			);
		}
		//$json .= ']';
		echo json_encode($json);
		
		/*
		$course_ids = array();
		for($i=0; $i<$num_rows; $i++) {
			
			$course_info = mysql_fetch_array($query_course_info);
			$course_ids[$i] = array(
				"cl_course_id"	=> $course_info['cl_course_id'],
				"cl_class_name"	=> $course_info['cl_class_name']
			);
			
		}
		
		$return = json_encode($course_ids);
		echo $return;
		
		*/
		
		
		
		
		
		/*
		echo '<ul>';
		while($course_info = mysql_fetch_array($query_course_info)) {
			
			echo '<li onclick="fill(\''.addslashes($course_info['cl_course_id']).'\',\''.addslashes($course_info['cl_class_name']).'\');">'.$course_info['cl_course_id'].': '.$course_info['cl_class_name'].'</li>';
			
		}
		echo '</ul>';
		
		*/
	}

/*} else {
	// do nothing
	//echo "The class could not be found. Try adding it";
}
*/
?>