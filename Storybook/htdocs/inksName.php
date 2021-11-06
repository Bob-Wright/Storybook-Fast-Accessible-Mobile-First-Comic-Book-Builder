<?php
/*
 * filename: inksName.php
 * this code saves the inksname in the session
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
$inksname = 'script writer'; //fallback
if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST['inksname'] == '')) { // empty POST then fallback value
	$pattern = '/(\n|\r\n|\r)/';
	$replacement = '<br>';
	$inksname = preg_replace($pattern, $replacement, $inksname);
	$_SESSION["inksname"] = $inksname;
	header("Refresh: 0; URL=./index.php#inksName");
	echo "$inksname is a valid string.<br/><br/>";
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['inksname'])) && ($_POST['inksname'] != '')) {
	$inksname = trim($_POST['inksname']);
	if(strlen($inksname) > 32) {$inksname = '';}
	//echo '<br>'.$inksname.'<br>';
	$pattern = '/(\n|\r\n|\r)/';
	$replacement = '[newline]';
	$inksname = preg_replace($pattern, $replacement, $inksname);
	//sanitize string
	$inksname = filter_var($inksname, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);
	if ($inksname != '') {
		$pattern = '/\[newline\]/';
		$replacement = '<br>';
		$inksname = preg_replace($pattern, $replacement, $inksname);
		$_SESSION["inksname"] = $inksname;
		header("Refresh: 0; URL=./index.php#inksName");
		echo "$inksname is a valid string.<br/><br/>";
	} else {
		$_SESSION["inksname"] = '';
		header("Refresh: 0; URL=./index.php#inksName");
		echo "$inksname is <strong>NOT</strong> a valid string.<br/><br/>";
	}
}

?>
