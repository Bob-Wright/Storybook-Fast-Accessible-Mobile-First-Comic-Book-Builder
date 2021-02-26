<?php
/*
 * filename: pageTitle.php
 * this code saves the site title in the session
*/

// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
session_name("Storybook");
include("/home/bitnami/session2DB/Zebra.php");

// set fallback variable
$pagetitle = 'An Image Comic'; //fallback
if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST['pagetitle'] == '')) { // empty POST then fallback value
	$_SESSION["pagetitle"] = $pagetitle;
	header("Refresh: 1; URL=./index.php");
	echo "$pagetitle is a valid string.<br/><br/>";
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['pagetitle'])) && ($_POST['pagetitle'] != '')) {
	$pagetitle = trim($_POST['pagetitle']);
	//sanitize string
	$pagetitle = filter_var($pagetitle, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);
	if ($pagetitle != '') {
		$_SESSION["pagetitle"] = $pagetitle;
		header("Refresh: 1; URL=./index.php");
		echo "$pagetitle is a valid string.<br/><br/>";
	} else {
		$_SESSION["pagetitle"] = '';
		header("Refresh: 1; URL=./index.php");
		echo "$pagetitle is <strong>NOT</strong> a valid string.<br/><br/>";
	}
}
?>
