<?php

class UI {
	
	function notification($type,$msg,$margin) {
		
		/*
			Function returns a formatted and ready-to-display alert containing the message passed to the function in the state
			requested.
			State codes: 1=confirmation/valid, 2=alert/highlight, 3=error
		*/
		
		$class = 'ui-state-';
		$icon = 'ui-icon-';
		if($type==1) {
			$state = 'success';
			$class .= 'success';
			$icon .= 'check';
		} elseif($type==2) {
			$state = 'alert';
			$class .= 'highlight';
			$icon .= 'info';
		} elseif($type==3) {
			$state = 'error';
			$class .= 'error';
			$icon .= 'alert';
		}
		
		return '<div id="response" class="'.$state.' '.$class.' ui-corner-all" style="margin:'.$margin.';"><span class="icon ui-icon '.$icon.'"></span>'.$msg.'</div>';
		
	}
	
	
}

?>