<?php
error_reporting(E_ALL); // disable this for production code
ini_set('display_errors', TRUE);
/*
 * logout.php
 * This file closes the session which logs us out of facebook for the app	
*/
// Start session
session_name("Storybook");
require_once("/home/bitnami/session2DB/Zebra.php");

if(isset($_SESSION['logoutMsg'])) {
	$logoutMsg = $_SESSION['logoutMsg'];
} else {
	$logoutMsg = '';
	$logoutMsg .= '<!DOCTYPE HTML><br>'; 
	$logoutMsg .= '<html lang="en"><br>'; 
	$logoutMsg .= '<head><br>'; 
	$logoutMsg .= '<meta http-equiv="x-ua-compatible" content="ie=edge"><br>';
	$logoutMsg .= '<link rel="stylesheet" type="text/css" href="./css/SiteStyles.css"><br>'; 
	$logoutMsg .= '<title>Logout</title><br>'; 
	$logoutMsg .= '</head><br>'; 
	$logoutMsg .= '<body><br>'; 
	$logoutMsg .= '<div id="Logout"><br>'; 
	$logoutMsg .= '<h1>Returning to Synthetic Reality.</h1>';
	$logoutMsg .= '</div><br>'; 
	$logoutMsg .= '</html>';
}

// Remove access token from session
unset($_SESSION['facebook_access_token']);

// Remove user data from session
unset($_SESSION['userData']);

// Remove image data from session
unset($_SESSION['imageData']);

// Unset all of the session variables.
$_SESSION = array();
session_unset();

// destroy all session variables
if (session_status() == PHP_SESSION_ACTIVE) { session_destroy(); }

// Redirect to the homepage
$seconds = 1;
$location = "https://syntheticreality.net/Comics/Comics.html";
header ("Refresh: $seconds; URL=$location");
echo $logoutMsg;
?>