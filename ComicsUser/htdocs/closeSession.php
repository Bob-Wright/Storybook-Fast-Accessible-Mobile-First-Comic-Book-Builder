<?php
error_reporting(E_ALL); // disable this for production code
ini_set('display_errors', TRUE);
/*
 * closeSession.php
 * This file closes the session which logs us out of facebook for the app	
*/
/// Start session
//	@session_start();
session_name("Storybook");
require_once("/home/bitnami/session2DB/Zebra.php");
// Include configuration file
//require_once 'config.php';

// Remove access token from session
unset($_SESSION['facebook_access_token']);

// Remove user data from session
unset($_SESSION['userData']);

// Remove image data from session
unset($_SESSION['imageData']);
//unset($_SESSION['shares']);

// Unset all of the session variables.
$_SESSION = array();
session_unset();

// destroy all session variables
if (session_status() == PHP_SESSION_ACTIVE) { session_destroy(); }

?>