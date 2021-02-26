<?php
/*
 * filesubtitle: siteSubtitle.php
 * this code saves the site subtitle in the session
*/

// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
//	@session_start();
session_name("Storybook");
include("/home/bitnami/session2DB/Zebra.php");

// set fallback variable
$sitesubtitle = 'SiteSubtitle'; //fallback
if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST['sitesubtitle'] == '')) { // empty POST then fallback value
	$_SESSION["sitesubtitle"] = $sitesubtitle;
	header("Refresh: 1; URL=./index.php");
	echo "$sitesubtitle is a valid string.<br/><br/>";
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['sitesubtitle'])) && ($_POST['sitesubtitle'] != '')) {
	$sitesubtitle = trim($_POST['sitesubtitle']);
	//sanitize string
	$sitesubtitle = filter_var($sitesubtitle, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);
	if ($sitesubtitle != '') {
		$_SESSION["sitesubtitle"] = $sitesubtitle;
		header("Refresh: 1; URL=./index.php");
		echo "$sitesubtitle is a valid string.<br/><br/>";
	} else {
		$_SESSION["sitesubtitle"] = '';
		header("Refresh: 1; URL=./index.php");
		echo "$sitesubtitle is <strong>NOT</strong> a valid string.<br/><br/>";
	}
}

?>
