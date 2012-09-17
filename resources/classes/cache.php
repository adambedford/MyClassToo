<?php

class Cache {
	
	/*
		Overcomes the caching issue arising by specifying access + 2months in .htaccess file.
		Appends a query parameter with the date modified in order to force refresh cache on update
	*/
	
	function autoVer($url){
	  $path = pathinfo($url);
	  $ver = '?ver='.filemtime($_SERVER['DOCUMENT_ROOT'].$url);
	  //echo $path['dirname'].'/'.str_replace('.', $ver, $path['basename']);
	  echo $path['dirname'].'/'.$path['basename'].$ver;
	  
	}
}
	
	
	
	
	
	
	
	
	
	
	
