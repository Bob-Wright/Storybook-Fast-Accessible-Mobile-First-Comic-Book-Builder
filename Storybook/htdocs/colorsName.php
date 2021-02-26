<?php
/*
 * filename: colorsName.php
 * this code saves the colorsname in the session
*/

// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
session_name("Storybook");
include("/home/bitnami/session2DB/Zebra.php");
//	session_start();

// set fallback variable
// . \ + * ? ^ $ [ ] ( ) { } < > = ! | :
$colorsname = 'script writer'; //fallback
if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST['colorsname'] == '')) { // empty POST then fallback value
	$pattern = '/(\n|\r\n|\r)/';
	$replacement = '<br>';
	$colorsname = preg_replace($pattern, $replacement, $colorsname);
	$_SESSION["colorsname"] = $colorsname;
	header("Refresh: 0; URL=./index.php");
	echo "$colorsname is a valid string.<br/><br/>";
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['colorsname'])) && ($_POST['colorsname'] != '')) {
	$colorsname = trim($_POST['colorsname']);
	if(strlen($colorsname) > 32) {$colorsname = '';}
	//echo '<br>'.$colorsname.'<br>';
	$pattern = '/(\n|\r\n|\r)/';
	$replacement = '[newline]';
	$colorsname = preg_replace($pattern, $replacement, $colorsname);
	//sanitize string
	$colorsname = filter_var($colorsname, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);
	if ($colorsname != '') {
		$pattern = '/\[newline\]/';
		$replacement = '<br>';
		$colorsname = preg_replace($pattern, $replacement, $colorsname);
		$_SESSION["colorsname"] = $colorsname;
		header("Refresh: 0; URL=./index.php");
		echo "$colorsname is a valid string.<br/><br/>";
	} else {
		$_SESSION["colorsname"] = '';
		header("Refresh: 0; URL=./index.php");
		echo "$colorsname is <strong>NOT</strong> a valid string.<br/><br/>";
	}
}

?>
