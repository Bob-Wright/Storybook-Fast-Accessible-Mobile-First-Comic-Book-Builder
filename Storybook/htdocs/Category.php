<?php
/*
 * filename: Category.php
 * this code saves the comic category in the session
*/

// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
session_name("Storybook");
include("/home/bitnami/session2DB/Zebra.php");

// set fallback variable
$category = 'Comic Category'; //fallback
if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST['category'] == '')) { // empty POST then fallback value
	$_SESSION["category"] = $category;
	header("Refresh: 0; URL=./index.php#Category");
	echo "$category is a valid string.<br/><br/>";
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['category'])) && ($_POST['category'] != '')) {
	$category = trim($_POST['category']);
	if(strlen($category) > 32) {$category = '';}
	//sanitize string
	$category = filter_var($category, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);
	if ($category != '') {
		$_SESSION["category"] = $category;
		header("Refresh: 0; URL=./index.php#Category");
		echo "$category is a valid string.<br/><br/>";
	} else {
		$_SESSION["category"] = '';
		header("Refresh: 0; URL=./index.php#Category");
		echo "$category is <strong>NOT</strong> a valid string.<br/><br/>";
	}
}
?>
