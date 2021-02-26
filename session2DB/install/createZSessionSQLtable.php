<?php
/*
 * createZSessionSQLtable.php
 * calls the buildZSession_DataTable.class to create a table named
 * session_data
 * This table is used for session data
*/
error_reporting(E_ALL); //disable for production
ini_set('display_errors', TRUE);

// Start session
if (session_status() == PHP_SESSION_NONE) {
//if(session_id() == ""){
	@session_start();}
require_once("/home/bitnami/session2DB/install/buildZSession_DataTable.class.php");

    $sessionData = new buildSession_DataTable();

	// try to create new data table
    $Data = $sessionData->createTable();
	
// Unset all of the session variables.
$_SESSION = array();
session_unset();

// destroy all session variables
if (session_status() == PHP_SESSION_ACTIVE) { session_destroy(); }

?>