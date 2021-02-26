<?php
/*
 * filename: nameComic.php
 * this code saves the SQL database Comic name
*/

// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
session_name("Storybook");
include("/home/bitnami/session2DB/Zebra.php");
//	session_start();

// set fallback variable
$nameComic = 'AnImageComic'; //fallback
if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST['nameComic'] == '')) { // empty POST then fallback value
	$_SESSION["nameComic"] = $nameComic;
	header("Refresh: 1; URL=./index1.php");
	echo "$nameComic is a valid string.<br/><br/>";
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['nameComic'])) && ($_POST['nameComic'] != '')) {
	$nameComic = trim($_POST['nameComic']);
	//sanitize string
	if (preg_match('/^([A-Za-z0-9]+$)/', $nameComic)) {
		$_SESSION["nameComic"] = $nameComic;
		header("Refresh: 1; URL=./index1.php");
		echo "$nameComic is a valid string.<br/><br/>";
	} else {
		$_SESSION["nameComic"] = '';
		header("Refresh: 1; URL=./index1.php");
		echo "$nameComic is <strong>NOT</strong> a valid string.<br/><br/>";
	}
}
?>
