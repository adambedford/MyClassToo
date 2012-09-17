<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/resources/config.php');
$college_id = 2;

$classes = array();

$row = 1;
if (($handle = fopen("Classes2.txt", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, "@")) !== FALSE) {
        
/*		$num = count($data);
        echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;
        for ($c=0; $c < $num; $c++) {
            echo $data[$c] . "<br />\n";
        }
*/		

		$name = $data[1];
		
/*		for($x=0;$x<5;$x++) {
		
			$split = split();
			$count = strlen($name);
			$last = $count - 1;
			
			if($split[$last] == ',') {
				$split[$last] = str_replace(',','',$split[$last]);
			}
			
		}
		$string = implode('',$split);
*/
		$classes[] = array(
			"id"		=>	$data[0],
//			"name"		=>	utf8_encode(substr($data[1],'',-2))
			"name"		=> utf8_encode($name)
		);
		
			
    }
    fclose($handle);
	
	foreach($classes as $key=>$val) {
	
		$sqle = "SELECT * FROM tbl_ClassList WHERE cl_course_id = '{$val['id']}' AND cl_college_id = $college_id";
		$qe = mysql_query($sqle) or die(mysql_error());
		
		if(mysql_num_rows($qe) == 0) {
	
			$sql = sprintf("INSERT INTO tbl_ClassList (cl_course_id, cl_class_name, cl_college_id) VALUES ('%s', '%s', %d)",
				mysql_real_escape_string($val['id']),
				mysql_real_escape_string($val['name']),
				mysql_real_escape_string($college_id)
			);
			//echo $sql."<br>";
			//$q = mysql_query($sql) or die(mysql_error());
			//if($q) echo "Success!<br>";
		
		}
		
	}
	
	
//	echo "<pre>";
//	print_r($classes);
//	echo "</pre>";
}
?>