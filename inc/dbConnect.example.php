<?php
	define('CLIENT_LONG_PASSWORD', 1);
	if (!mysql_connect('localhost', 'panel_helper_user', 'some password for MySQL user', false, CLIENT_LONG_PASSWORD)) {
		die('Could not connect: ' . mysql_error());
	}
	if (!mysql_select_db('panel_helper_db')) {
		die('Could not connect db: ' . mysql_error());
	}
	/*
	if (!mysql_query("SET NAMES 'utf8'")) {
		die('char: ' . mysql_error());
	}	
	*/
?>