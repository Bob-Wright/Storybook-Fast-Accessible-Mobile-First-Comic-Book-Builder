<?php
/*
 * This file closes the session
*/
// Start session
if ((session_status() == PHP_SESSION_NONE) || (session_status() !== PHP_SESSION_ACTIVE)) {
//if(session_id() == ""){
session_name("Storybook");
include("/home/bitnami/session2DB/Zebra.php");
//	session_start();

// Unset all of the session variables.
$_SESSION = array();
session_unset();

// destroy all session variables
if (session_status() == PHP_SESSION_ACTIVE) { session_destroy(); }

//remove PHPSESSID from browser
if(isset($_COOKIE[session_name()])) {
setcookie(session_name(), "", time()-3600, "/" );}
}

$seconds = 1;
$location = "https://syntheticreality.net/Comics/Comics.html";
header ("Refresh: $seconds; URL=$location");
echo 'session closed<br>';
?>