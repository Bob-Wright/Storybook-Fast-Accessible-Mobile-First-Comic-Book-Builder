<?php
/*
 * filename: scriptName.php
 * this code saves the scriptname in the session
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
$scriptname = 'script writer'; //fallback
if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST['scriptname'] == '')) { // empty POST then fallback value
	$pattern = '/(\n|\r\n|\r)/';
	$replacement = '<br>';
	$scriptname = preg_replace($pattern, $replacement, $scriptname);
	$_SESSION["scriptname"] = $scriptname;
	header("Refresh: 0; URL=./index.php#scriptName");
	echo "$scriptname is a valid string.<br/><br/>";
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['scriptname'])) && ($_POST['scriptname'] != '')) {
	$scriptname = trim($_POST['scriptname']);
	if(strlen($scriptname) > 32) {$scriptname = '';}
	//echo '<br>'.$scriptname.'<br>';
	$pattern = '/(\n|\r\n|\r)/';
	$replacement = '[newline]';
	$scriptname = preg_replace($pattern, $replacement, $scriptname);
	//sanitize string
	$scriptname = filter_var($scriptname, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);
	if ($scriptname != '') {
		$pattern = '/\[newline\]/';
		$replacement = '<br>';
		$scriptname = preg_replace($pattern, $replacement, $scriptname);
		$_SESSION["scriptname"] = $scriptname;
		header("Refresh: 0; URL=./index.php#scriptName");
		echo "$scriptname is a valid string.<br/><br/>";
	} else {
		$_SESSION["scriptname"] = '';
		header("Refresh: 0; URL=./index.php#scriptName");
		echo "$scriptname is <strong>NOT</strong> a valid string.<br/><br/>";
	}
}

?>
