<?php
/*
 * filename: Audience.php
 * this code saves the comic intended audience in the session
*/

// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
session_name("Storybook");
include("/home/bitnami/session2DB/Zebra.php");

// set fallback variable
$audience = 'intended audience'; //fallback
if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST['audience'] == '')) { // empty POST then fallback value
	$_SESSION["audience"] = $audience;
	header("Refresh: 0; URL=./index.php#Audience");
	echo "$audience is a valid string.<br/><br/>";
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['audience'])) && ($_POST['audience'] != '')) {
	$audience = trim($_POST['audience']);
	if(strlen($audience) > 32) {$audience = '';}
	//sanitize string
	$audience = filter_var($audience, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);
	if ($audience != '') {
		$_SESSION["audience"] = $audience;
		header("Refresh: 0; URL=./index.php#Audience");
		echo "$audience is a valid string.<br/><br/>";
	} else {
		$_SESSION["audience"] = '';
		header("Refresh: 0; URL=./index.php#Audience");
		echo "$audience is <strong>NOT</strong> a valid string.<br/><br/>";
	}
}
?>
