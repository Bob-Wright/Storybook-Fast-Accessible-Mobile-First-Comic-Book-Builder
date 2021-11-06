<?php
/*
 * filename: siteURL.php
 * this code saves the site URL in the session
*/

// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
session_name("Storybook");
include("/home/bitnami/session2DB/Zebra.php");
//	session_start();

// set fallback variable
$siteurl = './'; //fallback
if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST['siteurl'] == '')) { // empty POST then fallback value
	$_SESSION["siteurl"] = $siteurl;
	header("Refresh: 1; URL=./index.php");
	echo "$siteurl is default URL.<br/><br/>";
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['siteurl'])) && ($_POST['siteurl'] != '')) {
	$siteurl = trim($_POST['siteurl']);
	if($siteurl == './') {
		$_SESSION["siteurl"] = $siteurl;
		header("Refresh: 1; URL=./index.php");
		echo "$siteurl is a valid URL.<br/><br/>";
	} else {
		$siteurl = filter_var($_POST['siteurl'], FILTER_SANITIZE_URL);
		if (filter_var($siteurl, FILTER_VALIDATE_URL)) {
			$_SESSION["siteurl"] = $siteurl;
			header("Refresh: 1; URL=./index.php");
			echo "$siteurl is a valid URL.<br/><br/>";
		} else {
			$_SESSION["siteurl"] = '';
			header("Refresh: 1; URL=./index.php");
			echo "$siteurl is <strong>NOT</strong> a valid URL.<br/><br/>";
		}
	}
}
?>
