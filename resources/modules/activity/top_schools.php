<?php

$sql_top_schools = "SELECT * FROM tbl_Colleges LEFT OUTER JOIN tbl_Users ON tbl_Colleges.c_id = tbl_Users.u_college_id  WHERE tbl_Users.u_id != '' GROUP BY tbl_Users.u_college_id  ORDER BY COUNT(tbl_Users.u_college_id = tbl_Colleges.c_id) DESC LIMIT 15";
$query_top_schools = mysql_query($sql_top_schools) or die(mysql_error());

echo '<ul id="h_b_top_schools">';

while($top_schools = mysql_fetch_array($query_top_schools)) {
	
	echo '<li>'.$top_schools['c_name']/*.', '.ucwords($top_schools['c_state'])*/.'</li>';
	
}

echo '</ul>';