<?php

class Sort {
	
	function orderBy($data, $field) {
		
		$code = "return strnatcmp(\$a['$field'], \$b['$field']);";
		usort($data, create_function('$a,$b', $code));
		return $data;
		
  	}
	
	function arrayByDay($values){ 
		
/*		$search_strings = array("Monday","Wednesday","Thursday","Friday","Tuesday");
		$replace_string = array('0','2','3','4','1');
		$sort_key = array_map('ucfirst', $values);
		$sort_key = str_replace($search_strings, $replace_string, $sort_key);
		array_multisort($sort_key, SORT_ASC, SORT_STRING, $values);
*/		
		//array_multisort($values,SORT_ASC);
		ksort($values,SORT_NUMERIC);
		return $values;

	}

	
	
}