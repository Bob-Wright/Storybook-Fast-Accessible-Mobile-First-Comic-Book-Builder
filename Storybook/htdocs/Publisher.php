<?php
/*
 * filename: Publisher.php
 * this code saves the comic publisher in the session
*/

// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
session_name("Storybook");
include("/home/bitnami/session2DB/Zebra.php");

// set fallback variable
$publisher = 'Comic Publisher'; //fallback
if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST['publisher'] == '')) { // empty POST then fallback value
	$_SESSION["publisher"] = $publisher;
	header("Refresh: 0; URL=./index.php");
	echo "$publisher is a valid string.<br/><br/>";
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['publisher'])) && ($_POST['publisher'] != '')) {
	$publisher = trim($_POST['publisher']);
	if(strlen($publisher) > 32) {$publisher = '';}
	//sanitize string
	$publisher = filter_var($publisher, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);
	if ($publisher != '') {
		$_SESSION["publisher"] = $publisher;
		header("Refresh: 0; URL=./index.php");
		echo "$publisher is a valid string.<br/><br/>";
	} else {
		$_SESSION["publisher"] = '';
		header("Refresh: 0; URL=./index.php");
		echo "$publisher is <strong>NOT</strong> a valid string.<br/><br/>";
	}
}
?>
