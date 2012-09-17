<?php

/*
	The important thing to realize is that the config file should be included in every
	page of your project, or at least any page you want access to these settings.
	This allows you to confidently use these settings throughout a project because
	if something changes such as your database credentials, or a path to a specific resource,
	you'll only need to update it here.
*/

$config = array(
	"info" => array(
		"title"		=> "MyClassToo.com: Making class schedules social" //or 'easily share your class schedule with those who need it//
		),
	"urls" => array(
		"baseUrl"	=> "http://myclasstoo.com",
		"registerUrl"	=> "http://myclasstoo.com/resources/authentication/fbregister.php"
	),
	"paths" => array(
		"resources" => "/resources",
		"images" => array(
			"content" => $_SERVER["DOCUMENT_ROOT"] . "/images/content",
			"layout" => $_SERVER["DOCUMENT_ROOT"] . "/images/layout"
		)
	)
);


/*
	Include database configuration files (in db.php)
*/
	
	include('db.php');

/*
	I will usually place the following in a bootstrap file or some type of environment
	setup file (code that is run at the start of every page request), but they work
	just as well in your config file if it's in php (some alternatives to php are xml or ini files).
*/

/*
	Creating constants for heavily used paths makes things a lot easier.
	ex. require_once(LIBRARY_PATH . "Paginator.php")
*/
defined("LIBRARY_PATH")
	or define("LIBRARY_PATH", realpath(dirname(__FILE__) . '/lib'));

defined("AUTH_PATH")
	or define("AUTH_PATH", realpath(dirname(__FILE__) . '/auth'));
	
defined("CLASS_PATH")
	or define("CLASS_PATH", realpath(dirname(__FILE__) . '/classes'));
	
defined("MODULE_PATH")
	or define("MODULE_PATH", realpath(dirname(__FILE__) . '/modules'));
	
defined("STYLE_PATH")
	or define("STYLE_PATH",$_SERVER["DOCUMENT_ROOT"] . '/css');
	
defined("JS_PATH")
	or define("JS_PATH", $_SERVER["DOCUMENT_ROOT"] . '/js');
	
defined("CORE_PATH")
	or define("CORE_PATH", $_SERVER["DOCUMENT_ROOT"] . '/core');
	
defined("STATIC_PATH")
	or define("STATIC_PATH", $_SERVER["DOCUMENT_ROOT"] . '/static_pages');	
	
/*
	Error reporting.
*/
ini_set("error_reporting", "true");
error_reporting(E_ALL|E_STRCT);


/*
	Define AJAX request
*/
defined("IS_AJAX")
	or define("IS_AJAX", isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

?>