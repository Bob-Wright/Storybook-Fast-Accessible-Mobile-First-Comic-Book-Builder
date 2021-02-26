<?php
/*
 * connect to session_data
 * This table is used for session data
*/
// Database configuration
$dbHost     = 'localhost'; //MySQL_Database_Host
$dbUsername = 'user'; //MySQL_Database_Username
$dbPassword = 'password'; //MySQL_Database_Password
$dbName     = 'Session'; //MySQL_Database_Name
// $Session_DataTable    = 'session_data';
	if(!isset($link)){
		// Connect to the database
		$link = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName)
			or die("Failed to connect with database. "/* . $link->connect_error*/);}
?>