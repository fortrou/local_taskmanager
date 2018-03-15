<?php
	ini_set('display_errors','Off');
	require_once('functions.php');
	if(!function_exists("__autoload")) {
		function __autoload($name)
		{
			require 'class' . $name . '.php';
		}
	}
	$db = Database::getInstance();
	$mysqli = $db->getConnection();
?>