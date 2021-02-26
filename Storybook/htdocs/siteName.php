<?php
/*
 * filename: siteName.php
 * this code saves the site name in the session
*/

// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
//	@session_start();
session_name("Storybook");
include("/home/bitnami/session2DB/Zebra.php");

// set fallback variable
$sitename = 'SiteName'; //fallback
if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST['sitename'] == '')) { // empty POST then fallback value
	$_SESSION["sitename"] = $sitename;
	header("Refresh: 1; URL=./index.php");
	echo "$sitename is a valid string.<br/><br/>";
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['sitename'])) && ($_POST['sitename'] != '')) {
	$sitename = trim($_POST['sitename']);
	//sanitize string
	$sitename = filter_var($sitename, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);
	if ($sitename != '') {
		$_SESSION["sitename"] = $sitename;
		header("Refresh: 1; URL=./index.php");
		echo "$sitename is a valid string.<br/><br/>";
	} else {
		$_SESSION["sitename"] = '';
		header("Refresh: 1; URL=./index.php");
		echo "$sitename is <strong>NOT</strong> a valid string.<br/><br/>";
	}
}

?>
